<template>
  <section>
    <div class="content-header">
      <h1>
        My orders
        <small>Her kan du få en oversigt over dine ordre</small>
      </h1>

      <v-btn color="primary" @click="goto('module.shop.orders.create')">
        Opret ordre
      </v-btn>
    </div>

    <!-- COMPONENT -->
    <Table 
      :headers="headers" 
      :sorting="sorting"
      :route="route" 
      :include="include"
      :table="table"
    >

      <!-- Kunde-visning -->
      <template #item.customer="{ item }">
        <div v-if="item.customer">
          {{ item.customer.first_name }} {{ item.customer.last_name }}<br />
          <small>{{ item.customer.email }}</small>
        </div>
        <div v-else>
          <em>Ingen</em>
        </div>
      </template>

      <!-- Produkter-visning -->
      <template #item.items="{ item }">
        <ul v-if="item.items && item.items.length">
          <li v-for="product in item.items" :key="product.id">
         
            {{ product.product_name }} (x{{ product.quantity }}) - {{ product.price }} kr
          </li>
        </ul>
        <div v-else>
          <em>Ingen produkter</em>
        </div>
      </template>

    </Table>
  </section>
</template>

<script>
import TableIndex from "@/Mixins/TableIndex";
import TableLoginButton from "@/Components/table/collums/TableLoginButton.vue";

export default {
  mixins: [TableIndex],

  components: {
    TableLoginButton,
  },

  data() {
    return {
      table: "shop_orders",
      route: "shop.orders",
      headers: [
        { text: "Beskrivelse", value: "description" }, 
        { text: "Kunde", value: "customer" },
        { text: "Produkter", value: "items" },
        { text: "Betalingsmetode", value: "payment_method" },
        { text: "Betalingsstatus", value: "payment_status" },
        { text: "Status", value: "status" },
        { text: "Betalt", value: "paid_at" },
        { text: "Refunderet", value: "refunded_at" },
        { text: "Dato", value: "created_at" },
        { text: "", value: "actions" },
      ],
      include: "items,customer",
      selected: [],
      sorting: null,
      send_invite_open_prompt: false
    };
  },

  methods: {
    truncateContent(content) {
      if (!content) return "";
      return content.length > 200 ? content.slice(0, 200) + "..." : content;
    },
  },
};
</script>

<style scoped>
#userInvitationList {
  overflow: auto;
  height: auto;
  max-height: 150px;
}
</style>

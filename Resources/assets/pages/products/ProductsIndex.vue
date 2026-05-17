<template>
  <section>


    <div class="content-header">
      <h1>
        My products
        <small>Her kan du få en oversigt over dine produkter</small>
      </h1>


      <v-btn color="primary" @click="goto('module.shop.products.create')">
        Opret produkt
      </v-btn>
    </div>


    <!-- COMPONENT -->
    <Table 
    :headers="headers" 
    :route="route" 
    :table="table"
    >

      <template #item.content="{ item }">
        <span v-html="truncateContent(item.content)"></span>
   
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
      table: "shop_products",
      route: "shop.products",

      headers: [
        { text: "Navn", value: "name" }, 
        { text: "Slug", value: "slug" },
        { text: "Dato", value: "created_at" },
        { text: "", value: "actions" },
       
      ],

      selected: [],
      send_invite_open_prompt: false,
    };

  },


  methods: {
    
    truncateContent(content) {
      if (!content) return "";
      return content.length > 200 ? content.slice(0, 200) + "..." : content;
    },

  },

  mounted() {
    // optional logic
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

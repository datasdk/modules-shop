<template>
  <section v-if="items && items.length" >
    <h4>Købsoversigt</h4>
    <p>På denne liste fremgår de varer/ydelser, som kunden har købt</p>

    <table class="table mt-4">
      <thead>
        <tr>
          <th>Produktnavn</th>
          <th>Beskrivelse</th>
          <th>Antal</th>
          <th>Pris</th>
          <th>Rabat</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in items" :key="item.id">
          <td>{{ item.product_name?.da || '-' }}</td>
          <td v-html="item.description?.da || ''"></td>
          <td>{{ item.quantity }}</td>
          <td>{{ formatPrice(item.price) }}</td>
          <td>{{ formatPrice(item.discount) }}</td>
          <td>{{ formatPrice(itemTotal(item)) }}</td>
        </tr>
      </tbody>
    </table>
    <table class="table">
        <tr>
          <th colspan="5" class="text-right">Subtotal (uden moms)</th>
          <td>{{ formatPrice(subtotal) }}</td>
        </tr>
        <tr>
          <th colspan="5" class="text-right">Moms ({{ (vatRate * 100).toFixed(0) }}%)</th>
          <td>{{ formatPrice(vatAmount) }}</td>
        </tr>
        <tr>
          <th colspan="5" class="text-right">Total (inkl. moms)</th>
          <td><strong>{{ formatPrice(total) }}</strong></td>
        </tr>
      </tfoot>
    </table>
  </section>
</template>

<script>
export default {
  name: "PurchaseSummary",

  props: {
    items: {
      type: Array,
      required: true,
      default: () => [],
    },
    vatRate: {
      // moms sats, fx 0.25 for 25%
      type: Number,
      default: 0.25,
    },
  },

  computed: {
    totalQuantity() {
      return this.items.reduce((sum, item) => sum + (item.quantity || 0), 0);
    },

    subtotal() {
      // Sum af (pris * antal - rabat) uden moms
      return this.items.reduce((sum, item) => {
        const price = item.price || 0;
        const quantity = item.quantity || 0;
        const discount = item.discount || 0;
        return sum + (price * quantity - discount);
      }, 0);
    },

    vatAmount() {
      return this.subtotal * this.vatRate;
    },

    total() {
      return this.subtotal + this.vatAmount;
    },
  },

  methods: {
    itemTotal(item) {
      const price = item.price || 0;
      const quantity = item.quantity || 0;
      const discount = item.discount || 0;
      return price * quantity - discount;
    },

    formatPrice(value) {
        const number = Number(value);
        if (isNaN(number)) return '-';
        return number.toFixed(2) + ' kr';
    }

  },
};
</script>

<style scoped>
.text-right {
  text-align: right;
}
</style>

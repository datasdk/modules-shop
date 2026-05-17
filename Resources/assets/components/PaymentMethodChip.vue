<template>
  <div class="payment-method">
    <span :class="['mdi', icon, 'mr-1']"></span>
    {{ translatedMethod }}
  </div>
</template>

<script>
export default {
    
  name: "PaymentMethodDisplay",

  props: {
    method: {
      type: String,
      required: true
    }
  },

  computed: {

    translatedMethod() {

      switch (this.method) {
        case "credit_card": return "Betalingskort";
        case "paypal": return "PayPal";
        case "cash": return "Kontant";
        default: return this.method;

      }

    },

    icon() {

      switch (this.method) {

        case "credit_card": return "mdi-credit-card-outline"; // opdateret
        case "paypal": return "mdi-paypal";
        case "cash": return "mdi-cash";
        default: return "mdi-help-circle-outline";

      }

    }
  }
};
</script>

<style scoped>
.payment-method {
  display: flex;
  align-items: center;
}
.mr-1 {
  margin-right: 4px;
}
</style>

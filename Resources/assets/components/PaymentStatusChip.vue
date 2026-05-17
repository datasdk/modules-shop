<template>
  <v-chip
    :color="chipColor"
    text-color="white"
    small
  >
    {{ translatedStatus }}
  </v-chip>
</template>

<script>
export default {
  name: "PaymentStatusChip",
  props: {
    status: {
      type: String,
      required: true
    }
  },
  computed: {
    translatedStatus() {
      switch (this.status) {
        case "pending": return "Afventer";
        case "paid": return "Betalt";
        case "failed": return "Mislykket";
        case "refunded": return "Refunderet";
        default: return this.status;
      }
    },
    chipColor() {
      switch (this.status) {
        case "pending": return "orange";
        case "paid": return "green";
        case "failed": return "red";
        case "refunded": return "blue";
        default: return "grey";
      }
    }
  }
};
</script>

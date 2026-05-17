<template>
  <section>
    <v-chip
      v-if="paidAt"
      color="green lighten-4"
      text-color="green darken-3"
      small
      class="ma-1"
    >
      {{ paidAt }}
    </v-chip>

    <v-chip
      v-else
      color="red lighten-4"
      text-color="red darken-2"
      small
      class="ma-1"
    >
      Ikke betalt
    </v-chip>
  </section>
</template>

<script>
export default {
  name: "PaidAtDisplay",
  props: {
    paidAt: {
      type: [String, Date, null],
      default: null,
    },
  },
};
</script>

<style scoped>
/* Valgfri ekstra styling */
</style>

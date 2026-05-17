<template>
  <section>

    <Loading v-if="loading" />

    <div v-else>


      <div class="content-header">
        <h1>
          Rediger produkt
          <small>Her kan du redigere dit produkt.</small>
        </h1>
      </div>


      <table class="table">
        <tr>
          <th colspan="2">Produkt</th>
        </tr>

        <tr>
          <td width="150">Navn</td>
          <td>

            <TextField name="name" v-model="input.name" />

          </td>
        </tr>

        <tr>
          <td>Beskrivelse</td>
          <td>

            <TextEditor name="description" v-model="input.description" />

          </td>
        </tr>

        <tr>
          <td>Pris</td>
          <td>
          
            <input name="price" type="number" step="0.01" v-model="input.price" class="form-control"/>
          </td>
        </tr>

        <tr>
          <td>Status</td>
          <td>

              <select v-model="input.status" class="form-control">
                <option disabled value="">Vælg status</option>
                <option v-for="option in statusOptions" :key="option.value" :value="option.value">
                  {{ option.text }}
                </option>
              </select>

          </td>
        </tr>

      </table>


      <SelectCategories
        type="products"
        v-model="input.categories"
        :checked="false"
      />


      <v-btn color="primary" @click="submit()" :loading="submitLoading">Gem produkt</v-btn>

      <v-btn @click="goto('products.index')">Annuller</v-btn>

    </div>
  </section>
</template>

<script>

import TableEdit from "@/Mixins/TableEdit";


export default {

  mixins: [TableEdit],

  data() {
    return {
      loading: true,
      input: {
        name: "",
        description: "",
        price: 0.0,
        category_id: null,
        brand_id: null,
        stock_quantity: 0,
        is_active: true,
        status: "active",
        image_url: "",
      },
      categories: [],
      brands: [],

      statusOptions: [
        { text: 'Aktiv', value: 'active' },
        { text: 'Kladde', value: 'draft' },
        { text: 'Skjult', value: 'hidden' },
        { text: 'Arkiveret', value: 'archived' },
        { text: 'Kommer snart', value: 'coming_soon' },
        { text: 'Utilgængelig', value: 'unavailable' },
        { text: 'Deaktiveret', value: 'disabled' },
      ]


    };
  },

  methods: {

    async get() {

      if (!this.id) {

        this.loading = false;

        return;

      }


      const res = await axios.get(route("api.shop.products.show", { id: this.id }),{
        params: {
          include: "categories"
        }
      });

      this.input = res.data.data;

      this.loading = false;

    },


    update() {

      return axios
        .patch(route("api.shop.products.update", { id: this.id }), this.input)
        .then(() => this.$router.push({ name: "module.shop.products.index" }));

    },

    create() {

      return axios
        .post(route("api.shop.products.store"), this.input)
        .then(() => this.$router.push({ name: "module.shop.products.index" }));

    },
  },

  async mounted() {
    await this.get();

  },

};
</script>

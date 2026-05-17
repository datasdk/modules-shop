<template>
  <section>


    <Loading v-if="main_loading" :type="2" />

    <div v-else>

     

      <!-- Hvis et produkt er valgt -->
      <div v-if="product">

        <div class="choosen-product">

          <img
            v-if="product.image"
            :src="product.image"
            width="50"
            alt="Produktbillede"
          />

          {{ product.name }} – {{ product.price }} DKK


          <span @click="remove" class="close">X Fjern produkt</span>

          <span class="float-right text-muted pr-3">id: {{ product.id }}</span>

        </div>

      </div>


      <!-- Hvis intet produkt er valgt -->
      <div v-else class="pb-3">


        <input
          type="text"
          ref="productsearch"
          v-model="searchtext"
          class="form-control mb-3"
          placeholder="Søg produkt (navn, kategori, etc.)"
          @input="search"
        />


        <div class="p-2 d-flex" v-if="loading">

          <Loading :type="2" />

          <div class="pl-5">Henter produkter...</div>

        </div>

        <div v-else-if="products.length">


          <div class="mt-3 mb-3">
            <strong>Vælg produkt fra listen:</strong>
          </div>


          <ul>
            <li
              v-for="product in products"
              :key="product.id"
              class="product pl-4 pr-4"
              @click="choose(product)"
            >
              <span>{{ product.name }}</span>
              <span class="float-right text-muted">ID: {{ product.id }}</span>
              <span class="float-right pr-3">{{ product.price }} DKK</span>
            </li>
          </ul>


        </div>

        <div v-else-if="noProductFound">
          <v-alert color="info">Ingen produkter fundet</v-alert>
        </div>

        <div v-if="notFound" class="text-danger">
          Produktet blev ikke fundet, og er muligvis blevet slettet!
        </div>


      </div>

    </div>

  </section>
</template>

<script>
export default {

  name: "SelectProduct",

  props: {
    value: { required: true },
    return_object: { default: false }
  },

  data() {
    return {
      products: [],
      product: null,
      loading: false,
      main_loading: false,
      product_id: this.value,
      searchtext: "",
      timeout: null,
      notFound: false,
      minChars: 2
    };
  },

  computed: {

    noProductFound() {

      return !this.products.length && this.searchtext.length >= this.minChars;

    }

  },

  methods: {

    async search() {


      clearTimeout(this.timeout);


      if (this.searchtext.length >= this.minChars) {

        this.loading = true;
        this.notFound = false;


        this.timeout = setTimeout(async () => {

          try {

            const response = await axios.post(
              route("api.shop.products.search"),
              { 
                search: { 
                  value: this.searchtext 
                } 
              },
              { 
                params: { 
                  limit: 5,
                  lang: this.$i18n.locale
                } 
              }
            );

            this.products = response.data.data;

          } catch (error) {

            console.error("Fejl ved søgning:", error);

          } finally {

            this.loading = false;

          }
        }, 1000);


      }
    },

    choose(product) {

      this.product = product;
      this.searchtext = "";
      this.products = [];

      const value = this.return_object ? product : product.id;

      this.$emit("changed", this.return_object);
      this.$emit("input", value);
    },

    remove() {
      this.product = null;
      this.$emit("input", null);
    }

  },

  watch: {

    value(val) {

      if (!val) {
        this.remove();
      }

    }

  },

  async mounted() {

    if (this.product_id) {

      this.main_loading = true;

      try {

        const response = await axios.get(route("api.shop.products.show", { id: this.product_id }));

        this.product = response.data.data;

      } catch (error) {

        if (error.response && error.response.status === 404) {

          this.product_id = undefined;
          this.notFound = true;

        }

      } finally {

        this.main_loading = false;

      }

    }
  }
};
</script>

<style scoped>
.choosen-product,
.product {
  padding: 10px 15px;
  border: 1px solid #ddd;
  background: #f5f5f5;
  margin-bottom: 5px;
}

.product:hover {
  background: #fff;
  cursor: pointer;
}

.close {
  float: right;
  padding: 5px;
  font-size: 12px;
  cursor: pointer;
}
</style>

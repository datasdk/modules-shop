<template>
  <section>

    <div class="clearfix">
      <div class="float-left">
        <h4>Produkter</h4>
        <p>Søg efter produkter og tilføj dem fra dit lager</p>
      </div>

      <v-btn color="primary" @click="dialog = true" class="float-right"><span class="mdi mdi-plus"></span> Tilføj produkt</v-btn>
    </div>

    <div v-if="localProducts.length === 0">
      <v-alert type="info" class="w-100 mt-4">
        Der er endnu ikke tilføjet nogen produkter til ordren.
      </v-alert>
    </div>

    <div v-else>
      <table class="table mt-4">
        <thead>
          <tr>
            <th>Navn</th>
            <th>Pris</th>
            <th>Antal</th>
            <th>Rabat</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(product, index) in localProducts" :key="product.id">
            <td>{{ product.name }}</td>
            <td>{{ formatPrice(product.price) }} DKK</td>
            <td>{{ product.quantity }}</td>
            <td></td>
            <td>
              <v-btn icon @click="removeProduct(index)">
                <v-icon>mdi-delete</v-icon>
              </v-btn>
            </td>
          </tr>
        </tbody>
      </table>

      <table  class="table">
   
          <tr>
            <td>Subtotal (uden moms):</td>
            <td align="right">{{ formatPrice(subtotal) }} DKK</td>
          </tr>
          <tr>
            <td>Moms (25%):</td>
            <td align="right">{{ formatPrice(vat) }} DKK</td>
          </tr>
          <tr>
            <td>Total (inkl. moms):</td>
            <td align="right">{{ formatPrice(total) }} DKK</td>
          </tr>

      </table>
    </div>

    <v-dialog v-model="dialog" max-width="600px">
      <v-card>
        <v-card-title>Tilføj produkt</v-card-title>
        <v-card-subtitle>Søg efter produkter og tilføj dem fra dit lager</v-card-subtitle>
        <v-card-text>
          <div class="mb-2">
            <strong>Produkt</strong>
            <SelectProduct
              v-model="product"
              :return_object="true"
            />
          </div>

          <label>
            <strong>Antal</strong>
            <input
              v-model.number="selectedQuantity"
              type="number"
              min="1"
              class="mt-4 form-control"
            />
          </label>
        </v-card-text>
        <v-card-actions>
          <v-spacer />
          <v-btn text @click="dialog = false">Annuller</v-btn>
          <v-btn color="primary" @click="addProduct">Tilføj</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

  </section>
</template>

<script>
import axios from "axios";

export default {
  name: "OrderProductsEditor",

  props: {
    value: {
      required: true,
    },
  },

  data() {
    return {
      localProducts: [],
      productOptions: [],
      product: null, // det valgte produkt fra SelectProduct
      selectedQuantity: 1,
      dialog: false,
    };
  },

  watch: {
    value: {
      immediate: true,
      handler(val) {
        this.localProducts = [...val];
      },
    },
  },

  computed: {
    totalQuantity() {
      return this.localProducts.reduce((sum, p) => sum + p.quantity, 0);
    },

    subtotal() {
      // sum af (pris * antal) uden moms
      return this.localProducts.reduce((sum, p) => sum + p.price * p.quantity, 0);
    },

    vat() {
      // 25% moms af subtotal
      return this.subtotal * 0.25;
    },

    total() {
      return this.subtotal + this.vat;
    },
  },

  methods: {
    addProduct() {
      if (this.product && this.selectedQuantity > 0) {
        const newProduct = {
          ...this.product,
          quantity: this.selectedQuantity,
        };

        this.localProducts.push(newProduct);
        this.emitProducts();

        // nulstil form
        this.product = null;
        this.selectedQuantity = 1;
        this.dialog = false;
      } else {
        console.warn("Produkt ikke valgt eller antal ugyldigt");
      }
    },

    removeProduct(index) {
      this.localProducts.splice(index, 1);
      this.emitProducts();
    },

    emitProducts() {
      this.$emit("input", this.localProducts);
    },

    formatPrice(value) {
      if (typeof value !== "number") {
        return value;
      }
      return value.toFixed(2);
    },
  },

  async mounted() {
    const res = await axios.get(route("api.shop.products.index"));
    this.productOptions = res.data.data;
  },
};
</script>

<template>
  <section>
    
    <Loading v-if="loading" />

    <div v-else>

      <div class="content-header">
        <h1>
          Rediger ordre
          <small>Her kan du redigere ordreoplysninger og tilføje produkter.</small>
        </h1>
      </div>


      <div class="mb-5">


        <table class="table ">
          <tr>
            <th colspan="2">Ordre</th>
          </tr>

          <tr>
            <td width="150">Beskrivelse</td>
            <td>
              <TextArea v-model="input.description" />
            </td>
          </tr>

          <tr>
            <td width="150">Betalingsmetode</td>
            <td>
            
              <select class="form-control" v-model="input.payment_method">
                <option disabled value="0">Vælg metode</option>
                <option value="credit_card">Kreditkort</option>
                <option value="paypal">PayPal</option>
                <option value="bank_transfer">Bankoverførsel</option>
                <option value="mobilepay">MobilePay</option>
              </select>
            </td>
          </tr>

          <tr>
            <td width="150">Ordrestatus</td>
            <td>
              <select class="form-control" v-model="input.status">
                <option disabled value="">Vælg status</option>
                <option value="draft">Udkast</option>
                <option value="confirmed">Bekræftet</option>
                <option value="shipped">Afsendt</option>
                <option value="cancelled">Annulleret</option>
              </select>
            </td>
          </tr>


          <tr>
            <td width="150">Betalingsstatus</td>
            <td>
              <select class="form-control" v-model="input.payment_status">
                <option disabled value="0">Vælg status</option>
                <option value="paid">Betalt</option>
                <option value="unpaid">Ikke betalt</option>
                <option value="failed">Fejlet</option>
                <option value="refunded">Refunderet</option>
              </select>
            </td>
          </tr>

          <tr>
            <td width="150">Kunde</td>
            <td> 
              <label>
              
                <input type="radio" v-model="input.new_user" :value="0"> Eksisterende kunde
              </label>
              <label class="ml-4">
                <input type="radio" v-model="input.new_user" :value="1"> Ny Kunde
              </label>
            </td>
          </tr>

          <tr v-if="input.new_user == 0">

            <td width="150">Kunde</td>
            <td>

              <SelectUser
                v-model="input.user_id"
                @submit="getCustomerData"
              />

            </td>
          </tr>

          <tbody v-if="input.new_user == 1">
            <tr>
              <td colspan="2">Ny kunde</td>
            </tr>
            <tr>
              <td>Fornavn</td>
              <td>
                <input type="text" class="form-control" v-model="customer.first_name" />
              </td>
            </tr>
            <tr>
              <td>Mellemnavn</td>
              <td>
                <input type="text" class="form-control" v-model="customer.middle_name" />
              </td>
            </tr>
            <tr>
              <td>Efternavn</td>
              <td>
                <input type="text" class="form-control" v-model="customer.last_name" />
              </td>
            </tr>
            <tr>
              <td>E-mail</td>
              <td>
                <input type="email" class="form-control" v-model="customer.email" />
              </td>
            </tr>
            <tr>
              <td>Telefon</td>
              <td>
                <input type="tel" class="form-control" v-model="customer.contact.phone" />
              </td>
            </tr>
            
            <tr>
              <td>Opret som bruger</td>
              <td>
                <input type="checkbox" v-model="input.save_user" />
              </td>
            </tr>

            <tbody v-if="input.save_user">

              <tr>
                <td>Lad brugeren selv vælge password</td>
                <td>
                  <input type="checkbox" v-model="customer.invite" />
                </td>
              </tr>

              <tr v-if="!customer.invite">
                <td>Password</td>
                <td>
                  <input type="text" class="form-control" v-model="customer.password" />
                </td>
              </tr>

            </tbody>
          </tbody>
        </table>

      </div>


      <div class="mb-5">

        <PurchaseSummary :items="input.items" />

      </div>      
      

      <div class="mb-5">

        <OrderProductsEditor v-model="input.products" />

      </div>

      <div>

        <v-btn color="primary" @click="submit()" :loading="submitLoading">Gem ordre</v-btn>

        <v-btn @click="goto('orders.index')">Annuller</v-btn>

      </div>
      
    

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
        id: null,
        description: undefined,
        customer: null,
        products: [],
        new_user: 0,
        save_user: 1,
        payment_method: "credit_card",
        payment_status: "unpaid",
        status: "confirmed",
        user_id: undefined,
        items: []
      },
      customer: {
        first_name: undefined,
        middle_name: undefined,
        last_name: undefined,
        email: undefined,
        contact: {
          phone: undefined
        },
        invite: false,
        password: undefined
      },
      productOptions: [],
      selectedProduct: null,
      selectedQuantity: 1,
      dialog: false,
    };
  },

  methods: {

    async get() {

      const res = await axios.get(route("api.shop.orders.show", { id: this.id }),{
        params: {
          include: "items"
        }
      });

      this.input = res.data.data;
      this.input.new_user = 0

      this.input.products = this.input.products || [];
      this.loading = false;

    },

    async loadProducts() {
      const res = await axios.get(route("api.shop.products.index"));
      this.productOptions = res.data.data;
    },

    addProduct() {
      if (this.selectedProduct && this.selectedQuantity > 0) {
        this.input.products.push({
          ...this.selectedProduct,
          quantity: this.selectedQuantity
        });
        this.selectedProduct = null;
        this.selectedQuantity = 1;
        this.dialog = false;
      }
    },

    getCustomerData(customer){


    },

    removeProduct(index) {
      this.input.products.splice(index, 1);
    },

    update() {

      return axios
        .patch(route("api.shop.orders.update", { id: this.id }), this.input)
        .then(() => this.$router.push({ name: "module.shop.orders.index" }));

    },

    create() {

      return axios
        .post(route("api.shop.orders.store"), this.input)
        .then(() => this.$router.push({ name: "module.shop.orders.index" }));

    }
   
  },

  async mounted() {
    await this.loadProducts();
  },
};
</script>

<style scoped>
.form-group {
  margin-bottom: 1rem;
}
</style>

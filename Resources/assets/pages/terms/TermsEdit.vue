<template>
  <section>

    <Loading v-if="loading" />


    <div v-else>

      <div class="content-header">
        <h1>
          Rediger vilkår
          <small>Her kan du redigere titel og indhold for vilkår.</small>
        </h1>
      </div>


      <table class="table">
        <tr>
          <th colspan="2">Vilkår</th>
        </tr>

        <tr>
          <td width="150">Titel</td>
          <td>

            <TextField 
                name="name" 
                v-model="input.title" 
            />

          </td>
        </tr>

    

        <tr>
            <td>Indhold </td>
            <td>

                <TextEditor
                    name="name" 
                    v-model="input.content" 
                />

            </td>
        </tr>
      </table>


      <v-btn color="primary" @click="submit()" :loading="submitLoading">Gem handelsbetingelser</v-btn>

      <v-btn @click="goto('terms.index')">Annuller</v-btn>

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
        title: undefined,
        content: undefined
      }
    };
  },

  methods: {

    async get() {

      const res = await axios.get(route("api.shop.terms.show", { id: this.id }));

      this.input = res.data.data;

      this.loading = false;

    },


    update() {

      return axios
        .patch(route("api.shop.terms.update", { id: this.id }), this.input)
        .then(() => this.$router.push({ name: "module.shop.terms.index" }));

    },

    create() {

      return axios
        .post(route("api.shop.terms.store"), this.input)
        .then(() => this.$router.push({ name: "module.shop.terms.index" }));

    }

  }

};
</script>

<template>
  <Layout>
    <template #title>
      <h2>Paste the URL to be shortened</h2>
    </template>
    <template #subtitle>
      <h6>*Your url will expire in 5 minutes</h6>
    </template>
    <template #body>
      <v-row>
        <v-col>
          <v-text-field v-model="url"
                        placeholder="Add url..."
                        hide-details
                        variant="outlined"
                        single-line
                        class="pa-0"
                        rules="required">
            <template #append-inner>
              <v-btn @click="submit" :loading="isLoading" icon color="primary">
                <v-icon>mdi-send</v-icon>
              </v-btn>
            </template>
          </v-text-field>
        </v-col>
      </v-row>
      <v-row>
        <v-col>
          <v-alert
              v-if="success"
              title="Url is generated"
              type="success"
          >
            <template #text>
                <p>Shorten Url: <a :href="data.short_url" target="_blank">{{ data.short_url }}</a></p>
                <p v-if="url !== data.original">Original Url: <a :href="data.original" target="_blank">{{ data.original }}</a></p>
                <p v-if="data.clicks > 0">Clicks: {{ data.clicks }}</p>
            </template>
          </v-alert>
          <v-alert
              v-if="error"
              :text="error"
              title="Url can not be generated"
              type="error"
          ></v-alert>
        </v-col>
      </v-row>
    </template>
  </Layout>
</template>
<script>
import {mapActions, mapGetters} from "vuex";
import Layout from "../../layouts/Layout.vue";

export default {
  components: {Layout},
  data() {
    return {
      url: ''
    }
  },
  computed: {
    ...mapGetters(['data', 'isLoading', 'success', 'error'])
  },
  methods: {
    ...mapActions(['store']),

    async submit() {
      await this.store({
        original: this.url
      })
    }
  }
}

</script>
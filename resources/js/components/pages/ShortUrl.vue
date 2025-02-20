<template>
  <Layout>
    <template #title>
      <h2>Paste the URL to be shortened</h2>
    </template>
    <template #subtitle>
    </template>
    <template #body>
      <v-row>
        <v-col>
          <v-text-field v-model="selectedUrl"
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
                <p>Shorten Url: <a :href="url.short_url" target="_blank">{{ url.short_url }}</a></p>
                <p v-if="url !== url.original">Original Url: <a :href="url.original" target="_blank">{{ url.original }}</a></p>
                <p v-if="url.clicks > 0">Clicks: {{ url.clicks }}</p>
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
      selectedUrl: ''
    }
  },
  computed: {
    ...mapGetters(['url', 'isLoading', 'success', 'error'])
  },
  methods: {
    ...mapActions(['store']),

    async submit() {
      await this.store({
        original: this.selectedUrl
      })
    }
  }
}

</script>
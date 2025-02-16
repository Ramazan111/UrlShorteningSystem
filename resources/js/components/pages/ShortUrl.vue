<template>
  <Layout>
    <template #title>
      <h2>Shorten you url</h2>
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
              <v-btn @click="submit" icon color="primary">
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
                  <span>
                    This is the generated url: <a :href="data" target="_blank">{{ data }}</a>
                  </span>
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
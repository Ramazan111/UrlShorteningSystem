<template>
  <Layout>
    <template #title>
      <h2>URL shortener list</h2>
    </template>
    <template #body>
      <v-row>
        <v-col>
          <v-data-table-server
              v-model:items-per-page="data.per_page"
              :headers="headers"
              :items="data.data"
              :items-length="data.total"
              :loading="isLoading"
              item-value="name"
              @update:options="loadItems"
          >
            <template #item.short_url="{item}">
              <v-btn type="text" :href="'S/' + item.short_url" target="_blank">{{ item.short_url }}</v-btn>
            </template>
            <template #item.expire_at="{item}">
              <div v-if="!editMode[item.id]" class="d-flex justify-space-around items-center">
                <span>{{ item.expire_at }}</span>
                <v-btn size="x-small" color="primary" class="ml-2" icon @click="makeEditable(item)">
                  <v-icon>mdi-pencil</v-icon>
                </v-btn>
              </div>
              <div v-else class="d-flex justify-space-around items-center">
                  <v-text-field
                      type="datetime-local"
                      v-model="expiry_date"
                      label="Select a date"
                      max-width="368"
                  ></v-text-field>
                  <v-btn size="x-small" color="success" class="ml-2" icon @click="editExpireDate(item)">
                    <v-icon>mdi-check</v-icon>
                  </v-btn>
                </div>
            </template>
          </v-data-table-server>
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
      editMode: {},
      expiry_date: null,
      headers: [
        { title: 'Original', key: 'original' },
        { title: 'Short', key: 'short_url' },
        { title: 'Clicks', key: 'clicks' },
        { title: 'Expire Date', key: 'expire_at' },
      ]
    }
  },
  async mounted() {
    await this.loadItems();
  },
  computed: {
    ...mapGetters(['data', 'isLoading', 'success', 'error']),
  },
  methods: {
    ...mapActions(['loadItems', 'editExpireAt']),

    makeEditable(item) {
      this.editMode[item.id] = true
      this.expiry_date = item.expire_at
    },
    async editExpireDate(item) {
      await this.editExpireAt({
        id: item.id,
        expire_at: this.expiry_date
      }).then(() => {
        this.editMode[item.id] = false
        this.expiry_date = null
      })
    }
  }
}

</script>
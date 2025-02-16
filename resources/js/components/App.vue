<template>
  <v-app>
    <v-main class="d-flex align-center justify-center" style="min-height: 100vh;">
      <v-container class="pa-4" style="max-width: 600px;">
        <ShortUrl />
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
import ShortUrl from "./pages/ShortUrl.vue";
export default {
  name: 'App',
  components: {ShortUrl},
};
</script>

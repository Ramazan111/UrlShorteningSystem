import './bootstrap';
import { createApp } from 'vue'
import store from './src/store/index.js'

// Vuetify
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import '@mdi/font/css/materialdesignicons.css';

// Components
import App from './components/App.vue'

const vuetify = createVuetify({
    components,
    directives
});

const app = createApp(App);
app.use(vuetify)
app.use(store)
app.mount('#app');

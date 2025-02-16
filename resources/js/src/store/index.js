import { createStore } from 'vuex';
import url from "./modules/url.js";

const store = createStore({
    modules: {
        url,
    },
});

export default store;

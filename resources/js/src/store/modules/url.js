import axios from 'axios';

export default {
    state() {
        return {
            url: {},
            data: [],
            loading: false,
            error: null,
            success: null,
        };
    },
    mutations: {
        setUrl(state, data) {
            state.url = data.data;
        },
        setData(state, data) {
            state.data = data;
        },
        setLoading(state, isLoading) {
            state.loading = isLoading;
        },
        setSuccess(state, success) {
            state.success = success;
        },
        setError(state, error) {
            state.error = error;
        },
        clearStates(state, error) {
            state.error = null;
            state.success = null;
        },
    },
    actions: {
        async store({ commit }, payload) {
            commit('setLoading', true);

            try {
                const response = await axios.post('/api/url-shortening', payload);
                commit('clearStates')
                commit('setSuccess', 'Url created successfully');
                commit('setUrl', response.data);
            } catch (error) {
                commit('clearStates')
                commit('setError', error.message || 'An error occurred while creating the url');
            } finally {
                commit('setLoading', false);
            }
        },

        async loadItems({ commit }, payload) {
            commit('setLoading', true);

            try {
                const response = await axios.get('/api/urls', payload);
                commit('setData', response.data);
            } catch (error) {
            } finally {
                commit('setLoading', false);
            }
        },

        async editExpireAt({ commit }, payload) {
            commit('setLoading', true);

            try {
                const response = await axios.post('/api/urls/' + payload.id, payload);
                commit('clearStates')
                commit('setSuccess', 'Url created successfully');
                commit('setData', response.data);
            } catch (error) {
                commit('clearStates')
                commit('setError', error.message || 'An error occurred while creating the url');
            } finally {
                commit('setLoading', false);
            }
        },
    },
    getters: {
        url(state) {
            return state.url;
        },
        data(state) {
            return state.data;
        },
        isLoading(state) {
            return state.loading;
        },
        success(state) {
            return state.success;
        },
        error(state) {
            return state.error;
        }
    }
};

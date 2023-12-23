import Vue from 'vue'
import Vuex from 'vuex'
import getters from './getters'

import modules from './modules';


Vue.use(Vuex)

export const store = new Vuex.Store({
    modules,
    state: {

        loading: false,
        serverUrl: '',
    },
    mutations: {

        setLoading(state, payload) {
            state.loading = payload
        },

    },
    actions: {


    },
    getters
})

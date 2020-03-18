import Vue from 'vue'
import Vuex from 'vuex'

import auth from './auth'
import twitter from './twitter'

Vue.use(Vuex)

const store = new Vuex.Store({
  modules: {
    auth,
    twitter
  }
})

export default store
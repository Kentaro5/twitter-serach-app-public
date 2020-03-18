import './bootstrap.js'
import Vue from 'vue'
import router from './route/route.js'
import App from './App.vue'
import store from './store'


const createApp = async () => {
  await store.dispatch('auth/currentUser')
  new Vue({
    el: '#app',
    store,
    router,
    components: { App },
    template: '<App />'
})
}

createApp()
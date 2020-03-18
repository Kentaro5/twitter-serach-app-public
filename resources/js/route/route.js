import Vue from 'vue'
import VueRouter from 'vue-router'

// ページコンポーネントをインポートする
import Login from '../components/Login/Login.vue'
import TwitterList from '../components/Twitter/TwitterList.vue'
import store from '../store'

// VueRouterプラグインを使用する
// これによって<RouterView />コンポーネントなどを使うことができる
Vue.use(VueRouter)

// パスとコンポーネントのマッピング
const routes = [
    {
        path: '/',
        component: TwitterList,
        beforeEnter (to, from, next) {
            console.log(store.getters['auth/check'])
            if (store.getters['auth/check']) {

                next()
            } else {

                next('/login')
            }
        }
    },
    {
        path: '/twitter',
        component: TwitterList,
        beforeEnter (to, from, next) {
            console.log(store.getters['auth/check'])
            if (store.getters['auth/check']) {

                next()
            } else {

                next('/login')
            }
        }
    },
    {
        path: '/login',
        component: Login
    }
]

// VueRouterインスタンスを作成する
const router = new VueRouter({
    mode: 'history',
    routes
})

// VueRouterインスタンスをエクスポートする
// app.jsでインポートするため
export default router
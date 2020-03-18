const state = {
  user: null
}

const getters = {
    check: state => !! state.user,
    username: state => state.user ? state.user.name : ''
}

const mutations = {
    setUser (state, user) {
        state.user = user
    }
}

const actions = {

    async register (context, data) {
        const response = await axios.post('/api/register', data)
        context.commit('setUser', response.data)
    },

    async login (context, data) {
        const response = await axios.get('/api/user')
        context.commit('setUser', response.data)
    },

    async logout (context) {
        console.log('logout')
        const response = await axios.post('/api/logout')
        console.log(response)
        context.commit('setUser', null)
    },

    async currentUser (context) {
        const response = await axios.get('/api/users')
        const user = response.data || null
        console.log(user)
        context.commit('setUser', user)
    }
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}



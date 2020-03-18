const state = {
    tweet: null
}

const getters = {
    tweet_data: state => state.tweet ? state.tweet : ''
}

const mutations = {
    setTweet (state, tweet) {
        state.tweet = tweet
    }
}

const actions = {

    async get_tweet (context, data) {

        const response = await axios.get('/api/twitter')
        context.commit('setTweet', response.data)
    },

    async search_tweet (context, queries) {

        const response = await axios.get('/api/twitter', {params: queries})
        context.commit('setTweet', response.data)
    }
}

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
}



<template>
    <div class="container">
        <div class="columns is-multiline">
            <div class="column is-4" v-for="tweet in tweets">
                <div class="card">
                    <div class="card-content">
                        <div class="media">
                            <div class="media-left">
                                <figure class="image is-48x48">
                                    <img :src=tweet.user.profile_image_url alt="">
                                </figure>
                            </div>
                            <div class="media-content">
                                <p class="title is-4">{{ tweet.user.name }}</p>
                                <p class="subtitle is-6">@johnsmith</p>
                            </div>
                        </div>
                    </div>

                    <div class="content">
                        {{ tweet.text }}
                        <a href="#">#css</a> <a href="#">#responsive</a>
                        <br>
                        <time datetime="2016-1-1">11:09 PM - 1 Jan 2016</time>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
export default{

    data(){
        return {
            tweets: [],
        }
    },
    created () {
        this.get_tweet();
    },
    methods: {
        async get_tweet () {

            await this.$store.dispatch('twitter/get_tweet')
            this.tweets = this.$store.getters['twitter/tweet_data']

        },
        async logout () {

            await this.$store.dispatch('auth/logout')

            this.$router.push('/login')
        }
    }
}
</script>



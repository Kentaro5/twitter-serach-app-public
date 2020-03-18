<template>
    <div class="container content">

        <section class="search" style="">
            <div class="field has-addons">
                <div class="control">
                    <input class="input" v-model="user_name" type="text" placeholder="Find your tweet by user name">
                </div>
                <div class="control">
                    <a class="button is-info">
                        Search
                    </a>
                </div>
            </div>
        </section>

         <section v-if="animation" class="columns is-multiline">
            <div class="column is-4" v-for="index in 15">
                <div class="animationLoading">
                <div id="container">
                    <div id="one"></div>
                    <div id="two"></div>
                    <div id="three"></div>
                </div>
                <div id="four"></div>
                <div id="five"></div>
                <div id="six"></div>
                <div id="seven"></div>
                <div id="eight"></div>
                </div>
            </div>
        </section>

        <section v-else class="columns is-multiline">

            <div class="column is-4" v-if="0 < tweets.length" v-for="tweet in tweets">
                    <div class="card columns">
                        <div class="card-content is-2 p0" style="">
                            <div class="media">
                                <div class="column  media-left">
                                    <div class="image is-48x48">
                                        <img class="is-rounded" :src=tweet.user.profile_image_url alt="">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="column is-9 content" style="margin-bottom:0px;">
                            <div class="media-content">
                                <p class="title">{{ tweet.user.name }}</p>
                                <p class="subtitle">@{{ tweet.user.screen_name }}</p>
                            </div>


                            <p class="text">{{ tweet.text }}</p>
                            <div class="" v-if="'media' in tweet.entities">
                                <img class="" :src=tweet.entities.media[0].media_url alt="" style="width:100%;">
                            </div>
                            <time datetime="2016-1-1">{{ tweet.created_at }}</time>

                            <a v-if=" 0 < tweet.entities.urls.length" :href=tweet.entities.urls[0].url target="_blank">リンクはこちら</a>
                            <a v-else-if="'media' in tweet.entities" :href=tweet.entities.media[0].url target="_blank">リンクはこちら</a>
                            <a v-else :href="'https://twitter.com/'+tweet.user.screen_name+'/status/'+tweet.id_str" target="_blank">リンクはこちら</a>
                        </div>
                    </div>

            </div>
            <div v-if="0 >= tweets.length">
                <p>検索結果はありません。</p>
            </div>
        </section>
    </div>
</template>


<script>
export default{

    data(){
        return {
            tweets: [],
            store_tweets: [],
            searched_tweets: [],
            user_name: '',
            test:{},
            animation: false,
        }
    },

    created () {
        this.animation = true;
        this.get_tweet();
    },
    watch:{
        user_name: function (new_input, oldQuestion) {
            this.animation = true;
            if(new_input == ''){
                this.reset_tweets();

            }else{
                this.search_tweets(new_input);

            }
            setTimeout(()=>{
                this.animation = false;
            },3000);
        }
    },
    methods: {
        reset_tweets(){
            this.tweets = this.$store.getters['twitter/tweet_data']
        },
        search_tweets( new_input ){
            this.store_tweets = this.$store.getters['twitter/tweet_data']
            this.searched_tweets = []
            let target_name = new_input;
            for (var i = 0; i < this.store_tweets.length; i++) {
                if( target_name === this.store_tweets[i].user.screen_name ){

                    this.searched_tweets.push(this.store_tweets[i])
                }
            }
            this.tweets = this.searched_tweets;
        },
        async get_tweet () {

            await this.$store.dispatch('twitter/get_tweet')
            this.tweets = this.$store.getters['twitter/tweet_data']
            this.animation = false;
        },
        async logout () {

            const queries = { user_name: '1000' };
            await this.$store.dispatch('auth/logout')

            this.$router.push('/login')
        }
    }
}

</script>

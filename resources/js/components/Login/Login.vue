<template>
  <section class="hero is-primary is-fullheight">
  <div class="hero-body">
    <div class="container">
      <div class="columns is-centered">
        <div class="column is-5-tablet is-4-desktop is-3-widescreen">

          <form action="" class="box" @submit.prevent="login">

            <div class="field">
                <button class="button is-success">
                    Twitter
                </button>
            </div>

          </form>

        </div>
      </div>
    </div>
  </div>
</section>
</template>

<script>
 export default{

        data(){
            return {
                statuses: []
            }
        },
        methods: {
            login(){

                axios.get('/auth/redirect/twitter')
                .then(response => {
                        const redirect_url = response.data;
                        window.location.href = redirect_url;
                    })
                .catch(e => error({ message: e.message, statusCode: e.statusCode }))
            }

        }
    }
</script>
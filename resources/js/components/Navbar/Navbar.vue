<template>
    <div class="container">
        <nav class="navbar" role="navigation" aria-label="main navigation">
            <div class="navbar-brand">
                <a class="navbar-item" href="https://bulma.io">
                    <img src="https://bulma.io/images/bulma-logo.png" width="112" height="28">
                </a>

                <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                </a>
            </div>

            <div id="navbarBasicExample" class="navbar-menu">
                <div class="navbar-start">

                    <p v-if="isLogin" class="navbar-item">
                        <strong>{{username}}</strong>
                    </p>

                    <RouterLink class="navbar-item" to="/">
                        Home
                    </RouterLink>

                    <div class="navbar-end">
                        <div class="navbar-item">
                            <div class="buttons">

                                <button v-if="isLogin" class="button is-light" @click="logout">
                                    Logout
                                </button>

                                <RouterLink v-else class="button button--link" to="/login">
                                    Login / Sign up
                                </RouterLink>
                            </div>
                        </div>
                    </div>



                </div>
            </div>
        </nav>
    </div>
</template>


<script>
 export default{

        data(){
            return {
                statuses: []
            }
        },
        computed: {
            isLogin () {
                return this.$store.getters['auth/check']
            },
            username () {
                return this.$store.getters['auth/username']
            }
      },
        methods: {
            async logout () {

              await this.$store.dispatch('auth/logout')

              this.$router.push('/login')
          }
        }
    }
</script>



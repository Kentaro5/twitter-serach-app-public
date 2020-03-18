<template>
    <div>
        <header>
            <Navbar />
        </header>
        <main style="margin-top:56px;">
            <div class="container">
                <RouterView />
            </div>
        </main>
    </div>
</template>


<script>
import Navbar from './components/Navbar/Navbar.vue'
import Auth from './auth/Auth.js'

export default {
    data() {
        return {
            // auth: new Auth,
            // user: [ { name : '' } ]
        }
    },
    mounted() {
        //this.user.name = this.auth.check_login();
    },
    components: {
        Navbar,
    }
}
</script>
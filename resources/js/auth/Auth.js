class Auth {
    constructor() {
        this.host_url = window.location.origin;
        this.path_name = window.location.pathname
    }
    async check_login () {
        let current_user_name
        await axios.get('/api/user')
        .then(response => {
            return true;
        })
        .catch(e =>{
           console.log(e.message)
           return false;
        })
    }

    logout(){
        axios.get('/logout')
        .then(response => {
            this.go_to_login();
        })
    }

    test(){
        console.log('tes')
    }
    go_to_login(){
        if( this.path_name !== '/login' ){
            window.location.href = this.host_url+'/login';
        }
    }
}

export default Auth;
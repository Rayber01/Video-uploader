<template>
<div>
	<div class="sidenav">
		 <div class="login-main-text">
		    <h2>Application<br> Login Page</h2>
		    <p>Login from here to access.</p>
		</div>
	</div>
	<div class="main">
		 <div class="col-md-6 col-sm-12">
		    <div class="login-form">
		       <form v-on:submit.prevent="validate()">
		          <div class="form-group">
		             <label>Email</label>
		             <input type="email" class="form-control" placeholder="Email" v-model="email">
		          </div>
		          <div class="form-group">
		             <label>Password</label>
		             <input type="password" class="form-control" placeholder="Password" v-model="password">
		          </div>
		          <button type="submit" class="btn btn-secondary" @click="validate">Login</button>
		       </form>
		    </div>
		 </div>
	</div>
</div>
</template>

<script>
	export default{
        data(){
            return{
                email: '',
                password: '',
            }
        },
        beforeCreate(){
            axios.get('/user')
            .then(res => {
                this.$router.push('/')
            })
            .catch(err => {
            })
        },
        methods:{
            validate(){
                const params = {
                    email: this.email,
                    password: this.password
                }
                axios.get('/sanctum/csrf-cookie')
                .then(res => {
                    axios.post('login', params)
                        .then(res => {
                            this.$router.go('/')
                        })
                        .catch(err => {
                            this.$swal.fire({
                              icon: 'error',
                              title: 'Oops...',
                              text: 'Invalid credentials!',
                            })
                        })
                })
            }
        }
	};
</script>

<style scoped>
body {
    font-family: "Lato", sans-serif;
}

.main-head{
    height: 150px;
    background: #FFF;
   
}

.sidenav {
    height: 100%;
    background-color: #000;
    overflow-x: hidden;
    padding-top: 20px;
}


.main {
    padding: 0px 10px;
}

@media screen and (max-height: 450px) {
    .sidenav {padding-top: 15px;}
}

@media screen and (max-width: 450px) {
    .login-form{
        margin-top: 10%;
    }

    .register-form{
        margin-top: 10%;
    }
}

@media screen and (min-width: 768px){
    .main{
        margin-left: 40%; 
    }

    .sidenav{
        width: 40%;
        position: fixed;
        z-index: 1;
        top: 0;
        left: 0;
    }

    .login-form{
        margin-top: 80%;
    }

    .register-form{
        margin-top: 20%;
    }
}


.login-main-text{
    margin-top: 20%;
    padding: 60px;
    color: #fff;
}

.login-main-text h2{
    font-weight: 300;
}

.btn-black{
    background-color: #000 !important;
    color: #fff;
}
</style>
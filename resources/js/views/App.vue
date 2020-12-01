<template>
<div class="">
    <nav class="navbar navbar-light bg-light" v-show="session">
      <a class="navbar-brand">{{user.name}}</a>
      <form class="form-inline" v-on:submit.prevent="">
        <button class="btn btn-outline-secondary my-2 my-sm-0" @click="logout()">Logout</button>
      </form>
    </nav>
    <router-view></router-view>
</div>
</template>

<script>
export default {
    name: "App",
    data(){
    	return{
    		user: '',
    	}
    },
    beforeCreate(){
        axios.get('/user')
        .then(res => {
            this.user = res.data
        })
        .catch(err => {
            this.$router.push('/login')
        })
    },
    computed:{
        session(){
            if(this.user!=''){
                return true;
            } else {
                return false
            }
        }
    },
    methods:{
        logout(){
            axios.post('/logout').then((response) => {
                this.user = ''
                this.$router.push('/login')
            }).catch((error) => {
              console.error(error);
            })
        }
    }
};
</script>

<style>

</style>

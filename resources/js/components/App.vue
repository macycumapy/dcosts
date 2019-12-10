<template>
    <div>
        <h1>Daily costs</h1>
        <ul v-if="this.$store.getters.isAuthenticated">
            <li><router-link :to="{ name: 'home' }">Home</router-link></li>
            <li><router-link :to="{ name: 'users' }">Users</router-link></li>
            <li><a href="javascript:void(0);" @click="logout">Logout</a></li>
        </ul>
        <ul v-else>
            <li><router-link :to="{ name: 'register' }">Register</router-link></li>
            <li><router-link :to="{ name: 'login' }">Login</router-link></li>
        </ul>
        <div class="container">
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
    export default {
        methods:{
            logout(){
                this.$store.dispatch('logout')
            }
        }
    }
</script>

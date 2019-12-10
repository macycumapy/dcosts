<template>
    <div>
        <div v-if="this.$store.getters.isAuthenticated">
            <h1>Daily costs</h1>
            <ul>
                <li>
                    <router-link :to="{ name: 'home' }">Home</router-link>
                </li>
                <li>
                    <router-link :to="{ name: 'users' }">Users</router-link>
                </li>
                <li><a href="javascript:void(0);" @click="logout">Logout</a></li>
            </ul>
            <div class="container">
                <router-view></router-view>
            </div>
        </div>
        <div v-else id="enter-system">
            <div class="header row">
                <div class="left"><a href="/"><div class="logo"></div></a></div>
                <div class="right">
                    <router-link :to="{ name: 'register' }">Регистрация</router-link>
                    <router-link :to="{ name: 'login' }">Вход</router-link>
                </div>
            </div>
            <div class="authentication-form">
                <div class="container">
                    <router-view></router-view>
                </div>
            </div>
            <div class="footer">{{ new Date().getFullYear() }} &copy; DailyCosts <a href="mailto:kopperphild@gmail.com">kopperphild@gmail.com</a></div>
        </div>
    </div>
</template>
<script>
    export default {
        methods: {
            logout() {
                this.$store.dispatch('logout')
            }
        }
    }
</script>

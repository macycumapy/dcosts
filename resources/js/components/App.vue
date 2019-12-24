<template>
    <div>
        <div v-if="this.$store.getters.isAuthenticated" id="lk">
            <div id="lk-menu" class="py-3">
                <div class="row">
                    <div class="col-12">
                        <router-link :to="{ name: 'home' }">
                            <div class="logo m-auto"></div>
                        </router-link>
                    </div>
                </div>
                <ul class="py-4 pl-1">
                    <li><router-link :to="{ name: 'nomenclature' }">Номенклатура</router-link></li>
                    <li><router-link :to="{ name: 'nomenclatureType' }">Типы номенклатуры</router-link></li>
                    <li><router-link :to="{ name: 'costItems' }">Статьи затрат</router-link></li>
                    <li><router-link :to="{ name: 'partners' }">Контрагенты</router-link></li>
                    <li><router-link :to="{ name: 'cashFlow' }">Расходы</router-link></li>
                    <li><router-link :to="{ name: 'cashInflows' }">Поступления</router-link></li>
                </ul>
                <ul class="py-1 pl-1">
                    <li><a href="javascript:void(0);" @click="logout">Выйти</a></li>
                </ul>
            </div>
            <div class="container-fluid py-3">
                <router-view></router-view>
            </div>
        </div>
        <div v-else id="enter-system">
            <div class="header row">
                <div class="left"><a href="/">
                    <div class="logo"></div>
                </a></div>
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
            <div class="footer">{{ new Date().getFullYear() }} &copy; DailyCosts <a href="mailto:kopperphild@gmail.com">kopperphild@gmail.com</a>
            </div>
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

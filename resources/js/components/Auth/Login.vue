<template>
    <div>
        <div class="row hd">
            <div class="col text-center">
                <div class="header-text">Вход</div>
            </div>
        </div>
        <form @submit.prevent="login" class="form-horizontal">
            <div class="row">
                <div class="w-100 m-auto">
                    <input id="username" class="w-100" type="email" name="username" v-model="username" required
                           placeholder="Ваш email">
                </div>
            </div>
            <div class="row">
                <div class="w-100 m-auto">
                    <input id="password" class="w-100" type="password" name="password" v-model="password" required
                           placeholder="Введите пароль">
                </div>
            </div>
            <div class="row">
                <div class="w-100 m-auto">
                    <input type="submit" value="Войти" class="btn btn-reg" :disabled="loading">
                </div>
            </div>
            <div class="row">
                <div class="w-100 m-auto">
                    <div class="error" v-text="error"></div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                loading: false,
                username: '',
                password: '',
                error: '',
            };
        },
        methods: {
            login() {
                this.loading = true;
                this.error = '';

                let data = {
                    email: this.username,
                    password: this.password
                };
                this.$store.dispatch('login', data)
                    .then(() => {
                        this.loading = false;
                    })
                    .catch((err) => {
                        this.loading = false;
                        this.error = err;
                    })
            }

        }
    }
</script>

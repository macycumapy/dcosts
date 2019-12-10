<template>
    <form @submit.prevent="login">
        <h1>Login</h1>
        <p>
            <label for="username">Email</label>
            <input id="username" type="email" name="username" v-model="username" required>
        </p>

        <p>
            <label for="password">Password</label>
            <input id="password" type="password" name="password" v-model="password" required>
        </p>
        <div v-text="error"></div>
        <button v-if="!loading">Login</button>
    </form>
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

<template>
    <div>
        <h1>Регистрация</h1>
        <form @submit.prevent="register">
            <p>
                <label for="name">Имя</label>
                <input id="name" type="text" name="name" v-model="name" required>
            </p>

            <p>
                <label for="email">Email</label>
                <input id="email" type="email" name="email" v-model="email" required>
            </p>

            <p>
                <label for="password">Пароль</label>
                <input id="password" type="password" name="password" v-model="password" required>
            </p>
            <div v-text="error"></div>

            <input type="submit" value="Зарегистрироваться">
        </form>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                loading: false,
                name: '',
                email: '',
                password: '',
                error: '',
            };
        },

        methods: {
            register() {
                this.loading = true;
                this.error = '';
                let data = {
                    name: this.name,
                    email: this.email,
                    password: this.password
                };
                this.$store.dispatch('register', data)
                    .then(() => {
                        this.loading = false;
                    })
                    .catch((err) => {
                        this.error = err;
                        this.loading = false;
                    })
            }

        }
    }
</script>

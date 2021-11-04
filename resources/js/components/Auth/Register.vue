<template>
  <div>
    <div class="row hd">
      <div class="col text-center">
        <div class="header-text">
          Регистрация
        </div>
      </div>
    </div>
    <form
      @submit.prevent="register"
      class="form-horizontal"
    >
      <div class="row">
        <div class="w-100 m-auto">
          <input
            v-model="name"
            id="name"
            class="w-100"
            type="text"
            name="name"
            required
            placeholder="Ваше имя"
          >
        </div>
      </div>
      <div class="row">
        <div class="w-100 m-auto">
          <input
            v-model="email"
            id="email"
            class="w-100"
            type="email"
            name="email"
            required
            placeholder="Ваш Email"
          >
        </div>
      </div>
      <div class="row">
        <div class="w-100 m-auto">
          <input
            v-model="password"
            id="password"
            class="w-100"
            type="password"
            name="password"
            required
            placeholder="Задайте пароль"
          >
        </div>
      </div>

      <div class="row">
        <div class="w-100 m-auto">
          <input
            type="submit"
            value="Зарегистрироваться"
            class="btn btn-reg"
          >
        </div>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  name: 'RegisterComponent',
  data() {
    return {
      name: '',
      email: '',
      password: '',
    };
  },

  methods: {
    register() {
      this.$store.dispatch('register', {
        name: this.name,
        email: this.email,
        password: this.password,
      });
    },
  },
};
</script>

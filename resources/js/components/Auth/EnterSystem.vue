<template>
  <div id="enter-system">
    <div class="header row">
      <div class="left">
        <a href="/">
          <div class="logo" />
        </a>
      </div>
      <div class="right">
        <router-link :to="{ name: 'register' }">
          Регистрация
        </router-link>
        <router-link :to="{ name: 'login' }">
          Вход
        </router-link>
      </div>
    </div>
    <div class="authentication-form">
      <div class="container">
        <router-view />
      </div>
    </div>
    <div class="footer">
      {{ new Date().getFullYear() }} &copy; DailyCosts <a href="mailto:kopperphild@gmail.com">kopperphild@gmail.com</a>
    </div>
  </div>
</template>

<script>
export default {
  name: 'EnterSystem',
};
</script>

<template>
  <div class="h-100">
    <template v-if="isAuthenticated">
      <cabinet />
    </template>
    <template v-else>
      <enter-system />
    </template>
    <preloader />
  </div>
</template>
<script>

import { mapGetters } from 'vuex';
import EnterSystem from './Auth/EnterSystem.vue';
import Cabinet from './Cabinet/Cabinet.vue';
import Preloader from './General/Preloader.vue';

export default {
  components: {
    EnterSystem,
    Cabinet,
    Preloader,
  },
  computed: {
    ...mapGetters(['isAuthenticated']),
  },
};
</script>

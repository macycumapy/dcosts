<template>
  <div
    v-if="isAuthenticated"
  >
    <cabinet />
  </div>
  <div v-else>
    <enter-system />
  </div>
</template>
<script>

import { mapGetters } from 'vuex';
import EnterSystem from './Auth/EnterSystem.vue';
import Cabinet from './Cabinet/Cabinet.vue';

export default {
  components: {
    EnterSystem,
    Cabinet,
  },
  computed: {
    ...mapGetters(['isAuthenticated']),
  },
};
</script>

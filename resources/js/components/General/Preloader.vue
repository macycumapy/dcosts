<template>
  <div
    v-if="show"
    id="preloader"
  >
    <div class="preloader">
      <span />
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
  name: 'PreloaderComponent',
  computed: {
    ...mapGetters('preloader', ['show']),
  },
};
</script>

<template>
  <div id="lk">
    <header-nav />
    <div class="container">
      <router-view />
    </div>
    <v-dialog />
  </div>
</template>

<script>
import HeaderNav from './HeaderNav.vue';

export default {
  name: 'CabinetComponent',
  components: {
    HeaderNav,
  },
  created() {
    this.$store.dispatch('getNomenclature');
    this.$store.dispatch('getNomenclatureType');
    this.$store.dispatch('getPartners');
    this.$store.dispatch('getCategories');
  },
};
</script>

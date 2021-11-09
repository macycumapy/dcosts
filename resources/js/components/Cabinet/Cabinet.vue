<template>
  <div id="lk">
    <sidebar />
    <div class="container-fluid py-3">
      <router-view />
    </div>
    <v-dialog />
  </div>
</template>

<script>
import Sidebar from './Sidebar.vue';

export default {
  name: 'CabinetComponent',
  components: {
    Sidebar,
  },
  created() {
    this.$store.dispatch('getNomenclature');
    this.$store.dispatch('getNomenclatureType');
  },
};
</script>

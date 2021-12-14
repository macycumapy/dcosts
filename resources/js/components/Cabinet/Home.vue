<template>
  <div id="home">
    <cash-flow-list />
  </div>
</template>

<script>

import CashFlowList from './CashFlowList.vue';

export default {
  name: 'HomeComponent',
  components: {
    CashFlowList,
  },
};
</script>

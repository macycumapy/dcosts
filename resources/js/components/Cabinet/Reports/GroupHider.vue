<template>
  <div
    @click="click"
    v-text="text"
    class="group-hider"
  />
</template>

<script>
export default {
  name: 'GroupHider',
  props: {
    groupName: {
      type: String,
      required: true,
    },
    hidden: {
      type: Boolean,
      required: true,
    },
  },
  computed: {
    text() {
      return this.hidden ? '+' : '-';
    },
  },
  methods: {
    click() {
      return this.hidden ? this.$emit('show', this.groupName) : this.$emit('hide', this.groupName);
    },
  },
};

</script>

<style scoped lang="scss">
.group-hider {
  position: absolute;
  padding: 0 5px;
  left: 0;
  top: 0;
  bottom: 0;
  cursor: pointer;
  margin: auto;
  color: #0b140b;
}
</style>

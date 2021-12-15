<template>
  <div class="list-btn-group">
    <img
      @click="edit()"
      src="/images/edit.png"
      alt="edit"
      title="Изменить"
    >
    <img
      @click="copy()"
      src="/images/copy.png"
      alt="copy"
      title="Копировать"
    >
    <img
      @click="remove()"
      src="/images/delete.png"
      alt="delete"
      title="Удалить"
    >
  </div>
</template>

<script>
export default {
  name: 'CRUDPanelRoute',
  props: {
    modelId: {
      type: Number,
      required: true,
    },
    routeName: {
      type: String,
      required: true,
    },
    name: {
      type: String,
      default() {
        return '';
      },
    },
  },
  methods: {
    edit() {
      this.$router.push({ name: this.routeName, params: { id: this.modelId, prevRoute: this.$route.name } });
    },

    copy() {
      this.$router.push({
        name: this.routeName,
        params: { id: 'new', parent_id: this.modelId, prevRoute: this.$route.name },
      });
    },

    remove() {
      this.$modal.show('dialog', {
        title: `Удалить ${this.name}?`,
        buttons: [
          {
            title: 'Да',
            handler: () => {
              this.$emit('delete', this.modelId);
              this.$modal.hide('dialog');
            },
            class: 'btn',
          },
          {
            title: 'Нет',
            class: 'btn red',
            handler: () => {
              this.$modal.hide('dialog');
            },
          },
        ],
      });
    },
  },
};
</script>

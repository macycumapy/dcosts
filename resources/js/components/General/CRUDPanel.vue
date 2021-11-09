<template>
  <div class="list-btn-group">
    <img
      @click="edit()"
      src="/images/edit.png"
      alt="edit"
    >
    <img
      @click="copy()"
      src="/images/copy.png"
      alt="copy"
    >
    <img
      @click="remove()"
      src="/images/delete.png"
      alt="delete"
    >
  </div>
</template>

<script>
export default {
  name: 'CRUDPanel',
  props: {
    modal: {
      type: Object,
      required: true,
    },
    item: {
      type: Object,
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
      this.$modal.show(this.modal, this.item);
    },

    copy() {
      const newObject = { ...this.item };
      delete newObject.id;
      this.$modal.show(this.modal, newObject);
    },

    remove() {
      this.$modal.show('dialog', {
        title: `Удалить ${this.name}?`,
        buttons: [
          {
            title: 'Да',
            handler: () => {
              this.$emit('delete', this.item.id);
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

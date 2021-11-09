<template>
  <div class="nomenclature">
    <div class="row justify-content-center">
      <div class="col-xl-7 col-lg-12 col-md-12 col-12">
        <div class="w-100 text-center">
          <div class="header-text py-3">
            {{ title }}
          </div>
        </div>
        <div class="list-header">
          <div class="col-xl-3 col-lg-3 col-md-6 col-6 text-start">
            Наименование
          </div>
        </div>
        <div class="list">
          <div
            v-for="item in nomenclature"
            :key="item.id"
            class="row pl-4 position-relative"
          >
            <div class="col-xl-3 col-lg-3 col-md-6 col-6">
              {{ item.name }}
            </div>
            <div class="list-btn-group">
              <img
                @click="edit(item)"
                src="/images/edit.png"
                alt="edit"
              >
              <img
                @click="copy(item)"
                src="/images/copy.png"
                alt="copy"
              >
              <img
                @click="remove(item)"
                src="/images/delete.png"
                alt="delete"
              >
            </div>
          </div>
        </div>
        <div class="btn-group py-2">
          <button
            @click="add"
            class="btn"
          >
            Добавить
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex';
import Modal from './Modals/NomenclatureModal.vue';

export default {
  name: 'NomenclatureList',
  data() {
    return {
      title: 'Номенклатура',
    };
  },
  computed: {
    ...mapGetters(['nomenclature']),
  },
  methods: {
    add() {
      this.$modal.show(Modal);
    },

    edit(item) {
      this.$modal.show(Modal, item);
    },

    copy(item) {
      this.$modal.show(Modal, {
        name: item.name,
        nomenclature_type_id: item.nomenclature_type_id,
      });
    },

    remove(item) {
      this.$modal.show('dialog', {
        title: `Удалить ${item.name}?`,
        buttons: [
          {
            title: 'Да',
            handler: () => {
              this.$store.dispatch('deleteNomenclature', item.id)
                .then(() => this.$modal.hide('dialog'));
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

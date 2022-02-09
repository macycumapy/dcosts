<template>
  <div class="nomenclature-type">
    <div class="row justify-content-center">
      <div class="col-xl-7 col-lg-12 col-md-12 col-12 p-0 p-md-1">
        <div class="list-header">
          <div class="col-xl-3 col-lg-3 col-md-6 col-6 text-start">
            Наименование
          </div>
        </div>
        <div class="list">
          <div
            v-for="item in nomenclatureTypes"
            :key="item.id"
            class="row position-relative"
          >
            <div class="col-xl-3 col-lg-3 col-md-6 col-6">
              {{ item.name }}
            </div>
            <crud-panel
              @delete="onDelete"
              :item="item"
              :modal="modal"
              :name="item.name"
            />
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
import Modal from './Modals/NomenclatureTypeModal.vue';
import CrudPanel from '../General/CRUDPanel.vue';

export default {
  name: 'NomenclatureTypeList',
  components: {
    CrudPanel,
  },
  computed: {
    ...mapGetters(['nomenclatureTypes']),

    modal() {
      return Modal;
    },
  },
  created() {
    this.$store.commit('header/setTitle', 'Типы номенклатуры');
  },
  methods: {
    add() {
      this.$modal.show(Modal);
    },
    onDelete(id) {
      this.$store.dispatch('deleteNomenclatureType', id);
    },
  },
};
</script>

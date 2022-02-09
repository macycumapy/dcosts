<template>
  <div class="partner">
    <div class="row justify-content-center">
      <div class="col-xl-7 col-lg-12 col-md-12 col-12 p-0 p-md-1">
        <div class="list-header">
          <div class="col-xl-3 col-lg-3 col-md-6 col-6 text-start">
            Наименование
          </div>
        </div>
        <div class="list">
          <div
            v-for="item in partners"
            class="row pl-4 position-relative"
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
import Modal from './Modals/PartnerModal.vue';
import CrudPanel from '../General/CRUDPanel.vue';

export default {
  name: 'PartnerList',
  components: {
    CrudPanel,
  },
  computed: {
    ...mapGetters(['partners']),

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
      this.$store.dispatch('deletePartner', id);
    },
  },
};
</script>

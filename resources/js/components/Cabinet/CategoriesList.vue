<template>
  <div class="cost-items">
    <div class="row justify-content-center">
      <div class="col-xl-7 col-lg-12 col-md-12 col-12 p-0 p-md-1">
        <div class="list-header">
          <div class="col-8 text-start">
            Наименование
          </div>
          <div class="col-4 text-center">
            Тип
          </div>
        </div>
        <div class="list">
          <div
            v-for="item in categories"
            :key="item.name"
            class="row position-relative"
          >
            <div class="col-8">
              {{ item.name }}
            </div>
            <div class="col-4 text-center">
              {{ getTypeTitle(item.type) }}
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
    import Modal from './Modals/CategoryModal.vue';
    import CrudPanel from '../General/CRUDPanel.vue';

    export default {
      name: 'CategoriesList',
      components: {
        CrudPanel,
      },
      computed: {
        ...mapGetters(['categories']),

        modal() {
          return Modal;
        },
      },
      created() {
        this.$store.commit('header/setTitle', 'Категории доходов и расходов');
      },
      methods: {
        add() {
          this.$modal.show(Modal);
        },
        onDelete(id) {
          this.$store.dispatch('deleteCategory', id);
        },
        getTypeTitle(type) {
          return Object.values(this.$constants.CASH_FLOW_TYPES).find(item => item.value === type)?.title;
        },
      },
    };
</script>

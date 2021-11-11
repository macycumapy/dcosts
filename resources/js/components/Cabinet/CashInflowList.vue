<template>
  <div id="cash-inflow">
    <div class="row justify-content-center">
      <div class="col-xl-7 col-lg-12 col-md-12 col-12">
        <div class="w-100 text-center">
          <div class="header-text py-3">
            {{ title }}
          </div>
        </div>
        <div class="list-header">
          <div class="col-xl-3 col-lg-3 col-md-6 col-6 text-start">
            Дата
          </div>
          <div class="col-xl-9 col-lg-9 col-md-6 col-6 text-end">
            Сумма
          </div>
        </div>
        <div class="list">
          <div
            v-for="item in list"
            :key="item.id"
            class="row pl-4 position-relative"
          >
            <div class="col-xl-3 col-lg-3 col-md-6 col-6">
              {{ new Date(item.date).toLocaleString().substr(0, 17) }}
            </div>
            <div class="col-xl-9 col-lg-9 col-md-6 col-6 text-end pr-4">
              {{ item.sum.toFixed(2) }}
            </div>
            <crud-panel
              @delete="onDelete"
              :item="item"
              :modal="modal"
              name="Поступление"
            />
          </div>
        </div>
        <div class="btn-group py-2 justify-content-between w-100">
          <paginator
            :currentPage="page"
            :pages="pages"
            :getList="getList"
          />
          <button
            @click="add"
            class="btn w-auto"
          >
            Добавить
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { mapActions, mapGetters } from 'vuex';
import Modal from './Modals/CashInflowModal.vue';
import CrudPanel from '../General/CRUDPanel.vue';
import Paginator from '../General/Paginator.vue';

export default {
  name: 'CashInflowList',
  components: {
    Paginator,
    CrudPanel,
  },
  data() {
    return {
      title: 'Поступления',
    };
  },
  computed: {
    ...mapGetters('cashInflows', [
      'list',
      'page',
      'pages',
    ]),

    modal() {
      return Modal;
    },
  },
  created() {
    this.getList();
  },
  methods: {
    ...mapActions('cashInflows', ['getList']),

    add() {
      this.$modal.show(Modal);
    },
    onDelete(id) {
      this.$store.dispatch('cashInflows/delete', id);
    },
  },
};
</script>

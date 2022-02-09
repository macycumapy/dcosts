<template>
  <div id="cash-inflow">
    <div class="row justify-content-center">
      <div class="col-xl-7 col-lg-12 col-md-12 col-12 p-0 p-md-1">
        <div class="list-header">
          <div class="col-md-4 col-4 text-start">
            Дата
          </div>
          <div class="col-md-4 col-4 text-center">
            Категория
          </div>
          <div class="col-md-4 col-4 text-end">
            Сумма
          </div>
        </div>
        <div class="list paginated-list">
          <div
            v-for="item in list"
            :key="item.id"
            class="row pl-4 position-relative"
          >
            <div class="col col-md-4 col-4">
              {{ new Date(item.date).toLocaleString().substr(0, 17) }}
            </div>
            <div class="col col-md-4 col-4 text-center">
              {{ item.cost_item }}
            </div>
            <div
              class="col col-md-4 col-4 text-end"
              :class="{ red: isOutflow(item) }"
            >
              {{ getSum(item) }}
            </div>
            <crud-panel
              @delete="onDelete"
              :modelId="item.id"
              :routeName="isOutflow(item) ? 'cashOutflow' : 'cashInflow'"
            />
          </div>
        </div>
        <div class="btn-group py-2 justify-content-between w-100">
          <paginator
            :currentPage="page"
            :pages="pages"
            :getList="getList"
          />
          <div class="btn-group">
            <button
              @click="addInflow"
              class="btn w-auto"
            >
              Добавить поступление
            </button>
            <button
              @click="addOutflow"
              class="btn w-auto ml-2"
            >
              Добавить расход
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { mapActions, mapGetters } from 'vuex';
import CrudPanel from '../General/CRUDPanelRoute.vue';
import Paginator from '../General/Paginator.vue';

export default {
  name: 'CashFlowList',
  components: {
    Paginator,
    CrudPanel,
  },
  computed: {
    ...mapGetters('cashFlows', [
      'list',
      'page',
      'pages',
    ]),
  },
  created() {
    this.$store.commit('header/setTitle', 'Доходы и расходы');
    this.getList();
  },
  methods: {
    ...mapActions('cashFlows', ['getList']),

    addInflow() {
      this.$router.push({ name: 'cashInflow', params: { id: 'new', prevRoute: this.$route.name } });
    },
    addOutflow() {
      this.$router.push({ name: 'cashOutflow', params: { id: 'new', prevRoute: this.$route.name } });
    },
    onDelete(id) {
      this.$store.dispatch('cashInflows/delete', id)
        .then(() => this.getList());
    },
    isOutflow(item) {
      return item && item.type === this.$constants.CASH_FLOW_TYPES.Outflow.value;
    },
    getSum(item) {
      return (item.sum * (this.isOutflow(item) ? -1 : 1)).toFixed(2);
    },
  },
};
</script>

<template>
  <div id="cash-flow">
    <div class="row justify-content-center">
      <div class="col-xl-7 col-lg-12 col-md-12 col-12 p-0 p-md-1">
        <div class="list-header">
          <div class="col-xl-3 col-lg-3 col-md-6 col-6 text-start">
            Дата
          </div>
          <div class="col-xl-9 col-lg-9 col-md-6 col-6 text-end">
            Сумма
          </div>
        </div>
        <div class="list paginated-list">
          <div
            v-for="item in list"
            :key="item.id"
            class="row position-relative"
          >
            <div class="col-xl-3 col-lg-3 col-md-6 col-6">
              {{ new Date(item.date).toLocaleString().substr(0, 17) }}
            </div>
            <div class="col-xl-9 col-lg-9 col-md-6 col-6 text-end pr-4">
              {{ item.sum.toFixed(2) }}
            </div>
            <crud-panel
              @delete="onDelete"
              :modelId="item.id"
              routeName="cashOutflow"
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
import CrudPanel from '../General/CRUDPanelRoute.vue';
import Paginator from '../General/Paginator.vue';

export default {
  components: {
    CrudPanel,
    Paginator,
  },
  computed: {
    ...mapGetters('cashOutflows', [
      'list',
      'pages',
      'page',
    ]),
  },
  created() {
    this.$store.commit('header/setTitle', 'Расходы');
    this.getList();
  },
  methods: {
    ...mapActions('cashOutflows', ['getList']),

    add() {
      this.$router.push({ name: 'cashOutflow', params: { id: 'new' } });
    },
    onDelete(id) {
      this.$store.dispatch('cashOutflows/delete', id);
    },
  },
};
</script>

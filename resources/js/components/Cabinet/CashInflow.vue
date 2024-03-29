<template>
  <div>
    <form
      @submit.prevent="save"
      class="form-horizontal"
    >
      <div class="row">
        <div class="col-6">
          <label>
            <input
              v-model="model.date"
              id="date"
              class="w-100"
              type="datetime-local"
              name="date"
              required
              placeholder=" "
            >
            <span>Дата</span>
          </label>
        </div>
        <div class="col-6 pl-0">
          <label>
            <input
              v-model="model.sum"
              class="w-100"
              type="number"
              name="sum"
              step="0.01"
              required
              placeholder=" "
            >
            <span>Сумма</span>
          </label>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col-6">
          <select-list
            v-model="model.category_id"
            :key="model.category_id"
            :list="filteredCategories"
            :modal="categoryModal"
            :modalProps="{type: cashFlowType}"
            title="Статья поступления"
          />
        </div>
        <div class="col-6 pl-0">
          <select-list
            v-model="model.partner_id"
            :key="model.partner_id"
            :list="partners"
            :modal="partnerModal"
            title="Контрагент"
          />
        </div>
      </div>
      <div class="row">
        <div class="col pt-3 justify-content-end">
          <div class="btn-group">
            <input
              @click="close"
              type="button"
              value="Назад"
              class="btn red mr-3"
            >
            <input
              type="submit"
              value="Записать и закрыть"
              class="btn"
            >
          </div>
        </div>
      </div>
    </form>
  </div>
</template>
<script>
import { mapGetters } from 'vuex';
import SelectList from '../General/SelectList.vue';
import PartnerModal from './Modals/PartnerModal.vue';
import CategoryModal from './Modals/CategoryModal.vue';

export default {
  name: 'CashInflow',
  components: {
    SelectList,
  },
  data() {
    return {
      model: {
        id: null,
        date: null,
        category_id: null,
        partner_id: null,
        sum: 0,
      },
    };
  },
  computed: {
    ...mapGetters(['categories', 'partners']),

    filteredCategories() {
      return this.categories.filter(item => item.type === this.cashFlowType);
    },
    cashFlowType() {
      return this.$constants.CASH_FLOW_TYPES.Inflow.value;
    },
    partnerModal() {
      return PartnerModal;
    },
    categoryModal() {
      return CategoryModal;
    },
    prevRoute() {
      return this.$route.params.prevRoute ?? 'cashInflows';
    },
    parentId() {
      return Number(this.$route.params.parent_id);
    },
    id() {
      return Number(this.$route.params.id);
    },
  },
  watch: {
    'model.id': function () {
      this.setTitle();
    },
  },
  beforeMount() {
    if (this.id) {
      this.fillModel();
    } else if (this.parentId) {
      this.fillModelFromParent();
    } else {
      this.setDefaults();
    }
    this.setTitle();
  },
  methods: {
    fillModel() {
      this.getCashInflow(this.id).then(({ data }) => {
        this.model = data;
        this.model.date = `${this.model.date.slice(0, 10)}T${this.model.date.slice(11, 16)}`;
      });
    },
    fillModelFromParent() {
      this.getCashInflow(this.parentId).then(({ data }) => {
        this.model = data;
        this.model.id = null;
        this.setDefaults();
      });
    },
    getCashInflow(id) {
      return this.$store.dispatch('cashInflows/get', id);
    },
    setDefaults() {
      const date = new Date();
      this.model.date = new Date(date.getTime() - (date.getTimezoneOffset() * 60000)).toISOString().substr(0, 16);
    },
    save() {
      if (this.model.id) {
        this.$store.dispatch('cashInflows/update', this.model).then(() => {
          this.close();
        });
      } else {
        this.$store.dispatch('cashInflows/create', this.model).then(() => {
          this.close();
        });
      }
    },
    close() {
      this.$router.push({ name: this.prevRoute });
    },
    setTitle() {
      this.$store.commit('header/setTitle', this.model.id ? 'Поступление' : 'Новое поступление');
    },
  },
};
</script>

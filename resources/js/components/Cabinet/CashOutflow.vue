<template>
  <div>
    <form
      @submit.prevent="save"
      class="form-horizontal"
    >
      <div class="row">
        <div class="col-sm-4 col-6">
          <label>
            <input
              v-model="model.date"
              class="w-100 mr-2"
              type="datetime-local"
              name="date"
              required
              placeholder="Дата"
            >
            <span>Дата</span>
          </label>
        </div>
        <div class="col-sm-8 col-6 pl-0">
          <select-list
            v-model="model.category_id"
            :key="model.category_id"
            :list="filteredCategories"
            :modal="categoryModal"
            :modalProps="{type: cashFlowType}"
            title="Статья расхода"
          />
        </div>
      </div>
      <div class="row">
        <div class="col-12 details mt-2">
          <div class="greed-details">
            <div>Номенклатура</div>
            <div>Количество</div>
            <div>Цена</div>
            <div>Сумма</div>
            <div />
          </div>
          <div
            v-for="item in model.details"
            :key="item.id"
            class="greed-details"
          >
            <select-list
              v-model="item.nomenclature_id"
              :list="nomenclature"
              :modal="nomenclatureModal"
            />
            <input
              v-model="item.count"
              class="w-100"
              type="number"
              required
              placeholder="Количество"
              title="Количество"
            >
            <input
              v-model="item.cost"
              class="w-100 text-end"
              type="number"
              step="0.01"
              required
              placeholder="Цена"
              title="Цена"
            >
            <input
              v-model="(item.count * item.cost).toFixed(2)"
              class="w-100 text-end"
              type="number"
              title="Сумма"
              readonly
            >
            <img
              @click="removeRow(item)"
              class="m-auto mw-100"
              src="/images/remove.png"
              alt=""
              title="Удалить строку"
            >
          </div>
          <div class="greed-details">
            <div />
            <div />
            <div class="text-end m-auto">
              Итого:
            </div>
            <div class="text-end m-auto">
              {{ sum.toFixed(2) }}
            </div>
            <img
              @click="addNewRow"
              class="m-auto mw-100"
              src="/images/add.png"
              alt=""
              title="Добавить строку"
            >
          </div>
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
import NomenclatureModal from './Modals/NomenclatureModal.vue';
import CategoryModal from './Modals/CategoryModal.vue';

export default {
  name: 'CashOutflow',
  components: {
    SelectList,
  },
  data() {
    return {
      model: {
        id: null,
        date: null,
        category_id: null,
        details: [],
      },
    };
  },
  computed: {
    ...mapGetters(['nomenclature', 'categories']),

    filteredCategories() {
      return this.categories.filter(item => item.type === this.cashFlowType);
    },
    cashFlowType() {
      return this.$constants.CASH_FLOW_TYPES.Outflow.value;
    },
    nomenclatureModal() {
      return NomenclatureModal;
    },
    categoryModal() {
      return CategoryModal;
    },
    sum() {
      return this.model.details.length > 0
        ? this.model.details.map((item) => (item.cost * item.count)).reduce((prev, cur) => prev + cur) : 0;
    },
    prevRoute() {
      return this.$route.params.prevRoute ?? 'cashOutflows';
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
      this.getCashOutflow(this.id).then(({ data }) => {
        this.model = data;
        this.model.date = `${this.model.date.slice(0, 10)}T${this.model.date.slice(11, 16)}`;
      });
    },
    fillModelFromParent() {
      this.getCashOutflow(this.parentId).then(({ data }) => {
        this.model = data;
        this.model.id = null;
        this.setDefaults();
      });
    },
    getCashOutflow(id) {
      return this.$store.dispatch('cashOutflows/get', id);
    },
    setDefaults() {
      const date = new Date();
      this.model.date = new Date(date.getTime() - (date.getTimezoneOffset() * 60000)).toISOString().substr(0, 16);
    },
    addNewRow() {
      this.model.details.push({
        id: null,
        nomenclature_id: null,
        count: 1,
        cost: 0,
      });
    },
    removeRow(row) {
      this.model.details.splice(this.model.details.indexOf(row), 1);
    },
    save() {
      if (this.model.id) {
        this.$store.dispatch('cashOutflows/update', this.model).then(() => {
          this.close();
        });
      } else {
        this.$store.dispatch('cashOutflows/create', this.model).then(() => {
          this.close();
        });
      }
    },
    close() {
      this.$router.push({ name: this.prevRoute });
    },
    setTitle() {
      this.$store.commit('header/setTitle', this.model.id ? 'Расход' : 'Новый расход');
    },
  },
};
</script>

<style scoped lang="scss">
@import '@styles/components/cash-outflow.scss';
</style>

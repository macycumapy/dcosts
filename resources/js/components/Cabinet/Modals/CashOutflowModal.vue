<template>
  <div class="qwe">
    <div class="row hd py-3">
      <div class="col text-center">
        <div class="header-text">
          {{ title }}
        </div>
      </div>
    </div>
    <form
      @submit.prevent="save"
      class="form-horizontal"
    >
      <div class="row">
        <div class="col-4">
          <div class="row mr-1">
            <label for="date">
              <input
                v-model="date"
                id="date"
                class="w-100 mr-2"
                type="datetime-local"
                name="date"
                required
                placeholder="Дата"
              >
              <span>Дата</span>
            </label>
          </div>
        </div>
        <div class="col-8">
          <div class="row">
            <select-list
              v-model="cost_item_id"
              :list="costItems"
              :modal="costItemModal"
              title="Статья расхода"
            />
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12 details">
          <div class="greed-details text-center">
            <div>Номенклатура</div>
            <div>Кол-во</div>
            <div>Цена</div>
            <div>Сумма</div>
            <div />
          </div>
          <div
            v-for="item in details"
            class="greed-details"
          >
            <select-list
              v-model="item.nomenclature_id"
              :list="nomenclature"
              :modal="nomenclatureModal"
              title="Номенклатура"
            />
            <input
              v-model="item.count"
              class="w-100"
              type="number"
              required
              placeholder="Количество"
            >
            <input
              v-model="item.cost"
              class="w-100 text-end"
              type="number"
              step="0.01"
              required
              placeholder="Цена"
            >
            <input
              v-model="(item.count * item.cost).toFixed(2)"
              class="w-100 text-end"
              type="number"
              readonly
            >
            <img
              @click="removeRow(item)"
              class="m-auto"
              src="/images/remove.png"
              alt=""
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
              class="m-auto"
              src="/images/add.png"
              alt=""
            >
          </div>
        </div>
      </div>
      <div class="row">
        <div class="w-100 m-auto pt-3 d-flex justify-content-end">
          <div class="btn-group">
            <input
              @click="close"
              type="button"
              value="Отменить"
              class="btn red mr-3"
            >
            <input
              type="submit"
              value="Записать"
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
import SelectList from '../../General/SelectList.vue';
import NomenclatureModal from './NomenclatureModal.vue';
import CostItemModal from './CostItemModal.vue';

export default {
  name: 'CashOutflowModal',
  components: {
    SelectList,
  },
  data() {
    return {
      title: 'Расход',
      date: null,
      id: null,
      cost_item_id: null,
      details: [],
    };
  },
  computed: {
    ...mapGetters(['nomenclature', 'costItems']),
    nomenclatureModal() {
      return NomenclatureModal;
    },
    costItemModal() {
      return CostItemModal;
    },
    sum() {
      return this.details.length > 0
        ? this.details.map((item) => (item.cost * item.count)).reduce((prev, cur) => prev + cur) : 0;
    },
  },
  beforeMount() {
    this.title = this.$attrs.id ? 'Расход' : 'Новый расход';
    this.id = this.$attrs.id;
    this.cost_item_id = this.$attrs.cost_item_id;
    if (this.$attrs.date) {
      this.date = `${this.$attrs.date.slice(0, 10)}T${this.$attrs.date.slice(11, 16)}`;
    } else {
      const date = new Date();
      this.date = new Date(date.getTime() - (date.getTimezoneOffset() * 60000)).toISOString().substr(0, 16);
    }
    if (this.$attrs.details) this.details = this.$attrs.details.slice();
  },
  methods: {
    addNewRow() {
      this.details.push({
        id: null,
        nomenclature_id: null,
        count: 1,
        cost: 0,
      });
    },
    removeRow(item) {
      this.details.splice(this.details.indexOf(item), 1);
    },
    save() {
      const params = {
        id: this.id,
        cost_item_id: this.cost_item_id,
        date: this.date,
        details: this.details,
      };

      if (this.id) {
        this.$store.dispatch('updateCashOutflow', params);
      } else {
        this.$store.dispatch('addCashOutflow', params);
      }
      this.close();
    },
    close() {
      this.$emit('close');
    },
  },
};
</script>

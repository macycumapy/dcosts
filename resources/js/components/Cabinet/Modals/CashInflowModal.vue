<template>
  <div>
    <div class="row hd py-3">
      <div class="col-12 text-center">
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
        <div class="col-6">
          <div class="row mr-1">
            <label>
              <input
                v-model="date"
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
        </div>
        <div class="col-6">
          <div class="row">
            <label for="sum">
              <input
                v-model="sum"
                id="sum"
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
      </div>
      <div class="row">
        <div class="col-6 pt-3">
          <div class="row mr-1">
            <select-list
              v-model="cost_item_id"
              :list="costItems"
              :modal="costItemModal"
              title="Статья поступления"
            />
          </div>
        </div>
        <div class="col-6 pt-3">
          <div class="row">
            <select-list
              v-model="partner_id"
              :list="partners"
              :modal="partnerModal"
              title="Контрагент"
            />
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
import PartnerModal from './PartnerModal.vue';
import CostItemModal from './CostItemModal.vue';

export default {
  name: 'CashInflowModal',
  components: {
    SelectList,
  },
  data() {
    return {
      title: 'Поступление',
      date: null,
      id: null,
      cost_item_id: null,
      partner_id: null,
      sum: 0,
    };
  },
  computed: {
    ...mapGetters(['costItems', 'partners']),
    partnerModal() {
      return PartnerModal;
    },
    costItemModal() {
      return CostItemModal;
    },
  },
  beforeMount() {
    this.title = this.$attrs.id ? 'Поступление' : 'Новое поступление';
    this.id = this.$attrs.id;
    this.cost_item_id = this.$attrs.cost_item_id;
    this.partner_id = this.$attrs.partner_id;
    this.sum = this.$attrs.sum;
    if (this.$attrs.date) {
      this.date = `${this.$attrs.date.slice(0, 10)}T${this.$attrs.date.slice(11, 16)}`;
    } else {
      const date = new Date();
      this.date = new Date(date.getTime() - (date.getTimezoneOffset() * 60000)).toISOString().substr(0, 16);
    }
  },
  methods: {
    save() {
      const params = {
        id: this.id,
        cost_item_id: this.cost_item_id,
        date: this.date,
        partner_id: this.partner_id,
        sum: this.sum,
      };

      if (this.id) {
        this.$store.dispatch('updateCashInflow', params);
      } else {
        this.$store.dispatch('addCashInflow', params);
      }
      this.close();
    },
    close() {
      this.$emit('close');
    },
  },
};
</script>

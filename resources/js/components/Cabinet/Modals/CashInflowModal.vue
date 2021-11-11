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
                v-model="editedModel.date"
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
                v-model="editedModel.sum"
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
              v-model="editedModel.cost_item_id"
              :list="costItems"
              :modal="costItemModal"
              title="Статья поступления"
            />
          </div>
        </div>
        <div class="col-6 pt-3">
          <div class="row">
            <select-list
              v-model="editedModel.partner_id"
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
  props: {
    model: {
      type: Object,
      default() {
        return {};
      },
    },
  },
  data() {
    return {
      editedModel: {
        id: null,
        date: null,
        cost_item_id: null,
        partner_id: null,
        sum: 0,
      },
    };
  },
  computed: {
    ...mapGetters(['costItems', 'partners']),

    title() {
      return this.model.id ? 'Поступление' : 'Новое поступление';
    },
    partnerModal() {
      return PartnerModal;
    },
    costItemModal() {
      return CostItemModal;
    },
  },
  beforeMount() {
    Object.assign(this.editedModel, JSON.parse(JSON.stringify(this.model)));
    if (this.model.date) {
      this.editedModel.date = `${this.model.date.slice(0, 10)}T${this.model.date.slice(11, 16)}`;
    } else {
      const date = new Date();
      this.editedModel.date = new Date(date.getTime() - (date.getTimezoneOffset() * 60000)).toISOString().substr(0, 16);
    }
  },
  methods: {
    save() {
      if (this.model.id) {
        this.$store.dispatch('cashInflows/update', this.editedModel);
      } else {
        this.$store.dispatch('cashInflows/create', this.editedModel);
      }
      this.close();
    },
    close() {
      this.$emit('close');
    },
  },
};
</script>

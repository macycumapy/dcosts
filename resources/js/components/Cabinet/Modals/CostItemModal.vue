<template>
  <div>
    <div class="row hd py-3">
      <div class="col text-center">
        <div class="header-text">
          {{ title }}
        </div>
      </div>
    </div>
    <form
      @submit.prevent="saveAndClose"
      class="form-horizontal"
    >
      <div class="row mb-3">
        <label>
          <input
            v-model="editedModel.name"
            class="w-100"
            type="text"
            name="name"
            required
            placeholder=" "
          >
          <span>Наименование</span>
        </label>
      </div>
      <div class="row">
        <select-list
          v-model="editedModel.type"
          :list="cashFlowTypes"
          :disabled="!isNew"
          optionValue="value"
          optionText="title"
          title="Тип"
        />
      </div>
      <div class="row">
        <div class="w-100 m-auto pt-3">
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
import SelectList from '../../General/SelectList.vue';

export default {
  name: 'CostItemModal',
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
        name: '',
        type: null,
      },
    };
  },
  computed: {
    title() {
      return this.editedModel.id ? this.editedModel.name : 'Новая категория';
    },
    isNew() {
      return !this.editedModel.id;
    },
    cashFlowTypes() {
      return Object.values(this.$constants.CASH_FLOW_TYPES);
    },
  },
  beforeMount() {
    Object.assign(this.editedModel, JSON.parse(JSON.stringify(this.model)));
  },
  methods: {
    save() {
      if (this.isNew) {
        return this.$store.dispatch('addCostItem', this.editedModel);
      }

      return this.$store.dispatch('updateCostItem', this.editedModel);
    },
    saveAndClose() {
      this.save().then(() => this.close());
    },
    close() {
      this.$emit('close');
    },
  },
};
</script>

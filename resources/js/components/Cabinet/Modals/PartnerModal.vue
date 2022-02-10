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
import modelMixin from '@mixins/modelModal';

export default {
  name: 'PartnerModal',
  mixins: [modelMixin],
  computed: {
    title() {
      return this.isNew ? 'Новый контрагент' : this.editedModel.name;
    },
  },
  methods: {
    save() {
      if (this.isNew) {
        return this.$store.dispatch('addPartner', this.editedModel);
      }

      return this.$store.dispatch('updatePartner', this.editedModel);
    },
  },
};
</script>

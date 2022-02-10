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
          v-model="editedModel.nomenclature_type_id"
          :list="nomenclatureTypes"
          :modal="nomenclatureTypeModal"
          title="Тип"
        />
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
import modelMixin from '@mixins/modelModal';
import SelectList from '../../General/SelectList.vue';
import NomenclatureTypeModal from './NomenclatureTypeModal.vue';

export default {
  name: 'NomenclatureModal',
  components: {
    SelectList,
  },
  mixins: [modelMixin],
  data() {
    return {
      editedModel: {
        nomenclature_type_id: null,
      },
    };
  },
  computed: {
    ...mapGetters(['nomenclatureTypes']),

    title() {
      return this.isNew ? 'Новая номенклатура' : this.editedModel.name;
    },
    nomenclatureTypeModal() {
      return NomenclatureTypeModal;
    },
  },
  methods: {
    save() {
      if (this.isNew) {
        return this.$store.dispatch('addNomenclature', this.editedModel);
      }

      return this.$store.dispatch('updateNomenclature', this.editedModel);
    },
  },
};
</script>

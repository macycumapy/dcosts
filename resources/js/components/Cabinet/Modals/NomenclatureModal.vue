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
      @submit.prevent="save"
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
import SelectList from '../../General/SelectList.vue';
import NomenclatureTypeModal from './NomenclatureTypeModal.vue';

export default {
  name: 'NomenclatureModal',
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
        nomenclature_type_id: null,
      },
    };
  },
  computed: {
    ...mapGetters(['nomenclatureTypes']),

    title() {
      return this.editedModel.id ? this.editedModel.name : 'Новая номенклатура';
    },
    nomenclatureTypeModal() {
      return NomenclatureTypeModal;
    },
  },
  beforeMount() {
    Object.assign(this.editedModel, JSON.parse(JSON.stringify(this.model)));
  },
  methods: {
    save() {
      if (this.editedModel.id) {
        this.$store.dispatch('updateNomenclature', this.editedModel);
      } else {
        this.$store.dispatch('addNomenclature', this.editedModel);
      }
      this.close();
    },
    close() {
      this.$emit('close');
    },
  },
};
</script>

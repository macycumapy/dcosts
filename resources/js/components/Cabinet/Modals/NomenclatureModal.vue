<template>
  <div>
    <div class="row hd py-3">
      <div class="col text-center">
        <div class="header-text">
          {{ oldName ? oldName : 'Новая номенклатура' }}
        </div>
      </div>
    </div>
    <form
      @submit.prevent="save"
      class="form-horizontal"
    >
      <div class="row mb-3">
        <label for="name">
          <input
            v-model="name"
            id="name"
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
          v-model="nomenclature_type_id"
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
  data() {
    return {
      oldName: '',
      name: '',
      nomenclature_type_id: null,
      id: null,
    };
  },
  computed: {
    ...mapGetters(['nomenclatureTypes']),
    nomenclatureTypeModal() {
      return NomenclatureTypeModal;
    },
  },
  beforeMount() {
    this.oldName = this.$attrs.id ? this.$attrs.name : '';
    this.name = this.$attrs.name;
    this.id = this.$attrs.id;
    this.nomenclature_type_id = this.$attrs.nomenclature_type_id;
  },
  methods: {
    save() {
      const params = {
        id: this.id,
        name: this.name,
        nomenclature_type_id: this.nomenclature_type_id ? this.nomenclature_type_id : null,
      };

      if (this.id) {
        this.$store.dispatch('updateNomenclature', params);
      } else {
        this.$store.dispatch('addNomenclature', params);
      }
      this.close();
    },
    close() {
      this.$emit('close');
    },
  },
};
</script>

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
        <label for="name">
          <input
            v-model="editedModel.name"
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
export default {
  name: 'NomenclatureTypeModal',
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
      },
    };
  },
  computed: {
    title() {
      return this.editedModel.id ? this.editedModel.name : 'Новый тип';
    },
  },
  beforeMount() {
    Object.assign(this.editedModel, JSON.parse(JSON.stringify(this.model)));
  },
  methods: {
    save() {
      if (this.editedModel.id) {
        this.$store.dispatch('updateNomenclatureType', this.editedModel);
      } else {
        this.$store.dispatch('addNomenclatureType', this.editedModel);
      }
      this.close();
    },
    close() {
      this.$emit('close');
    },
  },
};
</script>

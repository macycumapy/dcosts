export default {
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
    isNew() {
      return !this.editedModel.id;
    },
  },
  beforeMount() {
    Object.assign(this.editedModel, JSON.parse(JSON.stringify(this.model)));
  },
  methods: {
    saveAndClose() {
      this.save().then(() => this.close());
    },
    close() {
      this.$emit('close');
    },
  },
};

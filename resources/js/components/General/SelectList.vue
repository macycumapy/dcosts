<template>
  <div
    class="w-100"
    :class="{shown: showList}"
  >
    <div
      @keydown.enter.prevent="chose"
      class="select-list w-100"
    >
      <label>
        <input
          v-model="search"
          @click="show"
          @focus="show"
          :disabled="disabled"
          type="text"
          class="w-100"
        >
        <span
          v-text="title"
          :class="{'not-chosen':!chosen && !showList}"
        />
      </label>
      <div
        @click="show"
        v-text="chosen"
        class="select-list-chosen"
        :class="{hide:showList}"
      />
      <div
        v-if="showList"
        class="dropdown-list"
        :style="{width:$el.offsetWidth+'px'}"
      >
        <div
          v-for="item in filteredList"
          @click="chose(item)"
          :key="item.id"
          class="dropdown-list-item"
        >
          {{ item[optionText] }}
        </div>
        <div
          v-if="modal"
          @click="createNew"
          class="dropdown-list-item new"
        >
          <img
            class="mr-2 mw-10"
            src="/images/add.png"
            alt=""
            title="Добавить строку"
          >Новый
        </div>
      </div>
    </div>
    <div
      v-if="showList"
      @click="hide"
      class="select-list-background"
    />
  </div>
</template>

<script>
export default {
  name: 'SelectList',
  props: {
    /** Список значений */
    list: {
      type: Array,
      required: true,
    },
    /** Название поля значения */
    optionValue: {
      type: String,
      default: () => 'id',
    },
    /** Название поля заголовка */
    optionText: {
      type: String,
      default: () => 'name',
    },
    /** Текущее значение */
    value: {
      type: [Number, String],
      default: () => null,
    },
    /** Заголовок */
    title: {
      type: String,
      default: () => null,
    },
    /** Компонент с модалкой для создания нового элемента */
    modal: {
      type: Object,
      default: () => null,
    },
    /** Блокировка */
    disabled: {
      type: Boolean,
      default: () => false,
    },
    /** Props модалки для создания нового элемента */
    modalProps: {
      type: Object,
      default: () => {},
    },
  },
  data() {
    return {
      search: '',
      chosen: '',
      showList: false,
    };
  },
  computed: {
    filteredList() {
      return this.list.filter(value => value[this.optionText].toLowerCase().indexOf(this.search.toLowerCase()) >= 0);
    },
  },
  created() {
    if (this.value !== undefined && this.value !== null) {
      this.chosen = this.filteredList.filter(value => value[this.optionValue] === this.value).pop()[this.optionText];
    }
  },
  methods: {
    show() {
      if (!this.showList) {
        this.showList = true;
        this.search = this.chosen;
      }
    },

    hide() {
      this.showList = false;
      this.search = '';
    },

    chose(item) {
      const isChosen = item[this.optionValue] !== undefined;

      this.search = '';
      this.chosen = isChosen ? item[this.optionText] : '';
      this.$emit('input', isChosen ? item[this.optionValue] : null);
      this.showList = false;
    },

    /**
     * Открытие модалки для создания нового элемента справочника
     */
    createNew() {
      if (this.modal) {
        const modalProps = {
          [this.optionText]: this.search,
        };
        Object.assign(modalProps, this.modalProps);

        this.$modal.show(this.modal, { model: modalProps });
      }
    },
  },
};
</script>

<style scoped lang="scss">
.shown {
  z-index: 15;
}
</style>

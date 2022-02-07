<template>
  <div id="outflow-report">
   <div class="row">
     <div class="col">
       <label for="date-from">
         <input
           v-model="dateFrom"
           id="date-from"
           class="w-100 mr-2"
           type="date"
           name="date-from"
           required
         >
         <span>C</span>
       </label>
     </div>
     <div class="col">
       <label for="date-to">
         <input
           v-model="dateTo"
           id="date-to"
           class="w-100 mr-2"
           type="date"
           name="date-to"
           required
         >
         <span>по</span>
       </label>
     </div>
   </div>

    <div class="group-wrapper">
      <div class="group-row">
        <div>
          <div>Категория</div>
          <div>Тип расхода</div>
          <div>Расход</div>
        </div>
        <div class="mt-auto mb-auto text-end">
          Сумма
        </div>
      </div>
    </div>
    <div class="group-wrapper">
      <div
        v-for="category in data"
        :key="category.name"
      >
        <div class="group-row pl-3 pr-2 bg-green position-relative">
          <group-hider
            @hide="hideGroup"
            @show="showGroup"
            :hidden="isHiddenGroup(groupName('category', category.name))"
            :groupName="groupName('category', category.name)"
          />
          <div>{{ category.name }}</div>
          <div class="text-end">
            {{ category.sum }}
          </div>
        </div>
        <div
          v-show="!isHiddenGroup(groupName('category', category.name))"
          v-for="type in category.details"
          :key="type.name"
        >
          <div class="group-row pl-4 pr-2 bg-light-green position-relative">
            <group-hider
              @hide="hideGroup"
              @show="showGroup"
              :hidden="isHiddenGroup(groupName('type', category.name + type.name))"
              :groupName="groupName('type', category.name + type.name)"
              class="ml-2"
            />
            <div>
              {{ type.name }}
            </div>
            <div class="text-end">
              {{ type.sum }}
            </div>
          </div>
          <div
            v-show="!isHiddenGroup(groupName('type', category.name + type.name))"
            v-for="row in type.details"
            :key="row.nomenclature"
            class="group-row pl-5 pr-2"
          >
            <div>
              {{ row.nomenclature }}
            </div>
            <div class="text-end">
              {{ row.sum }}
            </div>
          </div>
        </div>
      </div>
    </div>

    <div
      v-if="data"
      class="group-wrapper"
    >
      <div class="group-row bg-green pr-2">
        <div>Итого</div>
        <div class="text-end">
          {{ getGroupSum(data).toFixed(2) }}
        </div>
      </div>
    </div>

    <div class="btn-group py-2 justify-content-between">
      <button
        @click="getOutflows"
        class="btn w-auto"
      >
        Сформировать
      </button>
    </div>

  </div>
</template>

<script>
import GroupHider from './GroupHider.vue';

export default {
  name: 'OutflowReport',
  components: {
    GroupHider,
  },
  data() {
    return {
      title: 'Отчет по расходам',
      data: null,
      dateFrom: null,
      dateTo: null,
      hiddenRows: [],
    };
  },
  created() {
    this.setDefaults();
    this.$store.commit('header/setTitle', 'Отчет по расходам');
  },
  methods: {
    setDefaults() {
      this.dateFrom = this.$moment().startOf('month').format('Y-MM-DD');
      this.dateTo = this.$moment().endOf('month').format('Y-MM-DD');
    },
    getOutflows() {
      return this.$store.dispatch('request/post', {
        url: 'report/outflows',
        params: {
          date_from: this.dateFrom,
          date_to: this.dateTo,
        },
      }).then((response) => {
        this.data = response.data;
      });
    },
    getGroupSum(group) {
      if (Array.isArray(group)) {
        return group.reduce((previous, current) => Number(previous) + Number(current.sum), 0);
      }
      if (typeof group === 'object') {
        return Object.values(group).reduce((previous, current) => Number(previous) + this.getGroupSum(current), 0);
      }
      return 0;
    },
    groupName(prefix, name) {
      return `${prefix}_${name}`;
    },
    isHiddenGroup(groupName) {
      return this.hiddenRows.indexOf(groupName) >= 0;
    },
    hideGroup(groupName) {
      this.hiddenRows.push(groupName);
    },
    showGroup(groupName) {
      this.hiddenRows.splice(this.hiddenRows.indexOf(groupName), 1);
    },
  },
};
</script>

<style scoped lang="scss">
.group-wrapper {
  display: grid;

  .group-row {
    display: grid;
    grid-column-start: 1;
    grid-column-end: 3;
    grid-template-columns: 3fr 1fr;
    border-bottom: 1px solid #5b6c5b;
  }

  .bg-green {
    background-color: #1d643b;
  }

  .bg-light-green {
    background-color: #328e59;
  }
}
</style>

<template>
  <div id="sidebar">
    <div class="row">
      <div class="col-12">
        <router-link :to="{ name: 'home' }">
          <div class="logo m-auto" />
        </router-link>
      </div>
    </div>
    <ul class="py-4 pl-1">
      <li>
        <router-link :to="{ name: 'nomenclatureType' }">
          Типы номенклатуры
        </router-link>
      </li>
      <li>
        <router-link :to="{ name: 'nomenclature' }">
          Номенклатура
        </router-link>
      </li>
      <li>
        <router-link :to="{ name: 'partners' }">
          Контрагенты
        </router-link>
      </li>
      <li>
        <router-link :to="{ name: 'costItems' }">
          Статьи затрат
        </router-link>
      </li>
    </ul>
    <ul class="py-1 pl-1">
      <li>
        <a
          @click="logout"
          href="javascript:void(0);"
        >Выйти</a>
      </li>
    </ul>
  </div>
</template>

<script>
import { mapActions } from 'vuex';

export default {
  name: 'SidebarComponent',
  methods: {
    ...mapActions(['logout']),
  },
};
</script>

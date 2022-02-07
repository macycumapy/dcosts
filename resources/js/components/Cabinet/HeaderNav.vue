<template>
  <header
    id="header-nav"
  >
    <div class="wrapper">
      <div
        @click="toggleMenu"
        class="menu"
        :class="{active: showMenu}"
      >
        <span>dcosts</span>
        <div class="action">
          <span class="bar" />
          <span class="bar" />
        </div>
      </div>
      <div
        id="header-title"
        v-text="title"
      />
    </div>

    <nav
      id="nav"
      :class="{'display': showMenu}"
    >
      <div
        class="content"
        :class="{active: showMenu}"
      >
        <div class="container-prLink">
          <ul>
            <li
              v-for="link in links"
              :key="link.title"
            >
              <router-link
                @click.native="toggleMenu"
                v-text="link.title"
                :to="link.route"
              />
            </li>
            <li>
              <a
                @click="logout"
                href="javascript:void(0);"
              >Выйти</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';

export default {
  name: 'HeaderNav',
  data() {
    return {
      showMenu: false,
    };
  },
  computed: {
    ...mapGetters('header', ['title']),

    links() {
      return [
        {
          title: 'Dashboard',
          route: { name: 'home' },
        },
        {
          title: 'Типы номенклатуры',
          route: { name: 'nomenclatureType' },
        },
        {
          title: 'Номенклатура',
          route: { name: 'nomenclature' },
        },
        {
          title: 'Контрагенты',
          route: { name: 'partners' },
        },
        {
          title: 'Категории доходов и расходов',
          route: { name: 'costItems' },
        },
        {
          title: 'Поступления',
          route: { name: 'cashInflows' },
        },
        {
          title: 'Расходы',
          route: { name: 'cashOutflows' },
        },
        {
          title: 'Отчет по расходам',
          route: { name: 'outflowsReport' },
        },
      ];
    },
  },
  methods: {
    ...mapActions(['logout']),
    toggleMenu() {
      this.showMenu = !this.showMenu;
    },

    close() {
      this.showMenu = false;
    },
  },
};
</script>

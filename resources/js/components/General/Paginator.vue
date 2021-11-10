<template>
  <div
    id="paginator"
    class="d-flex w-100"
  >
    <a
      v-if="!pagesContainer.includes(1)"
      @click.prevent="getList(1)"
      v-text="1"
      href="#"
      class="p-2"
      :class="{'text-white': currentPage !== 1}"
    />
    <span
      v-if="currentPage > 3"
      class="m-auto"
    >...</span>
    <a
      v-for="page in pagesContainer"
      @click.prevent="getList(page)"
      :key="page"
      v-text="page"
      href="#"
      class="p-2"
      :class="{'text-white': currentPage !== page}"
    />
    <span
      v-if="currentPage < pages - 2"
      class="m-auto"
    >...</span>
    <a
      v-if="!pagesContainer.includes(pages)"
      @click.prevent="getList(pages)"
      v-text="pages"
      href="#"
      class="p-2"
      :class="{'text-white': currentPage !== pages}"
    />
  </div>
</template>

<script>
export default {
  name: 'PaginatorComponent',
  props: {
    pages: {
      type: Number,
      required: true,
    },
    currentPage: {
      type: Number,
      required: true,
    },
    getList: {
      type: Function,
      required: true,
    },
  },
  computed: {
    pagesContainer() {
      const pages = [];

      if (this.currentPage > 1) {
        pages.push(this.currentPage - 1);
      }
      pages.push(this.currentPage);
      if (this.currentPage < this.pages) {
        pages.push(this.currentPage + 1);
      }

      // let page = 1;
      // while (page <= 3) {
      //   pages.push(page);
      //   page += 1;
      //   if (this.currentPage !== this.pages) {
      //     pages.push('...');
      //   }
      // }
      // console.log(pages)
      return pages;
    },
  },
};
</script>

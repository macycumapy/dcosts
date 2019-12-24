<template>
    <div>
        <div class="row hd py-3">
            <div class="col text-center">
                <div class="header-text">{{ title }}</div>
            </div>
        </div>
        <form @submit.prevent="save" class="form-horizontal">
            <div class="row">
                <div class="w-100 m-auto">
                    <input id="date" class="w-100" type="datetime-local" name="date" v-model="date" required
                           placeholder="Дата">
                </div>
            </div>
            <div class="row">
                <div class="w-100 m-auto pt-3">
                    <model-list-select :list="cost_items"
                                       v-model="cost_item_id"
                                       option-value="id"
                                       option-text="name"
                                       placeholder="Статья затрат">
                    </model-list-select>
                </div>
            </div>
            <div class="row">
                <div class="w-100 m-auto pt-3">
                    <model-list-select :list="partners"
                                       v-model="partner_id"
                                       option-value="id"
                                       option-text="name"
                                       placeholder="Контрагент">
                    </model-list-select>
                </div>
            </div>
            <div class="row">
                <div class="w-100 m-auto pt-3">
                    <input class="w-100" type="number" name="date" step="0.01" v-model="sum" required>
                </div>
            </div>

            <div class="row">
                <div class="w-100 m-auto pt-3">
                    <div class="btn-group">
                        <input type="button" @click="close" value="Отменить" class="btn red mr-3">
                        <input type="submit" value="Записать" class="btn">
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>
<script>
    import {ModelListSelect} from 'vue-search-select'

    export default {
        name: 'cashInflowModal',
        components: {ModelListSelect},
        data() {
            return {
                title: 'Поступление',
                date: new Date($.now()).toISOString().substr(0, 16),
                id: null,
                cost_item_id: null,
                partner_id: null,
                sum: 0,
            }
        },
        computed: {
            cost_items: function () {
                return this.$store.getters.getCostItems;
            },
            partners: function () {
                return this.$store.getters.getPartners;
            },
        },
        beforeMount() {
            this.title = this.$attrs.id ? 'Поступление' : 'Новое поступление';
            this.id = this.$attrs.id;
            this.cost_item_id = this.$attrs.cost_item_id;
            this.partner_id = this.$attrs.partner_id;
            this.sum = this.$attrs.sum;
            if (this.$attrs.date) this.date = this.$attrs.date.slice(0, 10) + 'T' + this.$attrs.date.slice(11, 16);
        },
        methods: {
            save() {
                let params = {
                    id: this.id,
                    cost_item_id: this.cost_item_id,
                    date: this.date,
                    partner_id: this.partner_id,
                    sum: this.sum,
                };

                if (this.id) {
                    this.$store.dispatch('updateCashInflow', params)
                } else {
                    this.$store.dispatch('addCashInflow', params)
                }
                this.close()
            },
            close() {
                this.$emit('close')
            }
        }
    }
</script>

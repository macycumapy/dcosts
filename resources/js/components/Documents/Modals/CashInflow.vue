<template>
    <div>
        <div class="row hd py-3">
            <div class="col-12 text-center">
                <div class="header-text">{{ title }}</div>
            </div>
        </div>
        <form @submit.prevent="save" class="form-horizontal">
            <div class="row">
                <div class="col-6">
                    <div class="row mr-1">
                        <label>
                            <input id="date" class="w-100" type="datetime-local" name="date" v-model="date" required
                            placeholder=" ">
                            <span>Дата</span>
                        </label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="row">
                        <label for="sum">
                            <input id="sum" class="w-100" type="number" name="sum" step="0.01" v-model="sum" required placeholder=" ">
                            <span>Сумма</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6 pt-3">
                    <div class="row mr-1">
                        <select-list
                            v-model="cost_item_id"
                            list-name="costItems"
                            title="Статья затрат"
                        />
                    </div>
                </div>
                <div class="col-6 pt-3">
                    <div class="row">
                        <select-list
                            v-model="partner_id"
                            list-name="partners"
                            title="Контрагент"
                        />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 pt-3">
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
    export default {
        name: 'cashInflowModal',
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

<template>
    <div>
        <div class="row hd py-3">
            <div class="col text-center">
                <div class="header-text">{{ title }}</div>
            </div>
        </div>
        <form @submit.prevent="save" class="form-horizontal">
            <div class="row">
                <div class="col-4">
                    <div class="row mr-1">
                        <label for="date">
                            <input id="date" class="w-100 mr-2" type="datetime-local" name="date" v-model="date" required
                                                         placeholder="Дата">
                            <span>Дата</span>
                        </label>
                    </div>
                </div>
                <div class="col-8">
                    <div class="row">
                        <select-list
                            v-model="cost_item_id"
                            list-name="costItems"
                            title="Статья затрат"
                        />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 details">
                    <div class="greed-details text-center">
                        <div>Номенклатура</div>
                        <div>Кол-во</div>
                        <div>Цена</div>
                        <div>Сумма</div>
                        <div></div>
                    </div>
                    <div class="greed-details" v-for="item in details">
                        <select-list
                            v-model="item.nomenclature_id"
                            list-name="nomenclatures"
                        />
                        <input class="w-100" type="number" v-model="item.quantity" required
                               placeholder="Количество">
                        <input class="w-100 text-end" type="number" step="0.01" v-model="item.cost" required
                               placeholder="Цена">
                        <input class="w-100 text-end" type="number" readonly
                               v-model="(item.quantity * item.cost).toFixed(2)">
                        <img class="m-auto" src="./../../../../img/remove.png" alt="" @click="removeRow(item)">
                    </div>
                    <div class="greed-details">
                        <div></div>
                        <div></div>
                        <div class="text-end m-auto">Итого:</div>
                        <div class="text-end m-auto">{{ sum.toFixed(2) }}</div>
                        <img class="m-auto" src="./../../../../img/add.png" alt="" @click="addNewRow">
                    </div>
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
    export default {
        name: 'cashFlowModal',
        data() {
            return {
                title: 'Расход',
                date: new Date($.now()).toISOString().substr(0, 16),
                id: null,
                cost_item_id: null,
                details: [],
            }
        },
        computed: {
            sum: function () {
                return this.details.length > 0 ?
                    this.details.map((item) => {
                        return (item.cost * item.quantity)
                    }).reduce((prev, cur) => {
                        return prev + cur
                    }) : 0;
            }
        },
        beforeMount() {
            this.title = this.$attrs.id ? 'Расход' : 'Новый расход';
            this.id = this.$attrs.id;
            this.cost_item_id = this.$attrs.cost_item_id;
            if (this.$attrs.date) this.date = this.$attrs.date.slice(0, 10) + 'T' + this.$attrs.date.slice(11, 16);
            if (this.$attrs.details) this.details = this.$attrs.details.slice();
        },
        methods: {
            addNewRow() {
                this.details.push({
                    id: null,
                    nomenclature_id: null,
                    quantity: 1,
                    cost: 0,
                })
            },
            removeRow(item) {
                this.details.splice(this.details.indexOf(item), 1);
            },
            save() {
                let params = {
                    id: this.id,
                    cost_item_id: this.cost_item_id,
                    date: this.date,
                    details: this.details
                };

                if (this.id) {
                    this.$store.dispatch('updateCashFlow', params)
                } else {
                    this.$store.dispatch('addCashFlow', params)
                }
                this.close()
            },
            close() {
                this.$emit('close')
            }
        }
    }
</script>

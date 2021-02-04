<template>
    <div id="home">
        <div class="row">
            <div class="col-xl-8 col-lg-12 col-md-12 col-12">
                <div class="w-100 text-center">
                    <div class="header-text py-3">{{title}}</div>
                </div>
                <div class="list-header">
                    <div class="col-xl-3 col-lg-3 col-md-4 col-4">Дата</div>
                    <div class="col-xl-7 col-lg-7 col-md-6 col-5">Статья</div>
                    <div class="col-md-2 col-3">Сумма</div>
                </div>
                <div class="list">
                    <div class="row pl-4 position-relative" v-for="item in cashFlows">
                        <div class="col-xl-3 col-lg-3 col-md-4 col-4 text-center">
                            {{ new Date(item.date).toLocaleString().substr(0,17)}}
                        </div>
                        <div class="col-xl-7 col-lg-7 col-md-6 col-5 text-center">{{ item.cost_item }}</div>
                        <div class="col-md-2 col-3 text-end pr-4" :class="{red:item.is_flow}">{{
                            item.sum.toFixed(2) }}
                        </div>
                        <div class="list-btn-group">
                            <img src="./../../img/edit.png" alt="edit" @click="edit(item)">
                            <img src="./../../img/copy.png" alt="copy" @click="copy(item)">
                            <img src="./../../img/delete.png" alt="delete" @click="remove(item)">
                        </div>
                    </div>
                </div>
                <div class="btn-group py-2">
                    <button class="btn mr-2" @click="add(false)">Поступление</button>
                    <button class="btn" @click="add(true)">Расход</button>
                </div>
            </div>
        </div>
        <modals-container></modals-container>
        <v-dialog></v-dialog>
    </div>
</template>

<script>
    import ModalFlow from './Documents/Modals/CashFlow'
    import ModalInflow from './Documents/Modals/CashInflow'
    import {router} from "../router";

    export default {
        data() {
            return {
                title: 'Движения',
                loading: true,
                error: null,
            };
        },
        created() {
            this.$store.dispatch('getCashTotalList')
            this.$store.dispatch('getCostItems')
            this.$store.dispatch('getNomenclature')
            this.$store.dispatch('getPartners')
        },
        computed: {
            cashFlows: function () {
                return this.$store.getters.getCashTotalList;
            }
        },
        methods: {
            add(isFlow) {
                this.$modal.show(isFlow ? ModalFlow : ModalInflow)
            },

            edit(item) {
                this.$modal.show(item.is_flow ? ModalFlow : ModalInflow, item)
            },

            copy(item) {
                this.$modal.show(item.is_flow ? ModalFlow : ModalInflow, {
                    cost_item_id: item.cost_item_id,
                    partner_id: item.partner_id,
                    details: item.details,
                    sum: item.sum,
                })
            },

            remove(item) {
                this.$modal.show('dialog', {
                    title: 'Удалить документ?',
                    buttons: [
                        {
                            title: 'Нет',
                            class: 'btn red'
                        },
                        {
                            title: 'Да',
                            handler: () => {
                                if (item.is_flow)
                                    this.$store.dispatch('deleteCashFlow', item.id)
                                        .then(() => {
                                            this.$store.dispatch('getCashTotalList')
                                        });
                                else
                                    this.$store.dispatch('deleteCashInflow', item.id)
                                        .then(() => {
                                            this.$store.dispatch('getCashTotalList')
                                        });
                                this.$modal.hide('dialog');
                            },
                            default: true,
                            class: 'btn'
                        }
                    ]
                })
            }
        }
    }
</script>

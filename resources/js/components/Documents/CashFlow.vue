<template>
    <div id="cash-flow">
        <div class="row justify-content-center">
            <div class="col-xl-7 col-lg-12 col-md-12 col-12">
                <div class="w-100 text-center">
                    <div class="header-text py-3">{{title}}</div>
                </div>
                <div class="list-header">
                    <div class="col-xl-3 col-lg-3 col-md-6 col-6 text-start">Дата</div>
                    <div class="col-xl-9 col-lg-9 col-md-6 col-6 text-end">Сумма</div>
                </div>
                <div class="list">
                    <div class="row pl-4 position-relative" v-for="item in cashFlows">
                        <div class="col-xl-3 col-lg-3 col-md-6 col-6">
                            {{ new Date(item.date).toLocaleString().substr(0,17)}}
                        </div>
                        <div class="col-xl-9 col-lg-9 col-md-6 col-6 text-end pr-4">
                            {{ item.sum.toFixed(2) }}
                        </div>
                        <div class="list-btn-group">
                            <img src="./../../../img/edit.png" alt="edit" @click="edit(item)">
                            <img src="./../../../img/copy.png" alt="copy" @click="copy(item)">
                            <img src="./../../../img/delete.png" alt="delete" @click="remove(item)">
                        </div>
                    </div>
                </div>
                <div class="btn-group py-2">
                    <button class="btn" @click="add">Добавить</button>
                </div>
            </div>
        </div>
        <modals-container></modals-container>
        <v-dialog></v-dialog>
    </div>
</template>
<script>
    import Modal from './Modals/CashFlow'

    export default {
        data() {
            return {
                title: 'Расходы',
                loading: true,
                error: null,
            };
        },
        created() {
            this.$store.dispatch('getCashFlows')
            this.$store.dispatch('getCostItems')
            this.$store.dispatch('getNomenclature')
        },
        computed: {
            cashFlows: function () {
                return this.$store.getters.getCashFlows;
            }
        },
        methods: {
            add() {
                this.$modal.show(Modal)
            },

            edit(item) {
                this.$modal.show(Modal, item)
            },

            copy(item) {
                this.$modal.show(Modal, {
                    cost_item_id: item.cost_item_id,
                    details: item.details
                })
            },

            remove(item) {
                this.$modal.show('dialog', {
                    title: 'Удалить затраты?',
                    buttons: [
                        {
                            title: 'Нет',
                            class: 'btn red'
                        },
                        {
                            title: 'Да',
                            handler: () => {
                                this.$store.dispatch('deleteCashFlow', item.id);
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

<template>
    <div class="partner">
        <div class="row justify-content-center">
            <div class="col-xl-7 col-lg-12 col-md-12 col-12">
                <div class="w-100 text-center">
                    <div class="header-text py-3">{{title}}</div>
                </div>
                <div class="list-header">
                    <div class="col-xl-3 col-lg-3 col-md-6 col-6 text-start">Наименование</div>
                </div>
                <div class="list">
                    <div class="row pl-4 position-relative" v-for="item in partners">
                        <div class="col-xl-3 col-lg-3 col-md-6 col-6">{{ item.name }}</div>
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
    import Modal from './Modals/Partner'

    export default {
        data() {
            return {
                title: 'Контрагенты',
                loading: true,
                error: null,
            };
        },
        created() {
            this.$store.dispatch('getPartners')
        },
        computed: {
            partners: function () {
                return this.$store.getters.getPartners;
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
                    name: item.name
                })
            },

            remove(item) {
                this.$modal.show('dialog', {
                    title: 'Удалить ' + item.name + '?',
                    buttons: [
                        {
                            title: 'Нет',
                            class: 'btn red'
                        },
                        {
                            title: 'Да',
                            handler: () => {
                                this.$store.dispatch('deletePartner', item.id);
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

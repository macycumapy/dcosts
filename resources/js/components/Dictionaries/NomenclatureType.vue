<template>
    <div class="nomenclature-type">
        <div class="w-100 text-center">
            <div class="header-text py-3">{{title}}</div>
        </div>
        <div class="list-header">
            <div class="col-11">Наименование</div>
        </div>
        <div class="list">
            <div class="row pl-4" v-for="item in nomenclatureTypes">
                <div class="col-xl-9 col-lg-7 col-md-6 col-6">{{ item.name }}</div>
                <div class="col-xl-3 col-lg-5 col-md-6 col-6">
                    <img src="./../../../img/delete.png" alt="delete" @click="remove(item)">
                    <img src="./../../../img/copy.png" alt="copy" @click="copy(item)">
                    <img src="./../../../img/edit.png" alt="edit" @click="edit(item)">
                </div>
            </div>
        </div>
        <div class="btn-group py-2">
            <button class="btn" @click="add">Добавить</button>
        </div>
        <modals-container></modals-container>
        <v-dialog></v-dialog>
    </div>
</template>
<script>
    import Modal from './Modals/NomenclatureType'

    export default {
        data() {
            return {
                title: 'Типы номенклатуры',
                loading: true,
                error: null,
            };
        },
        created() {
            this.$store.dispatch('getNomenclatureType')
        },
        computed: {
            nomenclatureTypes: function () {
                return this.$store.getters.getNomenclatureType;
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

            remove(item){
                this.$modal.show('dialog', {
                    title:'Удалить ' + item.name +'?',
                    buttons: [
                        {
                            title: 'Нет',
                            class:'btn red'
                        },
                        {
                            title: 'Да',
                            handler: () => {
                                this.$store.dispatch('deleteNomenclatureType', item.id);
                                this.$modal.hide('dialog');
                            },
                            default: true,
                            class:'btn'
                        }
                    ]
                })
            }
        }
    }
</script>

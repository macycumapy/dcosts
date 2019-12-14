<template>
    <div>
        <div class="row hd py-3">
            <div class="col text-center">
                <div class="header-text">{{oldName ? oldName : 'Новая номенклатура'}}</div>
            </div>
        </div>
        <form @submit.prevent="save" class="form-horizontal">
            <div class="row">
                <div class="w-100 m-auto">
                    <input id="name" class="w-100" type="text" name="name" v-model="name" required
                           placeholder="Наименование">
                </div>
            </div>
            <!--            <div class="row">-->
            <!--                <div class="w-100 m-auto pt-3">-->
            <!--                    <select v-model="nomenclature_type_id" class="w-100">-->
            <!--                        <option v-for="row in nomenclature_types" :value="row.id">{{ row.name }}</option>-->
            <!--                    </select>-->
            <!--                </div>-->
            <!--            </div>-->
            <div class="row">
                <div class="w-100 m-auto pt-3">
                    <model-list-select :list="nomenclature_types"
                                       v-model="nomenclature_type_id"
                                       option-value="id"
                                       option-text="name"
                                       placeholder="Тип">
                    </model-list-select>
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
        name: 'nomenclatureModal',
        components: {ModelListSelect},
        data() {
            return {
                oldName: '',
                name: '',
                nomenclature_type_id: null,
                id: null
            }
        },
        computed: {
            nomenclature_types: function () {

                return this.$store.getters.getNomenclatureType;
            }
        },
        beforeMount() {
            this.oldName = this.$attrs.id ? this.$attrs.name : '';
            this.name = this.$attrs.name;
            this.id = this.$attrs.id;
            this.nomenclature_type_id = this.$attrs.nomenclature_type_id;
        },
        methods: {
            save() {
                let params = {
                    id: this.id,
                    name: this.name,
                    nomenclature_type_id: this.nomenclature_type_id ? this.nomenclature_type_id : null
                };

                console.log(params)

                if (this.id) {
                    this.$store.dispatch('updateNomenclature', params)
                } else {
                    this.$store.dispatch('addNomenclature', params)
                }
                this.close()
            },
            close() {
                this.$emit('close')
            }
        }
    }
</script>

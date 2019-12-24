<template>
    <div>
        <div class="row hd py-3">
            <div class="col text-center">
                <div class="header-text">{{oldName ? oldName : 'Новый контрагент'}}</div>
            </div>
        </div>
        <form @submit.prevent="save" class="form-horizontal">
            <div class="row">
                <div class="w-100 m-auto">
                    <input id="name" class="w-100" type="text" name="name" v-model="name" required
                           placeholder="Наименование">
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
        name: 'partnerModal',
        data () {
            return {
                oldName: '',
                name: '',
                id: null
            }
        },
        beforeMount() {
            this.oldName = this.$attrs.id ? this.$attrs.name : '';
            this.name = this.$attrs.name;
            this.id = this.$attrs.id;
        },
        methods: {
            save() {
                let params = {
                    id:this.id,
                    name:this.name,
                };

                if(this.id) {
                    this.$store.dispatch('updatePartner',params)
                } else {
                    this.$store.dispatch('addPartner',params)
                }
                this.close()
            },
            close() {
                this.$emit('close')
            }
        }
    }
</script>

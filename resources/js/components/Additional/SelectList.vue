<template>
    <div class="w-100">
        <div class="select-list w-100" v-on:keydown.enter.prevent="chose">
            <input type="text" class="w-100" @click="show" @focus="show" v-model="search">
            <div class="select-list-chosen" @click="show" :class="{hide:showList}" v-text="chosen"></div>
            <div class="dropdown-list" :style="{width:this.$el.offsetWidth+'px'}" v-if="showList">
                <div class="dropdown-list-item" @click="chose(item)" v-for="item in list">{{item[optionText]}}</div>
                <div class="dropdown-list-item new" @click="createNew">Новый</div>
            </div>
        </div>
        <div class="select-list-background" @click="hide" v-if="showList"></div>
    </div>
</template>

<script>
    import CostItemModal from "../Dictionaries/Modals/CostItem";
    import PartnerModal from "../Dictionaries/Modals/Partner";
    import NomenclatureModal from "../Dictionaries/Modals/Nomenclature";
    import NomenclatureTypeModal from "../Dictionaries/Modals/NomenclatureType";

    export default {
        name: "selectList",
        data() {
            return {
                search: '',
                chosen: '',
                showList: false,
            }
        },
        props: {
            listName: String,
            optionValue: {
                type: String,
                default: () => {
                    return 'id'
                }
            },
            optionText: {
                type: String,
                default: () => {
                    return 'name'
                }
            },
            value: Number,
        },
        created() {
            switch (this.listName) {
                case 'costItems':
                    this.$store.dispatch('getCostItems');
                    break;
                case 'nomenclatures':
                    this.$store.dispatch('getNomenclature');
                    break;
                case 'nomenclatureTypes':
                    this.$store.dispatch('getNomenclatureType');
                    break;
                case 'partners':
                    this.$store.dispatch('getPartners');
                    break;

                default:
                    console.log('list not founded')
            }

            if (this.value !== undefined && this.value !== null) {
                this.chosen = this.list.filter(value => {
                    return value[this.optionValue] === this.value;
                }).pop()[this.optionText];
            }
        },
        computed: {
            list: function () {
                let searchResult = [];

                switch (this.listName) {
                    case 'costItems':
                        searchResult = this.$store.getters.getCostItems;
                        break;
                    case 'nomenclatures':
                        searchResult = this.$store.getters.getNomenclature;
                        break;
                    case 'nomenclatureTypes':
                        searchResult = this.$store.getters.getNomenclatureType;
                        break;
                    case 'partners':
                        searchResult = this.$store.getters.getPartners;
                }

                return searchResult.filter(value => {
                    return value[this.optionText].toLowerCase().indexOf(this.search.toLowerCase()) >= 0;
                })
            },
        },
        methods: {
            show() {
                if (!this.showList) {
                    this.showList = true;
                    this.search = this.chosen;
                }
                this.$el.style.zIndex = 15;
                // $('.dropdown-list')[0].style.width = this.$el.offsetWidth;
            },

            hide() {
                this.showList = false;
                this.search = '';

                this.$el.style.zIndex = '';
            },

            chose(item) {
                let isChosen = item[this.optionValue] !== undefined;

                this.search = '';
                this.chosen = isChosen ? item[this.optionText] : '';
                this.$emit('input', isChosen ? item[this.optionValue] : null);
                this.showList = false;
            },

            createNew() {
                let modalForm;

                switch (this.listName) {
                    case 'costItems':
                        modalForm = CostItemModal;
                        break;
                    case 'nomenclatures':
                        modalForm = NomenclatureModal;
                        break;
                    case 'nomenclatureTypes':
                        modalForm = NomenclatureTypeModal;
                        break;
                    case 'partners':
                        modalForm = PartnerModal;
                }

                this.$modal.show(modalForm, {[this.optionText]: this.search});
            },
        },

    }
</script>

<style scoped lang="scss">
    .select-list {
        position: relative;
        input {
            min-height: 41px;
            z-index: 2;
            position: inherit;
        }

        /*z-index: 2;*/

        .select-list-chosen {
            position: absolute;
            top: 0;
            left:0;
            padding: 8px 7px;
            font-weight: 500;
            font-size: 16px;
            width: 100%;
            overflow: hidden;
        }

        .dropdown-list {
            position: fixed;
            z-index: 2;
            color: black;
            background: lightgrey;
            width: 50vh;
            max-height: 150px;
            overflow-y: auto;

            &::-webkit-scrollbar {
                max-width: 5px;
            }

            &::-webkit-scrollbar-button {
                display: none;
            }

            &::-webkit-scrollbar-thumb {
                background: #212529;
            }


            .dropdown-list-item {
                cursor: pointer;
                overflow: hidden;
                padding: 3px 5px;

                &:hover,
                &:focus,
                &:active {
                    background: white;
                }

                &.new {
                    border-top: 1px solid black;
                    position: relative;
                }
            }
        }
    }

    .select-list-background {
        position: absolute;
        height: 200vh;
        width: 200vh;
        z-index: 1;
        left: -100vh;
        bottom: -100vh;
    }

    .hide {
        display: none;
    }
</style>

<template>
    <AppLayout>
        <div class="container page-container">
            <div class="mx-auto grid grid-cols-12 gap-4 p-1">
                <div class="col-span-12 sm:col-span-2">
                    <AdminMenu/>
                </div>
                <div class="col-span-12 sm:col-span-10">
                    <div class="bg-green-100 border-t border-b border-green-500 text-green-700 px-4 py-3" role="alert" v-if="showAlert">
                        <p class="text-sm">{{ $page.props.flash.success_object_update_save }}</p>
                    </div>
                    <div class="page-heading">
                        <div class="heading-container">
                            <div class="heading-right-margin">
                                <h1>Upraviť záznam (Mena)</h1>
                            </div>
                            <div v-if="inputEnable" class="heading-right-margin">
                                <div class="pr-2">
                                    <Icon name="update" width="20" @click="setInputs"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="heading-container">
                            <div v-if="!inputEnable" class="heading-right-margin heading-left-margin ">
                                <button @click.prevent="update">Uložiť</button>
                            </div>
                            <div v-if="!inputEnable">
                                <button @click.prevent="reset">Zrušiť</button>
                            </div>
                        </div>
                    </div>
                    <div class="cards">
                        <input type="hidden" name="id" v-model="this.currency[0].id" />
                        <div class="card bg-gray-100">
                            <div class="card-row">
                                <div>Názov: </div>
                                <div>
                                    <input type="text" v-model="this.currency[0].currency_title" :disabled="inputEnable"
                                        class="mt-1 shadow appearance-none border rounded w-full py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline"
                                        id="currency_title"/>
                                    <div v-if="$page.props.errors.currency_title" class="text-red-500">
                                        {{ $page.props.errors.currency_title }}
                                    </div>
                                </div>
                            </div>
                            <div class="card-row">
                                <div>Symbol: </div>
                                <div>
                                    <input type="text" v-model="this.currency[0].currency_symbol" :disabled="inputEnable"
                                        class="mt-1 shadow appearance-none border rounded w-full py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline"
                                        id="currency_symbol"/>
                                    <div v-if="$page.props.errors.currency_symbol" class="text-red-500">
                                        {{ $page.props.errors.currency_symbol }}
                                    </div>
                                </div>
                            </div>
                            <div class="card-row">
                                <div>Skratka: </div>
                                <div>
                                    <input type="text" v-model="this.currency[0].shortcut" :disabled="inputEnable"
                                        class="mt-1 shadow appearance-none border rounded w-full py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline"
                                        id="shortcut"/>
                                    <div v-if="$page.props.errors.shortcut" class="text-red-500">
                                        {{ $page.props.errors.shortcut }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import { Inertia } from '@inertiajs/inertia';
    import AdminMenu from '@/Components/AdminMenu.vue';
    import Icon from '@/Components/Icon.vue';

    export default {
        name: 'AdminCurrencyDetail',
        components: {
            AppLayout,
            AdminMenu,
            Icon,
        },
        props: {
            currency:{
                type: Object,
                default: () => { }
            },
        },
        data() {
            return {
                inputEnable: true,
                tmpObject: {
                    currency_title: this.currency[0].currency_title,
                    currency_symbol: this.currency[0].currency_symbol,
                    shortcut: this.currency[0].shortcut,
                },
            }
        },
        methods: {
            setInputs(){
                this.inputEnable = false;
            },
            reset(){
                this.inputEnable = true;

                this.currency[0].currency_title = this.tmpObject.currency_title;
                this.currency[0].currency_symbol = this.tmpObject.currency_symbol;
                this.currency[0].shortcut = this.tmpObject.shortcut;
            },
            update(){
                this.inputEnable = true;

                Inertia.post(route("dashboard-update-currency"), this.currency[0]);
            },
        },
        computed: {
            showAlert() {
                if(this.$page.props.flash.success_object_update_save !== null) {
                    setTimeout(() => {
                        this.$page.props.flash.success_object_update_save = null
                    }, 3000);
                    return true;
                }

                return false;
            },
        },
    }
</script>

<style scoped>
.heading-container {
    display:flex; 
    align-items: center; 
    padding-left: 0.5rem;
}

.heading-right-margin {
    margin-right: 10px;
}

.heading-left-margin {
    margin-left: 10px;
}

.card {
    padding: 0.5rem;
    border: none;
}

.card-row {
    margin-bottom: 15px;
}

.cards {
    max-width: 1200px;
    margin: 0 10px;
    display: grid;
    grid-gap: 1rem;
}

input:disabled {
    background-color: #e9ecef;
}

textarea:disabled {
    background-color: #e9ecef;
}

/* Screen larger than 600px? 2 column */
@media (min-width: 600px) {
    .cards { grid-template-columns: repeat(2, 1fr); }
}

/* Screen larger than 900px? 3 columns */
@media (min-width: 900px) {
    .cards { grid-template-columns: repeat(2, 1fr); }
}
</style>
<template>
    <AppLayout>
        <div class="container page-container">
            <div class="mx-auto grid grid-cols-12 gap-4 p-1">
                <div class="col-span-12 sm:col-span-2">
                    <AdminMenu/>
                </div>
                <div class="col-span-12 sm:col-span-10">
                    <div class="page-heading">
                        <div class="heading-container">
                            <div class="heading-right-margin">
                                <h1>Pridať záznam (Mena)</h1>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="heading-container">
                            <div class="heading-right-margin heading-left-margin ">
                                <button @click.prevent="add">Uložiť</button>
                            </div>
                        </div>
                    </div>
                    <div class="cards">
                        <div class="card bg-gray-100">
                            <div class="card-row">
                                <div>Názov: </div>
                                <div>
                                    <input type="text" v-model="this.tmpObject.currency_title"
                                        class="mt-1 shadow appearance-none border rounded w-full py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline"
                                        id="currency_title"/>
                                    <div v-if="$page.props.errors.currency_title" class="text-red-500">
                                        {{ $page.props.errors.currency_title }}
                                    </div>
                                </div>
                            </div>
                            <div class="card-row">
                                <div>Názov: </div>
                                <div>
                                    <input type="text" v-model="this.tmpObject.currency_symbol"
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
                                    <input type="text" v-model="this.tmpObject.shortcut"
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

    export default {
        name: 'AdminCurrencyStore',
        components: {
            AppLayout,
            AdminMenu,
        },
        data() {
            return {
                tmpObject: {
                    currency_title: '',
                    currency_symbol: '',
                    shortcut: '',
                },
            }
        },
        methods: {
            add(){
                Inertia.post(route("dashboard-store-currency"), this.tmpObject);
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
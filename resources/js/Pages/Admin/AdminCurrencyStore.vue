<template>
    <AppLayout>
        <div class="container page-container">
            <div class="mx-auto grid grid-cols-12 gap-4 p-1">
                <div class="col-span-12 sm:col-span-2">
                    <AdminMenu/>
                </div>
                <div class="col-span-12 sm:col-span-10">
                    <div class="page-heading">
                        <h1>Pridať záznam (Mena)</h1>
                    </div>
                    <div class="mb-3">
                        <button @click.prevent="add" class="buttons">Uložiť</button>
                    </div>
                    <div class="admin-cards">
                        <div class="admin-card bg-transparent">
                            <div class="admin-card-row">
                                <div>Názov: <span class="text-red-500">*</span></div>
                                <div>
                                    <input type="text" v-model="this.tmpObject.currency_title"
                                        class="mt-1 shadow appearance-none border rounded w-full py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline"
                                        id="currency_title"/>
                                    <div v-if="$page.props.errors.currency_title" class="text-red-500">
                                        {{ $page.props.errors.currency_title }}
                                    </div>
                                </div>
                            </div>
                            <div class="admin-card-row">
                                <div>Symbol: <span class="text-red-500">*</span></div>
                                <div>
                                    <input type="text" v-model="this.tmpObject.currency_symbol"
                                        class="mt-1 shadow appearance-none border rounded w-full py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline"
                                        id="currency_symbol"/>
                                    <div v-if="$page.props.errors.currency_symbol" class="text-red-500">
                                        {{ $page.props.errors.currency_symbol }}
                                    </div>
                                </div>
                            </div>
                            <div class="admin-card-row">
                                <div>Skratka: <span class="text-red-500">*</span></div>
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
    input:disabled {
        background-color: #e9ecef;
    }

    textarea:disabled {
        background-color: #e9ecef;
    }
</style>
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
                                <h1>Pridať záznam (Používateľ)</h1>
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
                                <div>Meno: <span class="text-red-500">*</span></div>
                                <div>
                                    <input type="text" v-model="this.tmpObject.name"
                                        class="mt-1 shadow appearance-none border rounded w-full py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline"
                                        id="name"/>
                                    <div v-if="$page.props.errors.name" class="text-red-500">
                                        {{ $page.props.errors.name }}
                                    </div>
                                </div>
                            </div>
                            <div class="card-row">
                                <div>Email: <span class="text-red-500">*</span></div>
                                <div>
                                    <input type="email" v-model="this.tmpObject.email"
                                        class="mt-1 shadow appearance-none border rounded w-full py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline"
                                        id="email"/>
                                    <div v-if="$page.props.errors.email" class="text-red-500">
                                        {{ $page.props.errors.email }}
                                    </div>
                                </div>
                            </div>
                            <div class="card-row">
                                <div>Rola: <span class="text-red-500">*</span></div>
                                <div>
                                    <select id="role_id" v-model="this.tmpObject.role_id" 
                                        class="mt-1 block form-select w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" required>
                                        <option v-for="(role, index) in this.roles" :key="index" :value="role.id">{{ role.role_title }}</option>
                                    </select>
                                    <div v-if="$page.props.errors.role_id" class="text-red-500">
                                        {{ $page.props.errors.role_id }}
                                    </div>
                                </div>
                            </div>
                            <div class="card-row">
                                <div>Divízia: <span class="text-red-500">*</span></div>
                                <div>
                                    <select id="division_id" v-model="this.tmpObject.division_id" 
                                        class="mt-1 block form-select w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" required>
                                        <option v-for="(division, index) in this.divisions" :key="index" :value="division.id">{{ division.division_title }}</option>
                                    </select>
                                    <div v-if="$page.props.errors.division_id" class="text-red-500">
                                        {{ $page.props.errors.division_id }}
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
        name: 'AdminUserStore',
        components: {
            AppLayout,
            AdminMenu,
        },
        props: {
            roles:{
                type: Object,
                default: () => { }
            }, 
            divisions:{
                type: Object,
                default: () => { }
            }, 
        },
        data() {
            return {
                tmpObject: {
                    name: '',
                    email: '',
                    role_id: '',
                    division_id: '',
                },
            }
        },
        methods: {
            add(){
                Inertia.post(route("dashboard-store-user"), this.tmpObject);
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
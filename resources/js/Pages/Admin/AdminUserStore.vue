<template>
    <AppLayout>
        <div class="relative w-full">
            <div class="absolute top-0 right-0 h-10 border-t border-b px-4 py-2 message" v-if="showAlert">
                <p class="text-sm">{{ $page.props.flash.success_object_save }}</p>
            </div>
        </div>
        <div class="container page-container">
            <div class="mx-auto grid grid-cols-12 gap-4 p-1">
                <div class="col-span-12 sm:col-span-2">
                    <div class="hidden md:block text-sm">
                        <AdminMenu/>
                    </div>
                </div>
                <div class="col-span-12 sm:col-span-10">
                    <div class="page-heading mb-0">
                        <div class="flex justify-between mb-3">
                            <div>
                                <h1>Pridať záznam (Používateľ)</h1>
                            </div>
                            <div class="md:hidden">
                                <div class="dropdown pl-3">
                                    <label tabindex="0" class="m-1">                                        
                                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                         </svg>
                                    </label>
                                    <ul tabindex="0" class="dropdown-content menu p-3 shadow bg-white rounded-box w-52 text-sm right-4">
                                        <AdminMenu/>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <button @click.prevent="add" class="buttons">Uložiť</button>
                    </div>
                    <div class="admin-cards">
                        <div class="admin-card bg-transparent">
                            <div class="admin-card-row">
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
                            <div class="admin-card-row">
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
                            <div class="admin-card-row">
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
                            <div class="admin-card-row">
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
        computed: {
            showAlert() {
                if (this.$page.props.flash.success_object_save !== null) {
                    setTimeout(() => {
                        this.$page.props.flash.success_object_save = null
                    }, 3000);
                    return true;
                }

                return false;
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
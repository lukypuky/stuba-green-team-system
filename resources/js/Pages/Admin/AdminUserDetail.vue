<template>
    <AppLayout>
        <div class="relative w-full">
            <div class="absolute top-0 right-0 h-10 border-t border-b px-4 py-2 message" v-if="showAlert">
                <p class="text-sm">{{ $page.props.flash.success_object_update_save }}</p>
            </div>
        </div>
        <div class="relative w-full">
            <div class="absolute top-0 right-0 h-10 border-t border-b px-4 py-2 message-uunsuccess" v-if="showUnsuccessfulAlert">
                <p class="text-sm">{{ $page.props.flash.unsuccess_user_save }}</p>
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
                                <h1>Upraviť záznam (Používateľ)</h1>
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
                        <div v-if="inputEnable">
                            <Icon name="update" width="20" @click="setInputs"/>
                        </div>
                    </div>
                    <div class="flex mb-3">
                        <div v-if="!inputEnable" class="mr-3">
                            <button @click.prevent="update" class="buttons">Uložiť</button>
                        </div>
                        <div v-if="!inputEnable">
                             <button @click.prevent="reset" class="buttons-gray">Zrušiť</button>
                        </div>
                    </div>
                    <div class="admin-cards">
                        <input type="hidden" name="id" v-model="this.userDetail[0].id" />
                        <div class="admin-card bg-transparent">
                            <div class="admin-card-row">
                                <div>Meno: <span class="text-red-500">*</span></div>
                                <div>
                                    <input type="text" v-model="this.userDetail[0].name" :disabled="inputEnable"
                                        class="mt-1 shadow appearance-none border rounded w-full py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline"
                                        id="name"/>
                                </div>
                                <div v-if="$page.props.errors.name" class="text-red-500">
                                    {{ $page.props.errors.name }}
                                </div>
                            </div>
                            <div class="admin-card-row">
                                <div>Email: <span class="text-red-500">*</span></div>
                                <div>
                                    <input type="email" v-model="this.userDetail[0].email" :disabled="inputEnable"
                                        class="mt-1 shadow appearance-none border rounded w-full py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline"
                                        id="email"/>
                                </div>
                                <div v-if="$page.props.errors.email" class="text-red-500">
                                    {{ $page.props.errors.email }}
                                </div>
                            </div>
                        </div>
                        <div class="admin-card bg-transparent">
                            <div class="admin-card-row">
                                <div>Rola: <span class="text-red-500">*</span></div>
                                <div>
                                    <select id="role_id" v-model="this.userDetail[0].role_id" :disabled="inputEnable"
                                        class="mt-1 block form-select w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" required>
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
                                    <select id="division_id" v-model="this.userDetail[0].division_id" :disabled="inputEnable"
                                        class="mt-1 block form-select w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" required>
                                        <option v-for="(division, index) in this.divisions" :key="index" :value="division.id">{{ division.division_title }}</option>
                                    </select>
                                    <div v-if="$page.props.errors.division_id" class="text-red-500">
                                        {{ $page.props.errors.division_id }}
                                    </div>
                                </div>
                            </div>
                            <div class="admin-card-row">
                                <div>Členstvo: </div>
                                <div>
                                    <select id="role_id" v-model="this.userDetail[0].active" :disabled="inputEnable"
                                        class="mt-1 block form-select w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" required>
                                        <option value="0">Nie</option>
                                        <option value="1">Áno</option>
                                    </select>
                                </div>
                            </div>
                            <div class="admin-card-row">
                                <div>Adminské práva: </div>
                                <div v-if="this.rolesIds.includes(userDetail[0].role_id)">
                                    Áno
                                </div>
                                <div v-else>
                                    Nie
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
        name: 'AdminUserDetail',
        components: {
            AppLayout,
            AdminMenu,
            Icon,
        },
        props: {
            userDetail:{
                type: Object,
                default: () => { }
            },
            divisions:{
                type: Object,
                default: () => { }
            },
            roles:{
                type: Object,
                default: () => { }
            },
        },
        data() {
            return {
                inputEnable: true,
                tmpUser: {
                    name: this.userDetail[0].name,
                    email: this.userDetail[0].email,
                    division_id: this.userDetail[0].division_id,
                    role_id: this.userDetail[0].role_id,
                    active: this.userDetail[0].active,
                },
                rolesIds: [
                    0,
                    1,
                    2,
                ],
            }
        },
        methods: {
            setInputs(){
                this.inputEnable = false;
            },
            reset(){
                this.inputEnable = true;

                this.userDetail[0].name = this.tmpUser.name;
                this.userDetail[0].email = this.tmpUser.email;
                this.userDetail[0].division_id = this.tmpUser.division_id;
                this.userDetail[0].role_id = this.tmpUser.role_id;
                this.userDetail[0].active = this.tmpUser.active;
            },
            update(){
                this.inputEnable = true;

                Inertia.post(route("dashboard-update-user"), this.userDetail[0]);
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
            showUnsuccessfulAlert() {
                if(this.$page.props.flash.unsuccess_user_save !== null) {
                    setTimeout(() => {
                        this.$page.props.flash.unsuccess_user_save = null
                    }, 3000);
                    return true;
                }

                return false;
            }
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
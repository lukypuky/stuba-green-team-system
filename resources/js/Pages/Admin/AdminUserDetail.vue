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
                                <h1>Upraviť záznam (Používateľ)</h1>
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
                        <input type="hidden" name="id" v-model="this.userDetail[0].id" />
                        <div class="card bg-gray-100">
                            <div class="card-row">
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
                            <div class="card-row">
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
                        <div class="card bg-gray-100">
                            <div class="card-row">
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
                            <div class="card-row">
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
                            <div class="card-row">
                                <div>Adminské práva: </div>
                                <div>
                                    <select id="role_id" v-model="this.userDetail[0].is_admin" :disabled="inputEnable"
                                        class="mt-1 block form-select w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" required>
                                        <option value="0">Nie</option>
                                        <option value="1">Áno</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card-row">
                                <div>Členstvo: </div>
                                <div>
                                    <select id="role_id" v-model="this.userDetail[0].active" :disabled="inputEnable"
                                        class="mt-1 block form-select w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" required>
                                        <option value="0">Nie</option>
                                        <option value="1">Áno</option>
                                    </select>
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
                    is_admin: this.userDetail[0].is_admin,
                    active: this.userDetail[0].active,
                },
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
                this.userDetail[0].is_admin = this.tmpUser.is_admin;
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
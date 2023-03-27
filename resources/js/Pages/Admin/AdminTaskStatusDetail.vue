<template>
    <AppLayout>
        <div class="relative w-full">
            <div class="absolute top-0 right-0 h-10 border-t border-b px-4 py-2 message" v-if="showAlert">
                <p class="text-sm">{{ $page.props.flash.success_object_update_save }}</p>
            </div>
        </div>
        <div class="relative w-full">
            <div class="absolute top-0 right-0 h-10 border-t border-b px-4 py-2 message-uunsuccess" v-if="showUnsuccessfulAlert">
                <p class="text-sm">{{ $page.props.flash.unsuccess_object_delete }}</p>
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
                                <h1>Upraviť záznam (Stav úlohy)</h1>
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
                        <input type="hidden" name="id" v-model="this.taskStatus[0].id" />
                        <div class="admin-card bg-transparent">
                            <div class="admin-card-row">
                                <div>Názov: <span class="text-red-500">*</span></div>
                                <div>
                                    <input type="text" v-model="this.taskStatus[0].task_status_title" :disabled="inputEnable"
                                        class="mt-1 shadow appearance-none border rounded w-full py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline"
                                        id="task_status_title"/>
                                    <div v-if="$page.props.errors.task_status_title" class="text-red-500">
                                        {{ $page.props.errors.task_status_title }}
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
        name: 'AdminTaskStatusDetail',
        components: {
            AppLayout,
            AdminMenu,
            Icon,
        },
        props: {
            taskStatus:{
                type: Object,
                default: () => { }
            },
        },
        data() {
            return {
                inputEnable: true,
                tmpObject: {
                    task_status_title: this.taskStatus[0].task_status_title,
                },
            }
        },
        methods: {
            setInputs(){
                this.inputEnable = false;
            },
            reset(){
                this.inputEnable = true;

                this.taskStatus[0].task_status_title = this.tmpObject.task_status_title;
            },
            update(){
                this.inputEnable = true;

                Inertia.post(route("dashboard-update-task-status"), this.taskStatus[0]);
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
                if(this.$page.props.flash.unsuccess_object_delete !== null) {
                    setTimeout(() => {
                        this.$page.props.flash.unsuccess_object_delete = null
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
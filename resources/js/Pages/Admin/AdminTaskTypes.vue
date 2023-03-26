<template>
    <AppLayout>
        <div class="relative w-full">
            <div class="absolute top-0 right-0 h-10 border-t border-b px-4 py-2 message" v-if="showAlert">
                <p class="text-sm">{{ $page.props.flash.success_object_save }}</p>
                <p class="text-sm">{{ $page.props.flash.success_object_delete}}</p>
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
                    <div class="page-heading">
                        <div class="flex justify-between">
                            <div>
                                <h1>Typy úloh</h1>
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
                        <div class="leading-10">
                            <Link :href="route('dashboard-get-task-type-store-page')" class="buttons">Pridať záznam</Link>
                        </div>
                    </div>
                    <div class="overflow-auto rounded-lg shadow hidden md:block">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b-2 border-gray-200">
                                <tr>
                                    <th class="p-3 text-sm font-semibold tracking-wide text-left">Akcie</th>
                                    <th class="p-3 text-sm font-semibold tracking-wide text-left">Názov</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <tr class="bg-white" v-for="(taskType, index) in this.taskTypes.data" :key="index">
                                    <td class="p-3 text-sm text-gray-700 whitespace-nowrap">
                                        <div class="flex">
                                            <div class="pr-2">
                                                <Icon name="update" width="20" @click.prevent="getDetail(taskType.id)"/>
                                            </div>
                                            <div class="pl-2">
                                                <Icon name="delete" width="20" @click.prevent="deleteModal(taskType.id)"/>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-3 text-sm text-gray-700 whitespace-nowrap">
                                        {{ taskType.task_type_title }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="grid grid-cols-1 gap-4 md:hidden mb-2 text-sm" v-for="(taskType, index) in this.taskTypes.data" :key="index">
                        <div class="bg-white space-y-4 p-4 rounded-lg shadow">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    Akcie
                                </div>
                                <div>
                                    <div class="flex">
                                        <div class="pr-2">
                                            <Icon name="update" width="20" @click.prevent="getDetail(taskType.id)"/>
                                        </div>
                                        <div class="pl-2">
                                            <Icon name="delete" width="20" @click.prevent="deleteModal(taskType.id)"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    Názov
                                </div>
                                <div class="break-words">
                                    {{ taskType.task_type_title }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <Pagination :links="this.taskTypes.links"/>
                    </div>
                </div>
            </div>
        </div>

        <DeleteModal v-if="this.showDeleteModal" @closeDeleteModal="closeDeleteModal" @deleteObject="deleteObject"/>
    </AppLayout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import { Inertia } from '@inertiajs/inertia';
    import AdminMenu from '@/Components/AdminMenu.vue';
    import Icon from '@/Components/Icon.vue';
    import Pagination from '@/Components/Pagination.vue';
    import DeleteModal from '@/Modals/DeleteModal.vue';
    import { Link } from '@inertiajs/inertia-vue3';

    export default {
        name: 'AdminTaskTypes',
        components: {
            AppLayout,
            AdminMenu,
            Icon,
            Pagination,
            DeleteModal,
            Link,
        },
        props: {
            taskTypes:{
                type: Object,
                default: () => { }
            },
        },
        data(){
            return {
                showDeleteModal: false,
                deletedObjectId: {id: ''},
            }
        },
        methods: {            
            closeDeleteModal() {
                this.showDeleteModal = false;
            },
            deleteModal(id){
                this.showDeleteModal = true;
                this.deletedObjectId.id = id;
            },
            deleteObject(){
                Inertia.post(route('dashboard-delete-task-type'), this.deletedObjectId);
                this.closeDeleteModal();
            },
            getDetail(param){
                var request = {id: param};
                Inertia.get(route("dashboard-task-type-detail", request));
            }
        },
        computed: {
            showAlert() {
                if (this.$page.props.flash.success_object_save !== null) {
                    setTimeout(() => {
                        this.$page.props.flash.success_object_save = null
                    }, 3000);
                    return true;
                }
                else if(this.$page.props.flash.success_object_delete !== null) {
                    setTimeout(() => {
                        this.$page.props.flash.success_object_delete = null
                    }, 3000);
                    return true;
                }

                return false;
            },
        },
    }
</script>

<style scoped>

</style>
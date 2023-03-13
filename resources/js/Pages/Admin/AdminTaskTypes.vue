<template>
    <AppLayout>
        <div class="container page-container">
            <div class="mx-auto grid grid-cols-12 gap-4 p-1">
                <div class="col-span-12 sm:col-span-2">
                    <AdminMenu/>
                </div>
                <div class="col-span-12 sm:col-span-10">
                    <div class="bg-green-100 border-t border-b border-green-500 text-green-700 px-4 py-3" role="alert" v-if="showAlert">
                        <p class="text-sm">{{ $page.props.flash.success_object_save }}</p>
                        <p class="text-sm">{{ $page.props.flash.success_object_delete}}</p>
                    </div>
                    <div class="page-heading">
                        <h1>Typy úloh</h1>
                    </div>
                    <div class="m-2">
                        <Link :href="route('dashboard-get-task-type-store-page')">Pridať záznam</Link>
                    </div>
                    <div>
                        <table class="min-w-full border-collapse block md:table">
                            <thead class="block md:table-header-group">
                                <tr class="border border-grey-500 md:border-none block md:table-row absolute -top-full md:top-auto -left-full md:left-auto  md:relative ">
                                    <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">Akcie</th>
                                    <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">Názov</th>
                                </tr>
                            </thead>
                            <tbody class="block md:table-row-group">
                                <tr class="bg-gray-300 border border-grey-500 md:border-none block md:table-row"
                                    v-for="(taskType, index) in this.taskTypes.data" :key="index">
                                    <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell"><span class="inline-block w-1/3 md:hidden font-bold">Akcie</span>
                                        <div class="flex">
                                            <div class="pr-2">
                                                <Icon name="update" width="20" @click.prevent="getDetail(taskType.id)"/>
                                            </div>
                                            <div class="pl-2">
                                                <Icon name="delete" width="20" @click.prevent="deleteModal(taskType.id)"/>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell"><span class="inline-block w-1/3 md:hidden font-bold">Názov</span>
                                        {{ taskType.task_type_title }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
<template>
    <AppLayout>
        <div class="container page-container">
            <div class="mx-auto grid grid-cols-12 gap-4 p-1">
                <div class="col-span-12 sm:col-span-2">
                    <AdminMenu/>
                </div>
                <div class="col-span-12 sm:col-span-10">
                    <!-- <div class="bg-green-100 border-t border-b border-green-500 text-green-700 px-4 py-3" role="alert" v-if="showAlert">
                        <p class="text-sm">{{ $page.props.flash.success_object_save }}</p>
                        <p class="text-sm">{{ $page.props.flash.success_object_update_save }}</p>
                        <p class="text-sm">{{ $page.props.flash.success_object_delete }}</p>
                    </div> -->
                    <div class="page-heading">
                        <h1>Používatelia</h1>
                    </div>
                    <div>
                        <table class="min-w-full border-collapse block md:table">
                            <thead class="block md:table-header-group">
                                <tr class="border border-grey-500 md:border-none block md:table-row absolute -top-full md:top-auto -left-full md:left-auto  md:relative ">
                                    <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">Akcie</th>
                                    <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">Meno a priezvisko</th>
                                    <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">Email</th>
                                    <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">Členstvo</th>
                                    <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">Adminské práva</th>
                                    <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">Rola</th>
                                    <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">Divízia</th>
                                </tr>
                            </thead>
                            <tbody class="block md:table-row-group">
                                <tr class="bg-gray-300 border border-grey-500 md:border-none block md:table-row"
                                    v-for="(user, index) in this.users.data" :key="index">
                                    <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell"><span class="inline-block w-1/3 md:hidden font-bold">Akcie</span>
                                        <div class="flex">
                                            <div class="pr-2">
                                                <Icon name="update" width="20" @click.prevent="getDetail(user.id)"/>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell"><span class="inline-block w-1/3 md:hidden font-bold">Meno a priezvisko</span>
                                        {{ user.name }}
                                    </td>
                                    <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell"><span class="inline-block w-1/3 md:hidden font-bold">Email</span>
                                        {{ user.email }}
                                    </td>
                                    <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell"><span class="inline-block w-1/3 md:hidden font-bold">Členstvo</span>
                                        <ActiveIcon :type="user.active"/>
                                    </td>
                                    <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell"><span class="inline-block w-1/3 md:hidden font-bold">Adminské práva</span>
                                        <div v-if="user.is_admin == 1">
                                            Áno
                                        </div>
                                        <div v-else>
                                            Nie
                                        </div>
                                    </td>
                                    <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell"><span class="inline-block w-1/3 md:hidden font-bold">Rola</span>
                                        {{ user.role_title }}
                                    </td>
                                    <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell"><span class="inline-block w-1/3 md:hidden font-bold">Divízia</span>
                                        {{ user.division_title }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <Pagination :links="this.users.links"/>
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
    import ActiveIcon from '@/Components/AttendanceIcons.vue';
    import Pagination from '@/Components/Pagination.vue';

    export default {
        name: 'AdminUsers',
        components: {
            AppLayout,
            AdminMenu,
            Icon,
            ActiveIcon,
            Pagination,
        },
        props: {
            users:{
                type: Object,
                default: () => { }
            },
        },
        methods: {
            getDetail(param){
                var request = {id: param};
                Inertia.get(route("dashboard-get-user-detail", request));
            }
        },
    }
</script>

<style scoped>

</style>
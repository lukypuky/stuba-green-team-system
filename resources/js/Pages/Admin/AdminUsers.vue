<template>
    <AppLayout>
        <div class="relative w-full">
            <div class="absolute top-0 right-0 h-10 border-t border-b px-4 py-2 message" v-if="showAlert">
                <p class="text-sm">{{ $page.props.flash.success_object_save }}</p>
                <p class="text-sm">{{ $page.props.flash.success_object_delete }}</p>
            </div>
        </div>
        <div class="container page-container">
            <div class="mx-auto grid grid-cols-12 gap-4 p-1">
                <div class="col-span-12 sm:col-span-2">
                    <AdminMenu/>
                </div>
                <div class="col-span-12 sm:col-span-10">
                    <div class="page-heading">
                        <h1>Používatelia</h1>
                    </div>
                    <div class="mb-3">
                        <div class="leading-10">
                            <Link :href="route('dashboard-store-user-page')" class="buttons">Pridať záznam</Link>
                        </div>
                    </div>
                    <div class="overflow-auto rounded-lg shadow hidden md:block">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b-2 border-gray-200">
                                <tr>
                                    <th class="p-3 text-sm font-semibold tracking-wide text-left">Akcie</th>
                                    <th class="p-3 text-sm font-semibold tracking-wide text-left">Meno a priezvisko</th>
                                    <th class="p-3 text-sm font-semibold tracking-wide text-left">Email</th>
                                    <th class="p-3 text-sm font-semibold tracking-wide text-left">Členstvo</th>
                                    <th class="p-3 text-sm font-semibold tracking-wide text-left">Adminské práva</th>
                                    <th class="p-3 text-sm font-semibold tracking-wide text-left">Rola</th>
                                    <th class="p-3 text-sm font-semibold tracking-wide text-left">Divízia</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <tr class="bg-white" v-for="(user, index) in this.users.data" :key="index">
                                    <td class="p-3 text-sm text-gray-700 whitespace-nowrap">
                                        <Icon name="update" width="20" @click.prevent="getDetail(user.id)"/>
                                    </td>
                                    <td class="p-3 text-sm text-gray-700 whitespace-nowrap">
                                        {{ user.name }}
                                    </td>
                                    <td class="p-3 text-sm text-gray-700 whitespace-nowrap">
                                        {{ user.email }}
                                    </td>
                                    <td class="p-3 text-sm text-gray-700 whitespace-nowrap">
                                        <ActiveIcon :type="user.active"/>
                                    </td>
                                    <td class="p-3 text-sm text-gray-700 whitespace-nowrap">
                                        <div v-if="user.is_admin == 1">
                                            Áno
                                        </div>
                                        <div v-else>
                                            Nie
                                        </div>
                                    </td>
                                    <td class="p-3 text-sm text-gray-700 whitespace-nowrap">
                                        {{ user.role_title }}
                                    </td>
                                    <td class="p-3 text-sm text-gray-700 whitespace-nowrap">
                                        {{ user.division_title }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="grid grid-cols-1 gap-4 md:hidden mb-2 text-sm" v-for="(user, index) in this.users.data" :key="index">
                        <div class="bg-white space-y-4 p-4 rounded-lg shadow">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    Akcie
                                </div>
                                <div>
                                    <Icon name="update" width="20" @click.prevent="getDetail(user.id)"/>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    Meno a priezvisko
                                </div>
                                <div class="break-words">
                                    {{ user.name }}
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    Email
                                </div>
                                <div class="break-words">
                                    {{ user.email }}
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                 <div>
                                    Členstvo
                                </div>
                                <div>
                                    <ActiveIcon :type="user.active"/>
                                 </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    Adminské práva
                                 </div>
                                <div>
                                    <div v-if="user.is_admin == 1">
                                        Áno
                                    </div>
                                    <div v-else>
                                        Nie
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    Rola
                                </div>
                                 <div class="break-words">
                                    {{ user.role_title }}
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    Divízia
                                </div>
                                <div class="break-words">
                                    {{ user.division_title }}
                                </div>
                            </div>
                        </div>
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
    import { Link } from '@inertiajs/inertia-vue3';

    export default {
        name: 'AdminUsers',
        components: {
            AppLayout,
            AdminMenu,
            Icon,
            ActiveIcon,
            Pagination,
            Link,
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
<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link } from '@inertiajs/inertia-vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';

const showingNavigationDropdown = ref(false);

const logout = () => {
    Inertia.post(route('logout'));
};
</script>

<template>
    <div id="app">
        <div class="min-h-screen bg-gray-200">
            <nav class="navbar-color border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <a :href="route('dashboard')" class="w-32">
                                    <img src="https://sgteam.eu/wp-content/uploads/logo.png" alt="STUBA Green Team Logo">
                                </a>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 md:flex">
                                <!-- <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
                                    Info panel
                                </NavLink> -->
                                <NavLink :href="route('dashboard')"
                                    :class="this.reportsTasksPages.includes(route().current()) ? 'active' : ''">
                                    Výkazy/úlohy
                                </NavLink>
                                <NavLink :href="route('dashboard-my-orders')"
                                    :class="this.orderPages.includes(route().current()) ? 'active' : ''">
                                    Nákup
                                </NavLink>
                                <NavLink :href="route('dashboard-get-users')"
                                    :class="this.adminPages.includes(route().current()) ? 'active' : ''" v-if="this.rolesIds.includes($page.props.user.role_id)">
                                    Admin panel
                                </NavLink>
                            </div>
                        </div>

                        <div class="hidden md:flex md:items-center md:ml-6">
                            <!-- Settings Dropdown -->
                            <div class="ml-3 relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <button v-if="$page.props.jetstream.managesProfilePhotos"
                                            class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                            <img class="h-8 w-8 rounded-full object-cover"
                                                :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name">
                                        </button>

                                        <span v-else class="inline-flex rounded-md">
                                            <button type="button"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                                {{ $page.props.user.name }}

                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <!-- Account Management -->
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            Správa účtu
                                        </div>

                                        <DropdownLink :href="route('profile.show')">
                                            Profil
                                        </DropdownLink>

                                        <div class="border-t border-gray-100" />

                                        <!-- Authentication -->
                                        <form @submit.prevent="logout">
                                            <DropdownLink as="button">
                                                Odhlásiť sa
                                            </DropdownLink>
                                        </form>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center md:hidden">
                            <button
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition"
                                @click="showingNavigationDropdown = !showingNavigationDropdown">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path
                                        :class="{ 'hidden': showingNavigationDropdown, 'inline-flex': !showingNavigationDropdown }"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16" />
                                    <path
                                        :class="{ 'hidden': !showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{ 'block': showingNavigationDropdown, 'hidden': !showingNavigationDropdown }"
                    class="md:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <!-- <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                            Info panel
                        </ResponsiveNavLink> -->
                        <ResponsiveNavLink :href="route('dashboard')"
                            :class="this.reportsTasksPages.includes(route().current()) ? 'activeResponsive' : ''">
                            Výkazy/úlohy
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('dashboard-my-orders')"
                            :class="this.orderPages.includes(route().current()) ? 'activeResponsive' : ''">
                            Nákup
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('dashboard-get-users')"
                            :class="this.adminPages.includes(route().current()) ? 'activeResponsive' : ''">
                            Admin panel
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="flex items-center pl-4">
                            <div v-if="$page.props.jetstream.managesProfilePhotos" class="shrink-0 mr-3">
                                <img class="h-10 w-10 rounded-full object-cover"
                                    :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name">
                            </div>

                            <div>
                                <div class="font-medium text-base name">
                                    {{ $page.props.user.name }}
                                </div>
                                <div class="font-medium text-sm name">
                                    {{ $page.props.user.email }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.show')" 
                                :class="this.profile.includes(route().current()) ? 'activeResponsive' : ''">
                                Profil
                            </ResponsiveNavLink>

                            <!-- Authentication -->
                            <form method="POST" @submit.prevent="logout">
                                <ResponsiveNavLink as="button">
                                    Odhlásiť sa
                                </ResponsiveNavLink>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>

            <main>
                <slot />

                <ChangePasswordAlertModal v-if="this.showChangePasswordAlertModal" @closeChangePasswordAlertModal="closeChangePasswordAlertModal"/>
            </main>
        </div>
    </div>
</template>

<script>
    import ChangePasswordAlertModal from '@/Modals/ChangePasswordAlertModal.vue';

    export default {
        components: {
            ChangePasswordAlertModal,
        },
        methods: {
            closeChangePasswordAlertModal(){
                this.showChangePasswordAlertModal = false;
            }
        },
        data(){
            return{
                showChangePasswordAlertModal: false,
                reportsTasksPages: [
                    'dashboard',
                    'dashboard-tasks',
                    'dashboard-task-detail',
                    'dashboard-all-tasks',
                    'dashboard-attendance',
                    'dashboard-get-all-reports'
                ],
                orderPages: [
                    'dashboard-my-orders',
                    'dashboard-all-orders',
                    'dashboard-van-reservations',
                ],
                adminPages: [
                    'dashboard-store-user-page',
                    'dashboard-get-user-detail',
                    'dashboard-get-users',
                    'dashboard-get-task-type-store-page',
                    'dashboard-task-type-detail',
                    'dashboard-get-task-types',
                    'dashboard-get-task-status-store-page',
                    'dashboard-task-status-detail',
                    'dashboard-get-task-statuses',
                    'dashboard-get-task-priority-store-page',
                    'dashboard-task-priority-detail',
                    'dashboard-get-task-priorities',
                    'dashboard-get-order-status-store-page',
                    'dashboard-order-status-detail',
                    'dashboard-get-order-statuses',
                    'dashboard-get-order-priority-store-page',
                    'dashboard-order-priority-detail',
                    'dashboard-get-order-priorities',
                    'dashboard-get-meeting-type-store-page',
                    'dashboard-meeting-type-detail',
                    'dashboard-get-meeting-types',
                    'dashboard-get-formula-parts',
                    'dashboard-formula-part-detail',
                    'dashboard-get-formula-part-store-page',
                    'dashboard-get-division-store-page',
                    'dashboard-division-detail',
                    'dashboard-get-divisions',
                    'dashboard-get-currency-store-page',
                    'dashboard-currency-detail',
                    'dashboard-get-currencies',
                    'dashboard-get-area-store-page',
                    'dashboard-area-detail',
                    'dashboard-get-areas',
                ],
                profile: [
                    'profile.show',
                ],
                rolesIds: [
                    0,
                    1,
                    2,
                ],
            }
        },
        beforeMount(){
            if(this.$page.props.user.first_login_pass_changed == false){
                this.showChangePasswordAlertModal = true;
            }
        }
    }
</script>

<style scoped>
    .active {
        border-bottom-width: 2px;
        border-color: none;
        color: var(--sgt-color);
    }

    .activeResponsive {
        --tw-bg-opacity: 1;
        background-color:  var(--sgt-color-opacity);
        --tw-border-opacity: 1;
        border-color: var(--sgt-color);
        border-left-width: 4px;
        color: #454545;
    }

    .name {
        color: var(--sgt-color);
    }
</style>

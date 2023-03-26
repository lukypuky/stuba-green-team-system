<template>
    <div>
        <div>
            <Link :href="route('dashboard-get-users')" :class="this.users.includes(route().current()) ? 'active' : ''" class="menu-item">Používatelia</Link>
        </div>
        <div>
            <Link :href="route('dashboard-get-task-types')" :class="this.taskTypes.includes(route().current()) ? 'active' : ''" class="menu-item">Typy úloh</Link>
        </div>
        <div>
            <Link :href="route('dashboard-get-task-statuses')" :class="this.taskStatuses.includes(route().current()) ? 'active' : ''" class="menu-item">Stavy úloh</Link>
        </div>
        <div>
            <Link :href="route('dashboard-get-task-priorities')" :class="this.taskPriorities.includes(route().current()) ? 'active' : ''" class="menu-item">Priority úloh</Link>
        </div>
        <div>
            <Link :href="route('dashboard-get-order-statuses')" :class="this.orderStatuses.includes(route().current()) ? 'active' : ''" class="menu-item">Stavy objednávok</Link>
        </div>
        <div>
            <Link :href="route('dashboard-get-order-priorities')" :class="this.orderPriorities.includes(route().current()) ? 'active' : ''" class="menu-item">Priority objednávok</Link>
        </div>
        <div>
            <Link :href="route('dashboard-get-meeting-types')" :class="this.meetingTypes.includes(route().current()) ? 'active' : ''" class="menu-item">Typy stretnutí</Link>
        </div>
        <div>
            <Link :href="route('dashboard-get-formula-parts')" :class="this.formulaParts.includes(route().current()) ? 'active' : ''" class="menu-item">Časti formuly</Link>
        </div>
        <div>
            <Link :href="route('dashboard-get-divisions')" :class="this.divisions.includes(route().current()) ? 'active' : ''" class="menu-item">Divízie</Link>
        </div>
        <div>
            <Link :href="route('dashboard-get-currencies')" :class="this.currencies.includes(route().current()) ? 'active' : ''" class="menu-item">Meny</Link>
        </div>
        <div>
            <Link :href="route('dashboard-get-areas')" :class="this.areas.includes(route().current()) ? 'active' : ''" class="menu-item">Oblasti</Link>
        </div>
    </div>
</template>

<script>
    import { Link } from '@inertiajs/inertia-vue3';

    export default {
        name: 'AdminMenu',
        components: {
            Link,
        },
        data(){
            return{
                users: [
                    'dashboard-get-users',
                    'dashboard-get-user-detail',
                    'dashboard-store-user-page',
                ],
                taskTypes: [
                    'dashboard-get-task-types',
                    'dashboard-task-type-detail',
                    'dashboard-get-task-type-store-page',
                ],
                taskStatuses: [
                    'dashboard-get-task-statuses',
                    'dashboard-task-status-detail',
                    'dashboard-get-task-status-store-page',
                ],
                taskPriorities: [
                    'dashboard-get-task-priorities',
                    'dashboard-task-priority-detail',
                    'dashboard-get-task-priority-store-page',
                ],
                orderPriorities: [
                    'dashboard-get-order-priorities',
                    'dashboard-order-priority-detail',
                    'dashboard-get-order-priority-store-page',
                ],
                orderStatuses: [
                    'dashboard-get-order-statuses',
                    'dashboard-order-status-detail',
                    'dashboard-get-order-status-store-page',
                ],
                meetingTypes: [
                    'dashboard-get-meeting-types',
                    'dashboard-meeting-type-detail',
                    'dashboard-get-meeting-type-store-page',
                ],
                formulaParts: [
                    'dashboard-get-formula-parts',
                    'dashboard-formula-part-detail',
                    'dashboard-get-formula-part-store-page',
                ],
                divisions: [
                    'dashboard-get-divisions',
                    'dashboard-division-detail',
                    'dashboard-get-division-store-page',
                ],
                currencies: [
                    'dashboard-get-currencies',
                    'dashboard-currency-detail',
                    'dashboard-get-currency-store-page',
                ],
                areas: [
                    'dashboard-get-areas',
                    'dashboard-area-detail',
                    'dashboard-get-area-store-page',
                ],
            }
        },
    }
</script>

<style scoped>
    .active {
        color: var(--sgt-color);
        font-weight: bold;
    }

    .menu-item:hover {
        color: var(--sgt-color);
    }
</style>
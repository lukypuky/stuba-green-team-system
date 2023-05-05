<template>
    <div>
        <div>
            <Link :href="route('dashboard')" :class="route().current('dashboard') ? 'active' : ''" class="menu-item">Výkazy práce</Link>
        </div>
        <div>
            <Link :href="route('dashboard-tasks')" :class="route().current('dashboard-tasks') ? 'active' : ''" class="menu-item">Prehľad mojich úloh</Link>
        </div>
        <div>
            <Link :href="route('dashboard-all-tasks')" :class="route().current('dashboard-all-tasks') ? 'active' : ''" class="menu-item">Prehľad všetkých úloh</Link>
        </div>
        <div v-if="this.rolesIds.includes($page.props.user.role_id)">
            <Link :href="route('dashboard-attendance')" :class="route().current('dashboard-attendance') ? 'active' : ''" class="menu-item">Dochádzka členov</Link> <!--ADMIN-->
        </div>
        <div v-if="this.rolesIds.includes($page.props.user.role_id)">
            <Link :href="route('dashboard-get-all-reports')" :class="route().current('dashboard-get-all-reports') ? 'active' : ''" class="menu-item">Prehľad výkazov</Link> <!--ADMIN-->
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';

export default {
    name: 'ReportMenu',
    components: {
        Link,
    },
    data() {
        return {
            rolesIds: [
                0,
                1,
                2,
            ]
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
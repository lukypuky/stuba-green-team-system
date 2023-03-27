<template>
    <div>
        <div>
            <Link :href="route('dashboard')" :class="route().current('dashboard') ? 'active' : ''" class="menu-item">Výkaz práce</Link>
        </div>
        <div>
            <Link :href="route('dashboard-tasks')" :class="route().current('dashboard-tasks') ? 'active' : ''" class="menu-item">Prehľad mojich úloh</Link>
        </div>
        <div>
            <Link :href="route('dashboard-all-tasks')" :class="route().current('dashboard-all-tasks') ? 'active' : ''" class="menu-item">Prehľad všetkých úloh</Link> <!--ADMIN-->
        </div>
        <div v-if="this.roles.includes($page.props.user.role_id) || $page.props.user.is_admin == 1">
            <Link :href="route('dashboard-attendance')" :class="route().current('dashboard-attendance') ? 'active' : ''" class="menu-item">Dochádzka členov</Link> <!--ADMIN-->
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
            roles: [
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
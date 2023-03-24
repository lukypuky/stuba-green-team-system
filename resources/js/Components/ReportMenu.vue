<template>
    <div>
        <Link :href="route('dashboard')" :class="route().current('dashboard') ? 'active' : ''" class="menu-item">Výkaz práce</Link>
    </div>
    <div>
        <Link :href="route('dashboard-tasks')" :class="route().current('dashboard-tasks') ? 'active' : ''" class="menu-item">Prehľad mojich úloh</Link>
    </div>
    <div>
        <Link :href="route('dashboard-all-tasks')" :class="route().current('dashboard-all-tasks') ? 'active' : ''" class="menu-item">Prehľad všetkých úloh</Link> <!--ADMIN-->
    </div>
    <div>
        <Link :href="route('dashboard-attendance')" :class="route().current('dashboard-attendance') ? 'active' : ''" class="menu-item">Dochádzka členov</Link> <!--ADMIN-->
    </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';

export default {
    name: 'ReportMenu',
    components: {
        Link,
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
<template>
    <div>
        <div>
            <Link :href="route('dashboard-my-orders')" :class="route().current('dashboard-my-orders') ? 'active' : ''" class="menu-item">Moje objednávky</Link>
        </div>
        <div>
            <Link :href="route('dashboard-all-orders')" :class="route().current('dashboard-all-orders') ? 'active' : ''" class="menu-item">Všetky objednávky</Link>
        </div>
    </div>
</template>

<script>
    import { Link } from '@inertiajs/inertia-vue3';

    export default {
        name: 'OrderMenu',
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
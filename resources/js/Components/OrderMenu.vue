<template>
    <div>
        <div>
            <Link :href="route('dashboard-my-orders')" :class="route().current('dashboard-my-orders') ? 'active' : ''" class="menu-item">Moje objednávky</Link>
        </div>
        <div v-if="this.roles.includes($page.props.user.role_id) || $page.props.user.is_admin == 1">
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
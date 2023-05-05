<template>
    <div>
        <div>
            <Link :href="route('dashboard-my-orders')" :class="route().current('dashboard-my-orders') ? 'active' : ''" class="menu-item">Moje objednávky</Link>
        </div>
        <div v-if="this.rolesIds.includes($page.props.user.role_id)">
            <Link :href="route('dashboard-all-orders')" :class="route().current('dashboard-all-orders') ? 'active' : ''" class="menu-item">Všetky objednávky</Link>
        </div>
        <div>
            <Link :href="route('dashboard-van-reservations')" :class="route().current('dashboard-van-reservations') ? 'active' : ''" class="menu-item">Rezervácie dodávky</Link>
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
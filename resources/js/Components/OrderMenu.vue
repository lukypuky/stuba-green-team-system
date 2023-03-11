<template>
    <div>
        <Link :href="route('dashboard-my-orders')">Moje objednávky</Link>
    </div>
    <div>
        <Link :href="route('dashboard-all-orders')">Všetky objednávky</Link>
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

</style>
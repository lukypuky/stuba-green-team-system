<template>
    <div>
        <Link :href="route('dashboard-report')">Moje objednávky</Link>
    </div>
    <div>
        <Link :href="route('dashboard-tasks')">Objednávky divízie</Link>
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
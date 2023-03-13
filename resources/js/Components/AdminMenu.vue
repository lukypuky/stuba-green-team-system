<template>
    <div>
        <Link :href="route('dashboard-get-users')">Používatelia</Link>
    </div>
    <div>
        <Link :href="route('dashboard-get-task-types')">Typy úloh</Link>
    </div>
    <div>
        <Link :href="route('dashboard-get-task-statuses')">Stavy úloh</Link>
    </div>
    <div>
        <Link :href="route('dashboard-get-task-priorities')">Priority úloh</Link>
    </div>
    <div>
        <Link :href="route('dashboard-get-order-statuses')">Stavy objednávok</Link>
    </div>
    <div>
        <Link :href="route('dashboard-get-order-priorities')">Priority objednávok</Link>
    </div>
    <div>
        <Link :href="route('dashboard-get-meeting-types')">Typy stretnutí</Link>
    </div>
    <div>
        <Link :href="route('dashboard-get-formula-parts')">Časti formuly</Link>
    </div>
    <div>
        <Link :href="route('dashboard-get-divisions')">Divízie</Link>
    </div>
    <div>
        <Link :href="route('dashboard-get-areas')">Oblasti</Link>
    </div>

</template>

<script>
    import { Link } from '@inertiajs/inertia-vue3';

    export default {
        name: 'AdminMenu',
        components: {
            Link,
        },
    }
</script>

<style scoped>

</style>
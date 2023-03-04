<template>
    <div>
        <Link :href="route('dashboard-report')">Výkaz práce</Link>
    </div>
    <div>
        <Link :href="route('dashboard-tasks')">Prehľad mojich úloh</Link>
    </div>
    <div>
        <Link :href="route('dashboard-all-tasks')">Prehľad všetkých úloh</Link> <!--ADMIN-->
    </div>
    <div>
        <Link :href="route('dashboard-attendance')">Dochádzka členov</Link> <!--ADMIN-->
    </div>
    
    <!-- <ReportButton text="Prehľad výkazov" /> -->
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';

export default {
    name: 'ReportMenu',
    components: {
        Link,
    }
}
</script>

<style scoped>

</style>
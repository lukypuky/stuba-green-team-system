<template>
    <AppLayout>
        <div v-for="user in users" :key="user" class="page-container">
            {{ user.name }}
        </div>
    </AppLayout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout.vue';

    export default {
        name: 'DashboardPurchase',
        components: { AppLayout },

        props: {
            users: Array
        }
    }
</script>


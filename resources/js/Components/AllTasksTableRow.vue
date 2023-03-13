<template>
    <tr class="bg-gray-300 border border-grey-500 md:border-none block md:table-row"
        v-for="(task, index) in this.tasks.data" :key="index">
        <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell"><span class="inline-block w-1/3 md:hidden font-bold">Názov</span>{{ task.task_title }}</td>
        <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell"><span class="inline-block w-1/3 md:hidden font-bold">Priradené</span>{{ task.name }}</td>
        <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell"><span class="inline-block w-1/3 md:hidden font-bold">Status</span>{{ task.task_status_title }}</td>
        <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell"><span class="inline-block w-1/3 md:hidden font-bold">Dátum vytvorenia</span>{{ task.created_at }}</td>
        <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
            <span class="inline-block w-1/3 md:hidden font-bold">Akcie</span>
            <Link :href="route('dashboard-task-detail', task.id)">Detail</Link>
        </td>
    </tr>	
</template>

<script>
    import { Link } from '@inertiajs/inertia-vue3';
    // import moment from 'moment';

    export default {
        name: 'AllTasksTableRow',
        components: {
            Link,
        },
        props: {
            tasks:{
                type: Object,
                default: () => { }
            }, 
            searchedTasks:{
                type: Object,
                default: () => { }
            }, 
        },
        // mounted(){
        //     Object.keys(this.tasks).forEach(key => {
        //         this.tasks[key].created_at = moment(this.tasks[key].created_at).format('DD.MM.YYYY HH:MM:SS');
        //     });
        // },
    }
</script>

<style  scoped>

</style>
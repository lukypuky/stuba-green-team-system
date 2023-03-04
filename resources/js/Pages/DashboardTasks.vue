<template>
    <AppLayout>
        <div class="container page-container">
            <div class="bg-green-100 border-t border-b border-green-500 text-green-700 px-4 py-3" role="alert"
                v-if="showAlert">
                <p class="text-sm">{{ $page.props.flash.success_task_save }}</p>
            </div>
            <div class="row">
                <div class="col-2 report-left-section">
                    <ReportMenu/>
                </div>
                <div class="col-10 report-right-section">
                    <TaskOverview :tasks="tasks.original" :taskTypes="taskTypes.original" :taskPriorities="taskPriorities.original" :divisions="divisions.original" 
                    :areas="areas.original"/>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import TaskOverview from '@/Components/TaskOverview.vue';
import ReportMenu from '@/Components/ReportMenu.vue';


    export default {
        name: 'DashboardTasks',
        components: {
            AppLayout,
            TaskOverview,
            ReportMenu,
        },
        props: {
            tasks:{
                type: Object,
                default: () => { }
            }, 
            taskTypes:{
                type: Object,
                default: () => { }
            }, 
            taskPriorities:{
                type: Object,
                default: () => { }
            }, 
            divisions:{
                type: Object,
                default: () => { }
            }, 
            areas:{
                type: Object,
                default: () => { }
            }, 
        },
        computed: {
            showAlert() {
                if (this.$page.props.flash.success_task_save !== null) {
                    setTimeout(() => {
                        this.$page.props.flash.success_task_save = null
                    }, 3000);
                    return true;
                }

                return false;
            },
        },
    }
</script>

<style scoped>

</style>
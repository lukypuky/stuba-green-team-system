<template>
    <AppLayout>
        <div class="relative w-full">
            <div class="absolute top-0 right-0 h-10 border-t border-b px-4 py-2 message" v-if="showAlert">
                <p class="text-sm">{{ $page.props.flash.success_object_save }}</p>
                <p class="text-sm">{{ $page.props.flash.success_object_delete }}</p>
            </div>
        </div>
        <div class="container page-container">
            <div class="mx-auto grid grid-cols-12 gap-4 p-1">
                <div class="col-span-12 sm:col-span-2">
                    <ReportMenu/>
                </div>
                <div class="col-span-12 sm:col-span-10">
                    <TaskOverview :tasks="tasks" :taskTypes="taskTypes" :taskPriorities="taskPriorities" :divisions="divisions" 
                    :areas="areas"/>
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
                if (this.$page.props.flash.success_object_save !== null) {
                    setTimeout(() => {
                        this.$page.props.flash.success_object_save = null
                    }, 3000);
                    return true;
                }
                else if(this.$page.props.flash.success_object_delete !== null) {
                    setTimeout(() => {
                        this.$page.props.flash.success_object_delete = null
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
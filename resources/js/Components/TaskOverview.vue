<template>
    <div>
        <div>
            <div class="page-heading">
                <div class="flex justify-between">
                    <div>
                        <h1>Prehľad priradených úloh</h1>
                    </div>
                    <div class="md:hidden">
                        <div class="dropdown pl-3">
                            <label tabindex="0" class="m-1">                                        
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </label>
                            <ul tabindex="0" class="dropdown-content menu p-3 shadow bg-white rounded-box w-52 text-sm right-4">
                                <ReportMenu />
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <button @click="openModal" class="buttons">Pridať úlohu</button>
            </div>

            <div>
                <TaskModal v-if="showModal" @closeModal="closeModal" @saveTask="saveTask" :form="this.newTask" :taskTypes="this.taskTypes" 
                :taskPriorities="this.taskPriorities" :divisions="this.divisions" :areas="this.areas" :users="this.users"/>
            </div>

            <div class="cards">
                <div class="card task-overview-card">
                    <div class="text-center font-bold mb-2">
                        Nezačaté
                    </div>
                    <div v-for="(task, index) in tasks" :key="index">
                        <TaskOverviewTask v-if="task.status_id == 1" :title="task.task_title" :taskPriority="task.task_priority_id" :taskId="task.id"/>
                    </div>
                </div>
                <div class="card task-overview-card">
                    <div class="text-center font-bold mb-2">
                        Rozpracované
                    </div>
                    <div v-for="(task, index) in tasks" :key="index">
                        <TaskOverviewTask v-if="task.status_id == 2" :title="task.task_title" :taskPriority="task.task_priority_id" :taskId="task.id"/>
                    </div>
                </div>
                <div class="card task-overview-card">
                    <div class="text-center font-bold mb-2">
                        Dokončené
                    </div>
                    <div v-for="(task, index) in tasks" :key="index">
                        <TaskOverviewTask v-if="task.status_id == 3" :title="task.task_title" :taskPriority="task.task_priority_id" :taskId="task.id"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import TaskOverviewTask from './TaskOverviewTask.vue';
    import TaskModal from '@/Modals/TaskModal.vue';
    import { Inertia } from '@inertiajs/inertia';
    import ReportMenu from '@/Components/ReportMenu.vue';
    // import axios from 'axios';

    export default {
        name: 'TaskOverview',
        components: {
            TaskOverviewTask,
            TaskModal,
            ReportMenu,
        },
        props: {
            tasks:{
                type: Object,
                default: () => { }
            }, 
            users:{
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
        data() {
            return{
                showModal: false,
                newTask: {
                    id: '',
                    type_id: '',
                    task_title: '',
                    description: '',
                    user_id_assigned: '',
                    task_priority_id: '',
                    division_id: '',
                    area_id: '',
                    deadline: '',
                },
            }
        },
        methods: {
            openModal(){
                this.showModal = true;
            },
            closeModal() {
                this.showModal = false;
                this.resetModal();
            },
            resetModal(){
                this.newTask = {
                    id: '',
                    type_id: '',
                    task_title: '',
                    description: '',
                    user_id_assigned: '',
                    task_priority_id: '',
                    division_id: '',
                    area_id: '',
                    deadline: '',
                }
            },
            saveTask(param){
                Inertia.post(route("dashboard-store-task", param), param, {
                    onSuccess: page => {
                        if (Object.entries(page.props.errors).length === 0) {
                            this.closeModal();
                            this.resetModal();
                        }
                    }
                });

                Inertia.on("error", event => {
                    event.preventDefault();
                    console.log('error pri saveTask ', event.message);
                });
            },
        },
    }
</script>

<style scoped>
    .task-overview-card {
        background-color: var(--sgt-color); 
        border: 1px solid black; 
        border-radius: 10px; padding: 15px 25px;
    }
</style>
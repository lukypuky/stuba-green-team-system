<template>
    <div>
        <div>
            <div class="page-heading">
                <h1>Prehľad priradených úloh</h1>
            </div>

            <div class="add-task-button">
                <button @click="openModal">Pridať úlohu</button>
            </div>

            <div>
                <TaskModal v-if="showModal" @closeModal="closeModal" @saveTask="saveTask" :form="newTask" :taskTypes="taskTypes" :taskPriorities="taskPriorities" 
                :divisions="divisions" :areas="areas"/>
            </div>

            <div class="cards">
                <div class="card task-overview-card">
                    <div class="task-container-heading">
                        Nezačaté
                    </div>
                    <div v-for="(task, index) in tasks" :key="index">
                        <TaskOverviewTask v-if="task.status_id == 1" :title="task.task_title" :priority="task.priority_id" :taskId="task.id"/>
                    </div>
                </div>
                <div class="card task-overview-card">
                    <div class="task-container-heading">
                        Rozpracované
                    </div>
                    <div v-for="(task, index) in tasks" :key="index">
                        <TaskOverviewTask v-if="task.status_id == 2" :title="task.task_title" :priority="task.priority_id" :taskId="task.id"/>
                    </div>
                </div>
                <div class="card task-overview-card">
                    <div class="task-container-heading">
                        Dokončené
                    </div>
                    <div v-for="(task, index) in tasks" :key="index">
                        <TaskOverviewTask v-if="task.status_id == 3" :title="task.task_title" :priority="task.priority_id" :taskId="task.id"/>
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
    // import axios from 'axios';

    export default {
        name: 'TaskOverview',
        components: {
            TaskOverviewTask,
            TaskModal,
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
        data() {
            return{
                showModal: false,
                newTask: {
                    id: '',
                    type_id: '',
                    task_title: '',
                    description: '',
                    // user_id_assigned: '',
                    priority_id: '',
                    division_id: '',
                    area_id: '',
                    deadline: '',
                },
            }
        },
        // mounted() {
        //     axios.get(route('task.index'))
        //     .then((res) => {
        //         this.tasks = res.data
        //     })
        // },
        methods: {
            openModal(){
                this.showModal = true;
            },
            closeModal() {
                this.showModal = false;
            },
            resetModal(){
                this.newTask = {
                    id: '',
                    type_id: '',
                    task_title: '',
                    description: '',
                    // user_id_assigned: '',
                    priority_id: '',
                    division_id: '',
                    area_id: '',
                    deadline: '',
                }
            },
            saveTask(param){
                Inertia.post(route("dashboard-save-task", param), param, {
                    onSuccess: page => {
                        if (Object.entries(page.props.errors).length === 0) {
                            this.closeModal();
                            this.resetModal();

                            // window.eventBus.emit('refreshCalendar',);
                        }
                    }
                });

                Inertia.on("error", event => {
                    event.preventDefault();
                    console.log('error pri saveTask ', event.message);
                });
            },
        },
        // beforeMount(){
        //     axios.get(route('task.index'))
        //     .then((res) => {
        //         this.tasks = res.data
        //     })
        // }
}
</script>

<style scoped>
.add-task-button {
    margin: 10px;
}
.task-container-heading {
    text-align: center;
    font-weight: bold;
    margin-bottom: 5px;
}

.task-overview-card {
    background-color: var(--stuba-sgt-green-color); 
    border: 1px solid black; 
    border-radius: 10px; padding: 
    15px 25px;
}
</style>
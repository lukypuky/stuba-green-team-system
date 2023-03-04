<template>
    <AppLayout>
        <div class="container page-container">
            <!-- <div class="bg-green-100 border-t border-b border-green-500 text-green-700 px-4 py-3" role="alert"
                v-if="showAlert">
                <p class="text-sm">{{ $page.props.flash.success_task_save }}</p>
            </div> -->
            <div class="row">
                <div class="col-2 report-left-section">
                    <ReportMenu/>
                </div>
                <div class="col-10 report-right-section">
                    <div>
                        <div class="page-heading">
                            <div class="task-heading-container">
                                <div class="task-heading-right-margin">
                                    <h1>{{ this.taskDetail.task_title }}</h1>
                                </div>
                                <div v-if="inputEnable" class="task-heading-right-margin">
                                    <Icon name="update" width="20" @click="setInputs"/>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="task-heading-container">
                                <div v-if="!inputEnable" class="task-heading-right-margin task-heading-left-margin ">
                                    <button @click="updateTask">Uložiť</button>
                                    <!-- <Icon name="check" width="25" @click="updateTask"/> -->
                                </div>
                                <div v-if="!inputEnable">
                                    <button @click="resetTask">Zrušiť</button>
                                    <!-- <Icon name="cancel" width="18" @click="resetTask"/> -->
                                </div>
                            </div>
                        </div>
                        <div class="cards">
                            <input type="hidden" name="id" v-model="this.taskDetail.id" />
                            <div class="card bg-gray-100">
                                <div class="card-row">
                                    <div>
                                        Typ: 
                                    </div>
                                    <div>
                                        <select id="type_id" v-model="this.taskDetail.type_id" :disabled="inputEnable"
                                            class="mt-1 block form-select w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" required>
                                            <option v-for="(taskType, index) in taskTypes.original" :key="index" :value="taskType.id">{{ taskType.task_type_title }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="card-row">
                                    <div>
                                        Priorita: 
                                    </div>
                                    <div>
                                        <select id="priority_id" v-model="this.taskDetail.priority_id" :disabled="inputEnable"
                                            class="mt-1 block form-select w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" required>
                                            <option v-for="(taskPriority, index) in taskPriorities.original" :key="index" :value="taskPriority.id">{{ taskPriority.task_priority_title }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="card-row">
                                    <div>
                                        Divízia: 
                                    </div>
                                    <div>
                                        <select id="division_id" v-model="this.taskDetail.division_id" :disabled="inputEnable"
                                            class="mt-1 block form-select w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" required>
                                            <option v-for="(division, index) in divisions.original" :key="index" :value="division.id">{{ division.division_title }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="card-row">
                                    <div>
                                        Oblasť: 
                                    </div>
                                    <div>
                                        <select id="area_id" v-model="this.taskDetail.area_id" :disabled="inputEnable"
                                            class="mt-1 block form-select w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" required>
                                            <option v-for="(area, index) in areas.original" :key="index" :value="area.id">{{ area.area_title }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="card-row">
                                    <div>
                                        Status: 
                                    </div>
                                    <div>
                                        <select id="status_id" v-model="this.taskDetail.status_id" :disabled="inputEnable"
                                            class="mt-1 block form-select w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" required>
                                            <option v-for="(status, index) in taskStatuses.original" :key="index" :value="status.id">{{ status.task_status_title }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="card-row">
                                    <div>
                                        Popis: 
                                    </div>
                                    <div>
                                        <textarea v-model="this.taskDetail.description" :disabled="inputEnable"
                                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                            id="description" placeholder="Popis">
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="card bg-gray-100 ">
                                <div class="card-row">
                                    <div>
                                        Priradené: 
                                    </div>
                                    <div>
                                        <select id="priority_id" v-model="this.taskDetail.user_id_assigned" :disabled="inputEnable"
                                            class="mt-1 block form-select w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" required>
                                            <option v-for="(user, index) in users" :key="index" :value="user.id">{{ user.name }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="card-row">
                                    <div>
                                        Vytvoril: 
                                    </div>
                                    <div v-for="(user, index) in users" :key="index">
                                        <input type="text" v-if="user.id == this.taskDetail.user_id_created" v-model="user.name" disabled
                                            class="mt-1 shadow appearance-none border rounded w-full py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline"
                                            id="user_id_created" placeholder="Vytvoril"/>
                                    </div>
                                </div>
                                <div class="card-row">
                                    <div>
                                        Dátum vytvorenia: 
                                    </div>
                                    <div>
                                        <input type="text" v-model="createdAtDate" disabled
                                            class="mt-1 shadow appearance-none border rounded w-full py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline"
                                            id="created_at" placeholder="Dátum vytvorenia"/>
                                    </div>
                                </div>
                                <div class="card-row">
                                    <div>
                                        Dátum úpravy: 
                                    </div>
                                    <div>
                                        <input type="text" v-model="updatedAtDate" disabled
                                            class="mt-1 shadow appearance-none border rounded w-full py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline"
                                            id="updated_at" placeholder="Dátum úpravy"/>
                                    </div>
                                </div>
                                <div class="card-row">
                                    <div>
                                        Deadline: 
                                    </div>
                                    <div>
                                        <input type="date" v-model="this.taskDetail.deadline" :disabled="inputEnable"
                                            class="mt-1 shadow appearance-none border rounded w-full py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline"
                                            id="deadline" placeholder="Deadline"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="commnets-cards">
                            <div class="card bg-gray-100">
                                <div class="card-row">
                                    <div>
                                        Komentáre: 
                                    </div>
                                    <div>
                                        <button class="buttons">Pridať komentár</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Inertia } from '@inertiajs/inertia';
import Icon from '@/Components/Icon.vue';
import ReportMenu from '@/Components/ReportMenu.vue';
import moment from 'moment';

    export default {
        name: 'DashboardTaskDetail',
        components: {
            AppLayout,
            Icon,
            ReportMenu
        },
        props: {
            users:{
                type: Object,
                default: () => { }
            }, 
            task:{
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
            taskStatuses:{
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
            return {
                tmpTask: {
                    type_id: this.task.original[0].type_id,
                    priority_id: this.task.original[0].priority_id,
                    division_id: this.task.original[0].division_id,
                    area_id: this.task.original[0].area_id,
                    status_id: this.task.original[0].status_id,
                    description: this.task.original[0].description,
                    user_id_assigned: this.task.original[0].user_id_assigned,
                    deadline: this.task.original[0].deadline,
                },
                taskDetail: this.task.original[0],
                createdAtDate: moment(this.task.original[0].created_at).format('DD.MM.YYYY HH:MM'),
                updatedAtDate: moment(this.task.original[0].updated_at).format('DD.MM.YYYY HH:MM'),
                inputEnable: true,
            }
        },
        methods: {
            setInputs(){
                this.inputEnable = false;
                // this.resetTask();
            },
            resetTask(){
                this.inputEnable = true;

                this.taskDetail.type_id = this.tmpTask.type_id;
                this.taskDetail.priority_id = this.tmpTask.priority_id;
                this.taskDetail.division_id = this.tmpTask.division_id;
                this.taskDetail.area_id = this.tmpTask.area_id;
                this.taskDetail.status_id = this.tmpTask.status_id;
                this.taskDetail.description = this.tmpTask.description;
                this.taskDetail.user_id_assigned = this.tmpTask.user_id_assigned;
                this.taskDetail.deadline = this.tmpTask.deadline;
            },
            updateTask(){
                this.inputEnable = true;

                Inertia.post(route("dashboard-update-task", this.taskDetail), this.taskDetail, {
                    onSuccess: page => {
                        if (Object.entries(page.props.errors).length === 0) {

                        }
                    }
                });

                Inertia.on("error", event => {
                    event.preventDefault();
                    console.log('error pri updateTask ', event.message);
                });
            },
        }
    }
</script>

<style scoped>

.task-heading-container {
    display:flex; 
    align-items: center; 
    padding-left: 1rem;
}

.task-heading-right-margin {
    margin-right: 10px;
}

.task-heading-left-margin {
    margin-left: 10px;
}

.card {
    padding: 1rem;
    border: none;
}

.card-row {
    margin-bottom: 15px;
}

.cards, .commnets-cards {
    max-width: 1200px;
    margin: 0 10px;
    display: grid;
    grid-gap: 1rem;
}

input:disabled {
    background-color: #e9ecef;
}

textarea:disabled {
    background-color: #e9ecef;
}

/* Screen larger than 600px? 2 column */
@media (min-width: 600px) {
    .cards { grid-template-columns: repeat(2, 1fr); }
    .commnets-cards { grid-template-columns: repeat(1, 1fr); }
}

/* Screen larger than 900px? 3 columns */
@media (min-width: 900px) {
    .cards { grid-template-columns: repeat(2, 1fr); }
    .commnets-cards { grid-template-columns: repeat(1, 1fr); }
}
</style>
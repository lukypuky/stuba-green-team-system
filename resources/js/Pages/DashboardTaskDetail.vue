<template>
    <AppLayout>
        <div class="relative w-full">
            <div class="absolute top-0 right-0 h-10 border-t border-b px-4 py-2 message" v-if="showAlert">
                <p class="text-sm">{{ $page.props.flash.success_object_update_save }}</p>
            </div>
        </div>
        <div class="relative w-full">
            <div class="absolute top-0 right-0 h-10 border-t border-b px-4 py-2 message-uunsuccess" v-if="showUnsuccessfulAlert">
                <p class="text-sm">{{ $page.props.flash.unsuccess_object_delete }}</p>
            </div>
        </div>
        <div class="container page-container">
            <div class="mx-auto grid grid-cols-12 gap-4 p-1">
                <div class="col-span-12 sm:col-span-2">
                    <div class="hidden md:block text-sm">
                        <ReportMenu/>
                    </div>
                </div>
                <div class="col-span-12 sm:col-span-10">
                    <div class="page-heading mb-0">
                        <div class="flex justify-between mb-3">
                            <div>
                                <h1>{{ task[0].task_title }}</h1>
                            </div>
                            <div class="md:hidden">
                                <div class="dropdown pl-3">
                                    <label tabindex="0" class="m-1">                                        
                                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                         </svg>
                                    </label>
                                    <ul tabindex="0" class="dropdown-content menu p-3 shadow bg-white rounded-box w-52 text-sm right-4">
                                        <ReportMenu/>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="inputEnable" class="flex">
                        <div class="mr-3">
                            <Icon name="update" width="20" @click="setInputs"/>
                        </div>
                        <div>
                            <Icon name="delete" width="20" @click.prevent="deleteTaskModal(this.task[0].id)"/>
                        </div>
                    </div>
                    <div class="flex mb-3">
                        <div v-if="!inputEnable" class="mr-3">
                            <button @click="updateTask" class="buttons">Uložiť</button>
                        </div>
                        <div v-if="!inputEnable">
                            <button @click="resetTask" class="buttons-gray">Zrušiť</button>
                        </div>

                        <DeleteModal v-if="this.showDeleteModal" @closeDeleteModal="closeDeleteModal" @deleteObject="deleteObject" :deletedObjectId="deletedObjectId"/>
                    </div>
                    <div class="cards">
                        <input type="hidden" name="id" v-model="this.task.id" />
                        <div class="card bg-transparent">
                            <div class="card-row">
                                <div>Názov: <span class="text-red-500">*</span></div>
                                <div>
                                    <input type="text" v-model="this.task[0].task_title" :disabled="inputEnable"
                                        class="mt-1 shadow appearance-none border rounded w-full py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline"
                                        id="task_title" placeholder="Názov" required/>
                                    <div v-if="$page.props.errors.task_title" class="text-red-500">
                                        {{ $page.props.errors.task_title }}
                                    </div>
                                </div>
                            </div>
                            <div class="card-row">
                                <div>Typ: <span class="text-red-500">*</span></div>
                                <div>
                                    <select id="type_id" v-model="this.task[0].type_id" :disabled="inputEnable"
                                        class="mt-1 block form-select w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" required>
                                        <option v-for="(taskType, index) in this.taskTypes" :key="index" :value="taskType.id">{{ taskType.task_type_title }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card-row">
                                <div>Priorita: <span class="text-red-500">*</span></div>
                                <div>
                                    <select id="priority_id" v-model="this.task[0].task_priority_id" :disabled="inputEnable"
                                        class="mt-1 block form-select w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" required>
                                        <option v-for="(taskPriority, index) in this.taskPriorities" :key="index" :value="taskPriority.id">{{ taskPriority.task_priority_title }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card-row">
                                <div>Divízia: <span class="text-red-500">*</span></div>
                                <div>
                                    <select id="division_id" v-model="this.task[0].division_id" :disabled="inputEnable"
                                        class="mt-1 block form-select w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" required>
                                        <option v-for="(division, index) in this.divisions" :key="index" :value="division.id">{{ division.division_title }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card-row">
                                <div>Oblasť: <span class="text-red-500">*</span></div>
                                <div>
                                    <select id="area_id" v-model="this.task[0].area_id" :disabled="inputEnable"
                                        class="mt-1 block form-select w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" required>
                                        <option v-for="(area, index) in this.areas" :key="index" :value="area.id">{{ area.area_title }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card-row">
                                <div>Status: <span class="text-red-500">*</span></div>
                                <div>
                                    <select id="status_id" v-model="this.task[0].status_id" :disabled="inputEnable"
                                        class="mt-1 block form-select w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" required>
                                        <option v-for="(status, index) in this.taskStatuses" :key="index" :value="status.id">{{ status.task_status_title }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card-row">
                                <div>Popis: </div>
                                <div>
                                    <textarea v-model="this.task[0].description" :disabled="inputEnable"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        id="description" placeholder="Popis">
                                    </textarea>
                                </div>
                            </div>
                        </div>
                        <div class="card bg-transparent">
                            <div class="card-row">
                                <div>Priradené: <span class="text-red-500">*</span></div>
                                <div>
                                    <select id="user_id_assigned" v-model="this.task[0].user_id_assigned" :disabled="inputEnable"
                                        class="mt-1 block form-select w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" required>
                                        <option v-for="(user, index) in this.users" :key="index" :value="user.id">{{ user.name }}</option>
                                     </select>
                                </div>
                            </div>
                            <div class="card-row">
                                <div>Vytvoril: </div>
                                <div v-for="(user, index) in users" :key="index">
                                    <input type="text" v-if="user.id == this.task[0].user_id_created" v-model="user.name" disabled
                                        class="mt-1 shadow appearance-none border rounded w-full py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline"
                                        id="user_id_created" placeholder="Vytvoril"/>
                                </div>
                            </div>
                            <div class="card-row">
                                <div>Dátum vytvorenia: </div>
                                <div>
                                    <input type="text" v-model="this.task[0].created_at" disabled
                                        class="mt-1 shadow appearance-none border rounded w-full py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline"
                                        id="created_at" placeholder="Dátum vytvorenia"/>
                                </div>
                            </div>
                            <div class="card-row">
                                <div>Dátum úpravy: </div>
                                <div>
                                    <input type="text" v-model="this.task[0].updated_at" disabled
                                        class="mt-1 shadow appearance-none border rounded w-full py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline"
                                        id="updated_at" placeholder="Dátum úpravy"/>
                                </div>
                            </div>
                            <div class="card-row">
                                <div>Deadline: </div>
                                <div>
                                    <input type="date" v-model="this.task[0].deadline" :disabled="inputEnable"
                                        class="mt-1 shadow appearance-none border rounded w-full py-2 px-3 text-gray-800 leading-tight focus:outline-none focus:shadow-outline"
                                        id="deadline" placeholder="Deadline"/>
                                </div>
                            </div>
                            <div class="card-row">
                                <div>Čas strávený na úlohe: </div>
                                <div class="flex justify-center items-center text-4xl time-color">
                                    {{ this.interval }}
                                </div>
                            </div>
                        </div>
                        </div>
                    <div class="commnets-cards">
                        <div class="card bg-transparent">
                            <div class="card-row">
                                <div>Komentáre: </div>
                                <form action="">
                                    <div>
                                        <textarea v-model="this.newComment.comment_body" id="new-comment" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                        </textarea>
                                    </div>
                                    <div>
                                        <button type="button" class="buttons" @click.prevent="addComment">Pridať komentár</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card bg-inherit" v-if="this.comments.length">
                            <div class="card-row" v-for="(comment, index) in this.comments" :key="index">
                                <div class="mb-1">
                                    {{ comment.name }} <span class="text-gray-400 text-sm">{{ comment.created_at }}</span>
                                </div>
                                <div>
                                    <textarea v-model="comment.comment_body" class="shadow resize-none appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" disabled="true">
                                    </textarea>
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
import DeleteModal from '@/Modals/DeleteModal.vue';

    export default {
        name: 'DashboardTaskDetail',
        components: {
            AppLayout,
            Icon,
            ReportMenu,
            DeleteModal, 
        },
        props: {
            interval:{
                type: String,
                default: ''
            }, 
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
            comments:{
                type: Object,
                default: () => { }
            }, 
        },
        data() {
            return {
                taskTitle: this.task[0].task_title,
                tmpTask: {
                    task_title: this.task[0].task_title,
                    type_id: this.task[0].type_id,
                    task_priority_id: this.task[0].task_priority_id,
                    division_id: this.task[0].division_id,
                    area_id: this.task[0].area_id,
                    status_id: this.task[0].status_id,
                    description: this.task[0].description,
                    user_id_assigned: this.task[0].user_id_assigned,
                    deadline: this.task[0].deadline,
                },
                taskDetail: this.task[0],
                inputEnable: true,
                showDeleteModal: false,
                deletedObjectId: '',
                newComment: {
                    comment_body: '',
                    task_id: '',
                },
            }
        },
        methods: {
            setInputs(){
                this.inputEnable = false;
                // this.resetTask();
            },
            closeDeleteModal() {
                this.showDeleteModal = false;
            },
            resetTask(){
                this.inputEnable = true;

                this.taskDetail.task_title = this.tmpTask.task_title;
                this.taskDetail.type_id = this.tmpTask.type_id;
                this.taskDetail.task_priority_id = this.tmpTask.task_priority_id;
                this.taskDetail.division_id = this.tmpTask.division_id;
                this.taskDetail.area_id = this.tmpTask.area_id;
                this.taskDetail.status_id = this.tmpTask.status_id;
                this.taskDetail.description = this.tmpTask.description;
                this.taskDetail.user_id_assigned = this.tmpTask.user_id_assigned;
                this.taskDetail.deadline = this.tmpTask.deadline;
            },
            updateTask(){
                this.inputEnable = true;

                Inertia.post(route("dashboard-update-task"), this.task[0]);

                this.taskTitle = this.task[0].task_title;

                Inertia.on("error", event => {
                    event.preventDefault();
                    console.log('error pri updateTask ', event.message);
                });
            },
            deleteTaskModal(taksId){
                this.showDeleteModal = true;
                this.deletedObjectId = taksId.toString();
            },
            deleteObject(param){
                var request = {id: param};

                Inertia.post(route("dashboard-delete-task"), request);

                Inertia.on("error", event => {
                    event.preventDefault();
                    console.log('error pri delete task ', event.message);
                });

                this.closeDeleteModal();
            },
            addComment(){
                if(this.newComment.comment_body.trim().length == 0){
                    return;
                }
                else{
                    this.newComment.task_id = this.task[0].id;

                    Inertia.post(route("dashboard-store-comment"), this.newComment, {
                        onSuccess: page => {
                            if (Object.entries(page.props.errors).length === 0) {
                                this.newComment.comment_body = '';
                                this.newComment.task_id = '';
                            }
                        }
                    });
                }
            }
        },
        computed: {
            showAlert() {
                if(this.$page.props.flash.success_object_update_save !== null) {
                    setTimeout(() => {
                        this.$page.props.flash.success_object_update_save = null
                    }, 3000);
                    return true;
                }

                return false;
            },
            showUnsuccessfulAlert() {
                if(this.$page.props.flash.unsuccess_object_delete !== null) {
                    setTimeout(() => {
                        this.$page.props.flash.unsuccess_object_delete = null
                    }, 3000);
                    return true;
                }

                return false;
            }
        },
    }
</script>

<style scoped>
    .time-color {
        color: var(--sgt-color);
    }

    .card {
        border: none;
    }

    .card-row {
        margin-bottom: 15px;
    }

    .cards, .commnets-cards {
        max-width: 1200px;
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
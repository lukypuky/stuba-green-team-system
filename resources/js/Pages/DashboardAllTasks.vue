<template>
    <AppLayout>
        <div class="container page-container">
            <div class="mx-auto grid grid-cols-12 gap-4 p-1">
                <div class="col-span-12 sm:col-span-2">
                    <ReportMenu/>
                </div>
                <div class="col-span-12 sm:col-span-10">
                    <div class="page-heading">
                        <h1>Prehľad všetkých úloh</h1>
                    </div>
                    <div class="flex mb-3">
                        <div class="mr-3">
                            <input type="text" class="rounded-md" v-model="this.findTask.findTaskString"
                            placeholder="Vyhľadať úlohu">
                        </div>
                        <div>
                            <button class="buttons" id="searchJobsButton" @click="searchTask">Hľadať</button>
                        </div>
                    </div>
                    <div class="overflow-auto rounded-lg shadow">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b-2 border-gray-200">
                                <tr>
                                    <th class="p-3 text-sm font-semibold tracking-wide text-left">Akcie</th>
                                    <th class="p-3 text-sm font-semibold tracking-wide text-left">Názov</th>
                                    <th class="p-3 text-sm font-semibold tracking-wide text-left">Priradené</th>
                                    <th class="p-3 text-sm font-semibold tracking-wide text-left">Status</th>
                                    <th class="p-3 text-sm font-semibold tracking-wide text-left">Dátum vytvorenia</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <tr class="bg-white" v-for="(task, index) in this.newTasks.data" :key="index">
                                    <td class="p-3 text-sm text-gray-700 whitespace-nowrap">
                                        <div class="flex">
                                            <div class="pr-2">
                                                <Link :href="route('dashboard-task-detail', task.id)">
                                                    <Icon name="update" width="20"/>
                                                </Link>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-3 text-sm text-gray-700 whitespace-nowrap">
                                        {{ task.task_title }}
                                    </td>
                                    <td class="p-3 text-sm text-gray-700 whitespace-nowrap">
                                        {{ task.name }}
                                    </td>
                                    <td class="p-3 text-sm text-gray-700 whitespace-nowrap">
                                        {{ task.task_status_title }}
                                    </td>
                                    <td class="p-3 text-sm text-gray-700 whitespace-nowrap">
                                        {{ task.created_at }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="grid grid-cols-1 gap-4 md:hidden mb-2 text-sm" v-for="(task, index) in this.newTasks.data" :key="index">
                        <div class="bg-white space-y-4 p-4 rounded-lg shadow">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    Akcie
                                </div>
                                <div>
                                    <div class="flex">
                                        <div class="pr-2">
                                            <Link :href="route('dashboard-task-detail', task.id)">
                                                <Icon name="update" width="20"/>
                                            </Link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    Názov
                                </div>
                                <div class="break-words">
                                    {{ task.task_title }}
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    Priradené
                                </div>
                                <div class="break-words">
                                    {{ task.name }}
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    Status
                                </div>
                                <div class="break-words">
                                    {{ task.task_status_title }}
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    Dátum vytvorenia
                                </div>
                                <div class="break-words">
                                    {{ task.created_at }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <Pagination :links="this.newTasks.links"/>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import ReportMenu from '@/Components/ReportMenu.vue';
import Pagination from '@/Components/Pagination.vue';
import Icon from '@/Components/Icon.vue';
import { Link } from '@inertiajs/inertia-vue3';
import axios from 'axios';

export default {
    name: 'DashboardAllTasks',
    components: {
        AppLayout,
        ReportMenu,
        Pagination,
        Icon,
        Link,
    },
    props: {
        tasks:{
            type: Object,
            default: () => { }
        }, 
    },
    data(){
        return{
            newTasks: {},
            findTask: {findTaskString: ''},
        }
    },
    methods: {
        searchTask(){
            axios.post(route('dashboard-search-tasks', this.findTask))
            .then((res) => {
                this.newTasks = res.data;
            });
        }
    },
    beforeMount() {
        this.newTasks = this.tasks;
    }
}
</script>

<style scoped>

</style>
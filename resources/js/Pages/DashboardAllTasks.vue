<template>
    <AppLayout>
        <div class="container page-container">
            <div class="row">
                <div class="col-2 report-left-section">
                    <ReportMenu/>
                </div>
                <div class="col-10 report-right-section">
                    <div style="display: flex;">
                        <div>
                            <input type="text" class="form-control objectBorder roundedCorners" v-model="this.findTask.findTaskString"
                            placeholder="Vyhľadať úlohu">
                        </div>
                        <div>
                            <button class="buttons" id="searchJobsButton" @click="searchTask">Hľadať</button>
                        </div>
                    </div>
                    <div>
                        <table class="min-w-full border-collapse block md:table">
                            <thead class="block md:table-header-group">
                                <tr class="border border-grey-500 md:border-none block md:table-row absolute -top-full md:top-auto -left-full md:left-auto  md:relative ">
                                    <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">Názov</th>
                                    <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">Priradené</th>
                                    <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">Status</th>
                                    <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">Dátum vytvorenia</th>
                                    <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell"></th>
                                </tr>
                            </thead>
                            <tbody class="block md:table-row-group">
                                <AllTasksTableRow :tasks="this.newTasks"/>
                            </tbody>
                        </table>
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
import AllTasksTableRow from '@/Components/AllTasksTableRow.vue';
import Pagination from '@/Components/Pagination.vue';
import axios from 'axios';

export default {
    name: 'DashboardAllTasks',
    components: {
        AppLayout,
        ReportMenu,
        AllTasksTableRow,
        Pagination,
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

    @media (min-width: 640px) {
        table {
        display: inline-table !important;
        }

        thead tr:not(:first-child) {
        display: none;
        }
    }

    td:not(:last-child) {
        border-bottom: 0;
    }

    th:not(:last-child) {
        border-bottom: 2px solid rgba(0, 0, 0, .1);
    }
</style>
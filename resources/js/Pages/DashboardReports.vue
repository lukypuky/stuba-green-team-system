<template>
    <AppLayout>
        <div class="container page-container">
            <div class="mx-auto grid grid-cols-12 gap-4 p-1">
                <div class="col-span-12 sm:col-span-2">
                    <div class="hidden md:block text-sm">
                        <ReportMenu/>
                    </div>
                </div>
                <div class="col-span-12 sm:col-span-10">
                    <div class="page-heading">
                        <div class="flex justify-between">
                            <div>
                                <h1>Prehľad výkazov</h1>
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
                    <div class="sm:flex mb-3">
                        <div>
                            <input type="month" v-model="this.newDate.reportDate" @change="changeDate" class="select-bordered w-full max-w-xs custom-select shadow appearance-none rounded-md mb-2 py-2 px-3"
                            id="meeting_month" required/>
                        </div>
                    </div>
                    <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-md">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b-2 border-gray-200">
                                <tr>
                                    <th class="p-3 text-sm font-semibold tracking-wide text-left">Meno</th>
                                    <th class="p-3 text-sm font-semibold tracking-wide text-left"
                                        v-for="(reportDate, index) in this.newReportDates" :key="index">
                                        {{ reportDate.date }}
                                    </th>
                                    <th class="p-3 text-sm font-semibold tracking-wide text-left">Spolu</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <tr class="bg-white" v-for="(reportTime, index) in this.newReportTimes" :key="index">
                                    <td class="p-3 text-sm text-gray-700 whitespace-nowrap">
                                        {{ reportTime.username }}
                                    </td>
                                    <td class="p-3 text-sm text-gray-700 whitespace-nowrap" v-for="(reportDate, index) in this.newReportDates" :key="index">
                                        {{ reportTime[reportDate.date] }}
                                    </td>
                                    <td class="p-3 text-sm text-gray-700 whitespace-nowrap" >
                                        {{ reportTime.finalTime }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
    import axios from 'axios';

    export default {
        name: 'DashboardReports',
        components: {
            AppLayout,
            Inertia,
            Icon,
            ReportMenu,
        },
        props: {
            reportDates: {
                type: Object,
                default: () => { }
            },
            reportTimes: {
                type: Object,
                default: () => { }
            },
        },
        data(){
            return{
                newDate: { 
                    reportDate: null,
                },
                newReportDates: {},
                newReportTimes: {},
            }
        },
        methods: {
            changeDate(){
                axios.post(route('dashboard-change-reports-month', this.newDate))
                .then((res) => {
                    this.newReportDates = res.data.reportDates;
                    this.newReportTimes = res.data.reportTimes;
                    console.log(res);
                });
            }
        },
        beforeMount(){
            this.newReportDates = this.reportDates;
            this.newReportTimes = this.reportTimes;
        }
    }
</script>

<style scoped>

</style>
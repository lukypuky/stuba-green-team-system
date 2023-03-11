<template>
    <AppLayout>
        <div class="container page-container">
            <div class="mx-auto grid grid-cols-12 gap-4 p-1">
                <div class="col-span-12 sm:col-span-2">
                    <ReportMenu/>
                </div>
                <div class="col-span-12 sm:col-span-10">
                    <div class="bg-green-100 border-t border-b border-green-500 text-green-700 px-4 py-3" role="alert" v-if="showAlert">
                        <p class="text-sm">{{ $page.props.flash.success_report_save }}</p>
                        <p class="text-sm">{{ $page.props.flash.success_report_update_save }}</p>
                        <p class="text-sm">{{ $page.props.flash.success_report_delete }}</p>
                    </div>
                    <div class="page-heading">
                        <h1>Výkazy</h1>
                    </div>

                    <Calendar @dateClick="dateClick" @reportClick="reportClick" :reports="this.newReports"/>
                </div>
            </div>
        </div>
        <CalendarModal v-if="showModal" :form="this.newReport" :modalTasks="this.modalTasks" :updateReportFlag="this.updateReportFlag" @closeModal="closeModal" @saveReport="saveReport" @deleteReport="deleteReport"/>
    </AppLayout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import ReportButton from '@/Components/ReportButton.vue';
    import Calendar from '@/Components/Calendar.vue';
    import CalendarModal from '@/Modals/CalendarModal.vue';
    import ReportMenu from '@/Components/ReportMenu.vue';
    import moment from 'moment';
    import { Inertia } from '@inertiajs/inertia';
    // import axios from 'axios';

    export default {
        name: 'DashboardReport',
        components: {
            AppLayout,
            ReportButton,
            Calendar,
            CalendarModal,
            ReportMenu,
        },
        props: {
            reportInfo: {
                type: Object,
                default: () => { }
            },
            reports: {
                type: Object,
                default: () => { }
            },
            modalTasks: {
                type: Object,
                default: () => { }
            },
        },
        computed: {
            showAlert() {
                if (this.$page.props.flash.success_report_save !== null) {
                    setTimeout(() => {
                        this.$page.props.flash.success_report_save = null
                    }, 3000);
                    return true;
                }
                else if(this.$page.props.flash.success_report_update_save !== null) {
                    setTimeout(() => {
                        this.$page.props.flash.success_report_update_save = null
                    }, 3000);
                    return true;
                }
                else if(this.$page.props.flash.success_report_delete !== null) {
                    setTimeout(() => {
                        this.$page.props.flash.success_report_delete = null
                    }, 3000);
                    return true;
                }
                return false;
            },
        },
        data() {
            return {
                newReports: {},
                showModal: false,
                updateReportFlag :false,
                newReport: {
                    id: '',
                    report_title: '',
                    description: '',
                    user_id: '',
                    task_id: '',
                    date: '',
                    start_time: '',
                    end_time: '',
                }
            };
        },
        beforeMount() {
            this.newReports = this.reports;
        },
        methods: {
            dateClick(repotInfo) {
                this.showModal = true;
                this.updateReportFlag = false;
                this.setNewReportModal(repotInfo);
            },
            reportClick(repotInfo){
                this.showModal = true;
                this.updateReportFlag = true;
                this.setUpdateReportModal(repotInfo);
            },
            closeModal() {
                this.$page.props.errors.task_id = null;
                this.$page.props.errors.report_title = null;
                this.$page.props.errors.start_time = null;
                this.$page.props.errors.end_time = null;

                this.showModal = false;
                this.resetModal();
            },
            resetModal() {
                this.newReport = {
                    id: '',
                    report_title: '',
                    description: '',
                    user_id: '',
                    task_id: '',
                    date: '',
                    start_time: '',
                    end_time: '',
                }
            },
            setNewReportModal(reportInfo) {
                var dateAndTime = reportInfo.dateStr.split("T");
                this.newReport.date = dateAndTime[0];
                this.newReport.start_time = dateAndTime[1].substr(0, 8);
                this.newReport.user_id = this.$page.props.user.id;
                return;
            },
            setUpdateReportModal(reportInfo) {
                this.newReport.id = reportInfo._def.publicId;
                this.newReport.report_title = reportInfo.title;
                this.newReport.task_id = reportInfo._def.extendedProps.task_id;
                this.newReport.description = reportInfo._def.extendedProps.description;
                this.newReport.date = moment(reportInfo.start).format('YYYY-MM-DD');
                this.newReport.start_time = moment(reportInfo.start).format('HH:mm');
                this.newReport.end_time = moment(reportInfo.end).format('HH:mm');
                return;
            },
            saveReport(param) {
                var dataReport = this.setReportDuration(param);

                if (this.updateReportFlag) {
                    Inertia.post(route("dashboard-update-report"), dataReport, {
                        onSuccess: page => {
                            if (Object.entries(page.props.errors).length === 0) {
                                this.newReports = page.props.reports;
                                this.closeModal();
                                this.resetModal();
                            }
                        }
                    });
                }
                else {
                    Inertia.post(route("dashboard-store-report"), dataReport, {
                        onSuccess: page => {
                            if (Object.entries(page.props.errors).length === 0) {
                                this.newReports = page.props.reports;
                                this.closeModal();
                                this.resetModal();
                            }
                        }
                    });
                }
            },
            deleteReport(param){
                this.newReports = param;
            },
            setReportDuration(form) {
                var start_date = form.date + " " + form.start_time;
                var end_date;

                if(form.end_time == ''){
                    end_date = null;
                }
                else{
                    end_date = form.date + " " + form.end_time + ":00";
                    end_date = moment(end_date).format('YYYY-MM-DD HH:mm:ss');
                }

                return {
                    id: form.id,
                    report_title: form.report_title,
                    description: form.description,
                    user_id: this.$page.props.user.id,
                    task_id: form.task_id,
                    start_time: moment(start_date).format('YYYY-MM-DD HH:mm:ss'),
                    end_time: end_date,
                }
            },
        },
    }
</script>

<style scoped>

</style>

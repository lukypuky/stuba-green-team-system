<template>
    <AppLayout>
        <div class="container page-container">
            <div class="bg-green-100 border-t border-b border-green-500 text-green-700 px-4 py-3" role="alert"
                v-if="showAlert">
                <p class="text-sm">{{ $page.props.flash.success_report_save }}</p>
                <p class="text-sm">{{ $page.props.flash.success_report_update_save }}</p>
                <p class="text-sm">{{ $page.props.flash.success_report_delete }}</p>
            </div>
            <div class="row">
                <div class="col-2 report-left-section">
                    <ReportMenu/>
                </div>
                <div class="col-10 report-right-section">
                    <Calendar @dateClick="dateClick" @reportClick="reportClick" :reports="this.newReports"/>
                </div>
            </div>

            <div class="mx-auto grid grid-cols-12 gap-4 bg-zinc-50 p-1">
                <div class="col-span-12 rounded-lg border border-gray-500 bg-gray-200 p-32 sm:col-span-1">
                    <!-- Main Content -->
                </div>
                <div class="col-span-12 rounded-lg border border-gray-400 bg-gray-200 p-16 sm:col-span-10">
                    <!-- Sidebar -->
                </div>
            </div>
        </div>
        <CalendarModal v-if="showModal" :form="newReport" :modalTasks="modalTasks.original" :updateReportFlag="updateReportFlag" @closeModal="closeModal" @saveReport="saveReport" @deleteReport="deleteReport" />
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
            ReportMenu
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
            this.newReports = this.reports.original;
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
                this.showModal = false;
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
                if (param.report_title == '') {
                    alert('Názov je povinný');
                }

                var dataReport = this.setReportDuration(param);

                if (this.updateReportFlag) {
                    Inertia.put(route("report.update", dataReport), dataReport, {
                        onSuccess: page => {
                            if (Object.entries(page.props.errors).length === 0) {
                                console.log(page);
                                console.log('aaaaaaaa');
                                console.log(this.newReports);
                                this.newReports = page.props.reports.original;
                                console.log('cccccc');
                                console.log(this.newReports);
                                this.closeModal();
                                this.resetModal();

                                // window.eventBus.emit('refreshCalendar',);
                            }
                        }
                    });
                }
                else {
                    Inertia.post(route("report.store"), dataReport, {
                        onSuccess: page => {
                            if (Object.entries(page.props.errors).length === 0) {
                                console.log(page);
                                console.log('aaaaaaaa');
                                console.log(this.newReports);
                                this.newReports = page.props.reports.original;
                                console.log('cccccc');
                                console.log(this.newReports);
                                this.closeModal();
                                this.resetModal();

                                // window.eventBus.emit('refreshCalendar',);
                            }
                        }
                    });
                }

                Inertia.on("error", event => {
                    event.preventDefault();
                    console.log('error pri saveReport ', event.message);
                });
            },
            deleteReport(param){
                Inertia.delete(route("report.destroy", param), param.id, {
                    onSuccess: page => {
                        if (Object.entries(page.props.errors).length === 0) {
                            console.log(page);
                            console.log('aaaaaaaa');
                                console.log(this.newReports);
                                this.newReports = page.props.reports.original;
                                console.log('cccccc');
                                console.log(this.newReports);
                            this.closeModal();
                            this.resetModal();
                        }
                    }
                });

                Inertia.on("error", event => {
                    event.preventDefault();
                    console.log('error pri deleteReport ', event.message);
                });
            },
            setReportDuration(form) {
                var start_date = form.date + " " + form.start_time;
                var end_date = form.date + " " + form.end_time + ":00";

                return {
                    id: form.id,
                    report_title: form.report_title,
                    description: form.description,
                    user_id: this.$page.props.user.id,
                    task_id: form.task_id,
                    start_time: moment(start_date).format('YYYY-MM-DD HH:mm:ss'),
                    end_time: moment(end_date).format('YYYY-MM-DD HH:mm:ss'),
                }
            },
        },
    }
</script>

<style scoped>

</style>
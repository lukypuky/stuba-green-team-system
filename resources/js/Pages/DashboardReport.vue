<script>
import AppLayout from '@/Layouts/AppLayout.vue';
import ReportButton from '@/Components/ReportButton.vue';
import Calendar from '@/Components/Calendar.vue';
import CalendarModal from '@/Modals/CalendarModal.vue';
import moment from 'moment';
import { Inertia } from '@inertiajs/inertia';

export default {
    name: 'DashboardReport',
    components: {
        AppLayout,
        ReportButton,
        Calendar,
        CalendarModal,
    },
    props: {
        reportInfo: {
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
            showCalendarFlag: true,
            showTaskOverviewFlag: false,
            showModal: false,
            updateReportFlag :false,
            newReport: {
                id: '',
                title: '',
                description: '',
                user_id: '',
                // task_id: '',
                date: '',
                start_time: '',
                end_time: '',
            }
        };
    },
    methods: {
        dateClick(repotInfo) {
            this.$data.showModal = true;
            this.updateReportFlag = false;
            this.setNewReportModal(repotInfo);
        },
        reportClick(repotInfo){
            this.$data.showModal = true;
            this.updateReportFlag = true;
            this.setUpdateReportModal(repotInfo);
        },
        closeModal() {
            this.$data.showModal = false;
        },
        resetModal() {
            this.newReport = {
                id: '',
                title: '',
                description: '',
                user_id: '',
                // task_id: '',
                date: '',
                start_time: '',
                end_time: '',
            }
        },
        setNewReportModal(reportInfo) {
            let dateAndTime = reportInfo.dateStr.split("T");
            this.newReport.date = dateAndTime[0];
            this.newReport.start_time = dateAndTime[1].substr(0, 8);
            this.newReport.user_id = this.$page.props.user.id;
            return;
        },
        setUpdateReportModal(reportInfo) {
            this.newReport.id = reportInfo._def.publicId;
            this.newReport.title = reportInfo.title;
            this.newReport.description = reportInfo._def.extendedProps.description;
            this.newReport.date = moment(reportInfo.start).format('YYYY-MM-DD');
            this.newReport.start_time = moment(reportInfo.start).format('HH:mm');
            this.newReport.end_time = moment(reportInfo.end).format('HH:mm');
            return;
        },
        saveReport(param) {
            if (param.title == '') {
                alert('Názov je povinný');
            }

            let dataReport = this.setReportDuration(param);

            if (this.updateReportFlag) {
                Inertia.put(route("report.update", dataReport), dataReport, {
                    onSuccess: page => {
                        if (Object.entries(page.props.errors).length === 0) {
                            this.closeModal();
                            this.resetModal();

                            window.eventBus.emit('refreshCalendar',);
                        }
                    }
                });
            }
            else {
                Inertia.post(route("report.store"), dataReport, {
                    onSuccess: page => {
                        if (Object.entries(page.props.errors).length === 0) {
                            this.closeModal();
                            this.resetModal();

                            window.eventBus.emit('refreshCalendar',);
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
                            this.closeModal();
                            this.resetModal();

                            window.eventBus.emit('refreshCalendar',);
                        }
                    }
                });

            Inertia.on("error", event => {
                event.preventDefault();
                console.log('error pri deleteReport ', event.message);
            });
        },
        setReportDuration(form) {
            let start_date = form.date + " " + form.start_time;
            let end_date = form.date + " " + form.end_time + ":00";

            return {
                id: form.id,
                title: form.title,
                description: form.description,
                user_id: this.$page.props.user.id,
                // task_id: form.task_id,
                start_time: moment(start_date).format('YYYY-MM-DD HH:mm:ss'),
                end_time: moment(end_date).format('YYYY-MM-DD HH:mm:ss'),
            }
        },
        showCalendar(){
            this.showCalendarFlag = true;
            this.showTaskOverviewFlag = false;
        },
        showTaskOverview(){
            this.showCalendarFlag = false;
            this.showTaskOverviewFlag = true;
        },
    },
}
</script>

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
                <div class="col-3 report-left-section">
                    <ReportButton text="Výkaz práce"  @click="showCalendar"/>
                    <ReportButton text="Prehľad úloh" />
                    <ReportButton text="Dochádzka členov" /> <!--ADMIN-->
                    <ReportButton text="Prehľad výkazov" /> <!--ADMIN-->
                </div>
                <div class="col-9 report-right-section">
                    <Calendar v-if="showCalendarFlag" @dateClick="dateClick" @reportClick="reportClick"/>
                </div>
            </div>

        </div>
        <CalendarModal v-if="showModal" :form="newReport" :updateReportFlag="updateReportFlag" @closeModal="closeModal" @saveReport="saveReport" @deleteReport="deleteReport" />
    </AppLayout>
</template>

<style scoped>
.report-container {
    display: flex;
}

.report-left-section {
    border-right: 2px solid black;
}
</style>

<template>
    <AppLayout>
        <div class="container page-container">
            <div class="mx-auto grid grid-cols-12 gap-4 p-1">
                <div class="col-span-12 sm:col-span-2">
                    <ReportMenu/>
                </div>
                <div class="col-span-12 sm:col-span-10">
                    <div class="bg-green-100 border-t border-b border-green-500 text-green-700 px-4 py-3" role="alert" v-if="showAlert">
                        <p class="text-sm">{{ $page.props.flash.success_attendance_save }}</p>
                    </div>

                    <div class="page-heading">
                        <h1>Dochádzka členov</h1>
                    </div>
                    <div style="display: flex;">
                        <div>
                            <AttendanceSelect :meetingTypes="this.meetingTypes" :divisions="this.divisions" @getMeetingTypeAttendance="getMeetingTypeAttendance"
                            @showAddAttendanceButton="showAddAttendanceButton"/>
                        </div>
                        <div class="text-right">
                            <button @click="openModal" v-if="this.showButton">Pridať dochádzku</button>
                        </div>
                    </div>
                    <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-md">
                        <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
                            <thead class="bg-gray-300">
                                <tr>
                                    <th scope="col" class="p-3 font-medium text-gray-900 whitespace-nowrap">Meno</th>
                                    <th scope="col" class="p-3 font-medium text-gray-900 whitespace-nowrap" v-for="(meetingDate, index) in this.newMeetingDates" :key="index">{{ meetingDate.meeting_date }}</th>
                                    <th scope="col" class="p-3 font-medium text-gray-900 whitespace-nowrap">Body</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                                <tr class="hover:bg-gray-50" v-for="(attendance, index) in this.newAttendances" :key="index">
                                    <td class="p-3 border-b-2 border-gray-300">
                                        {{ attendance.username }}
                                    </td>
                                    <td class="p-3 border-b-2 border-gray-300" v-for="(meetingDate, index) in this.newMeetingDates" :key="index">
                                        <AttendanceIcons :type="attendance[meetingDate.meeting_date]"/>
                                    </td>
                                    <td class="p-3 border-b-2 border-gray-300" >
                                        {{ attendance.body }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            
            <!-- <div class="bg-green-100 border-t border-b border-green-500 text-green-700 px-4 py-3" role="alert" v-if="showAlert">
                <p class="text-sm">{{ $page.props.flash.success_attendance_save }}</p>
            </div> -->
            <!-- <div class="row">
                <div class="col-2 report-left-section">
                    <ReportMenu/>
                </div>
                <div class="col-10 report-right-section">
                    <div class="page-heading">
                        <h1>Dochádzka členov</h1>
                    </div>
                    <div style="display: flex;">
                        <div>
                            <AttendanceSelect :meetingTypes="this.meetingTypes" :divisions="this.divisions" @getMeetingTypeAttendance="getMeetingTypeAttendance"
                            @showAddAttendanceButton="showAddAttendanceButton"/>
                        </div>
                        <div class="text-right">
                            <button @click="openModal" v-if="this.showButton">Pridať dochádzku</button>
                        </div>
                    </div>
                    <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-md">
                        <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
                            <thead class="bg-gray-300">
                                <tr>
                                    <th scope="col" class="p-3 font-medium text-gray-900">Meno</th>
                                    <th scope="col" class="p-3 font-medium text-gray-900" v-for="(meetingDate, index) in this.newMeetingDates" :key="index">{{ meetingDate.meeting_date }}</th>
                                    <th scope="col" class="p-3 font-medium text-gray-900">Body</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                                <tr class="hover:bg-gray-50" v-for="(attendance, index) in this.newAttendances" :key="index">
                                    <td class="p-3 border-b-2 border-gray-300">
                                        {{ attendance.username }}
                                    </td>
                                    <td class="p-3 border-b-2 border-gray-300" v-for="(meetingDate, index) in this.newMeetingDates" :key="index">
                                        <AttendanceIcons :type="attendance[meetingDate.meeting_date]"/>
                                    </td>
                                    <td class="p-3 border-b-2 border-gray-300" >
                                        {{ attendance.body }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> -->
        </div>
        <AttendanceModal v-if="showModal" :meetingType="this.meetingType" :users="this.newUsers" :attendanceStatuses="this.attendanceStatuses" @closeModal="closeModal" @storeAttendance="storeAttendance"/>
    </AppLayout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import ReportMenu from '@/Components/ReportMenu.vue';
    import AttendanceModal from '@/Modals/AttendanceModal.vue';
    import AttendanceIcons from '@/Components/AttendanceIcons.vue';
    import AttendanceSelect from '@/Components/AttendanceSelect.vue';
    import { Inertia } from '@inertiajs/inertia';
    import axios from 'axios';

    export default {
        name: 'DashboardAttendance',
        components: {
            AppLayout,
            ReportMenu,
            AttendanceModal,
            AttendanceIcons,
            AttendanceSelect,
            Inertia,
        },
        props: {
            users:{
                type: Object,
                default: () => { }
            },
            meetingDates: {
                type: Object,
                default: () => { }
            },
            attendances: {
                type: Object,
                default: () => { }
            },
            meetingTypes: {
                type: Object,
                default: () => { }
            },
            divisions: {
                type: Object,
                default: () => { }
            },
            attendanceStatuses: {
                type: Object,
                default: () => { }
            },
            request: {
                type: Object,
                default: () => { }
            },
        },
        computed: {
            showAlert() {
                if (this.$page.props.flash.success_attendance_save !== null) {
                    setTimeout(() => {
                        this.$page.props.flash.success_attendance_save = null
                    }, 3000);
                    return true;
                }
                return false;
            },
        },
        data(){
            return{
                meetingType: {
                    meetingTypeId: '',
                    divisionId: null,
                },
                showButton: true,
                showModal: false,
                newAttendances: {},
                newMeetingDates: {},
                newUsers: {},
            }
        },
        beforeMount() {
            this.newAttendances = this.attendances;
            this.newMeetingDates = this.meetingDates;
            this.newUsers = this.users;
            this.meetingType.meetingTypeId = 1;
        },
        methods: {
            getMeetingTypeAttendance(param){
                this.meetingType = param;

                axios.post(route('dashboard-change-meeting-type', param))
                .then((res) => {
                    this.newAttendances = res.data.attendances;
                    this.newMeetingDates = res.data.meetingDates;
                    this.newUsers = res.data.users;
                });
            },
            closeModal() {
                this.showModal = false;
            },
            openModal(){
                this.showModal = true;
            },
            showAddAttendanceButton(param){
                this.showButton = param;
            },
            storeAttendance(param){
                var data = this.setData(param);

                Inertia.post(route("dashboard-store-attendance", data), data, {
                    onSuccess: page => {
                        if (Object.entries(page.props.errors).length === 0) {
                            this.newAttendances = page.props.attendances;
                            this.newMeetingDates = page.props.meetingDates;
                            this.newUsers = page.props.users;

                            this.closeModal();
                        }
                    }
                });

                Inertia.on("error", event => {
                    event.preventDefault();
                    console.log('error pri saveTask ', event.message);
                });
            },
            setData(param){
                return {
                    attendance: param.attendance,
                    division_id: param.division_id,
                    meeting_date: param.meeting_date,
                    meeting_type_id: param.meeting_type_id,
                }
            }

        }
    }
</script>

<style  scoped>

</style>
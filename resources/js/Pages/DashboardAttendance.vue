<template>
    <AppLayout>
        <div class="relative w-full">
            <div class="absolute top-0 right-0 h-10 border-t border-b px-4 py-2 message" v-if="showAlert">
                <p class="text-sm">{{ $page.props.flash.success_object_save }}</p>
                <p class="text-sm">{{ $page.props.flash.success_object_update_save }}</p>
                <p class="text-sm">{{ $page.props.flash.success_object_delete }}</p>
            </div>
        </div>
        <div class="container page-container">
            <div class="mx-auto grid grid-cols-12 gap-4 p-1">
                <div class="col-span-12 sm:col-span-2">
                    <div class="hidden md:block text-sm">
                        <ReportMenu />
                    </div>
                </div>
                <div class="col-span-12 sm:col-span-10">
                    <div class="page-heading">
                        <div class="flex justify-between">
                            <div>
                                <h1>Dochádzka členov</h1>
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
                            <AttendanceSelect :meetingTypes="this.meetingTypes" :divisions="this.divisions" @getMeetingTypeAttendance="getMeetingTypeAttendance"
                            @showAddAttendanceButton="showAddAttendanceButton"/>
                        </div>
                        <div class="text-right flex mb-2">
                            <div class="mr-3">
                                <button class="buttons" @click="openModal" v-if="this.showButton">Pridať dochádzku</button>
                            </div>
                            <div class="menu-margin">
                                <button class="buttons" @click="openUpdateModal" v-if="this.showButton">Upraviť dochádzku</button>
                            </div>
                        </div>
                        <div class="text-right lg:flex mb-2">
                            <!-- <div class="menu-margin">
                                <input type="month" @change="getMeetingTypeAttendance" v-model="this.newDate" class="select-bordered w-full max-w-xs custom-select shadow appearance-none rounded-md mb-2 py-2 px-3"
                                id="meeting_month" required/>
                            </div> -->
                            <!-- <div>
                                <button class="buttons w-full" @click="changeMonth">Zmeniť dátum</button>
                            </div> -->
                        </div>
                    </div>
                    <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-md">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b-2 border-gray-200">
                                <tr>
                                    <th class="p-3 text-sm font-semibold tracking-wide text-left">Meno</th>
                                    <th class="p-3 text-sm font-semibold tracking-wide text-left" v-for="(meetingDate, index) in this.newMeetingDates" :key="index">{{ meetingDate.meeting_date }}</th>
                                    <th class="p-3 text-sm font-semibold tracking-wide text-left">Body</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <tr class="bg-white" v-for="(attendance, index) in this.newAttendances" :key="index">
                                    <td class="p-3 text-sm text-gray-700 whitespace-nowrap">
                                        {{ attendance.username }}
                                    </td>
                                    <td class="p-3 text-sm text-gray-700 whitespace-nowrap" v-for="(meetingDate, index) in this.newMeetingDates" :key="index">
                                        <AttendanceIcons :type="attendance[meetingDate.meeting_date]"/>
                                    </td>
                                    <td class="p-3 text-sm text-gray-700 whitespace-nowrap" >
                                        {{ attendance.body }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <AttendanceModal v-if="showModal" :meetingType="this.meetingType" :users="this.newUsers" :attendanceStatuses="this.attendanceStatuses" @closeModal="closeModal" @storeAttendance="storeAttendance"/>
        <AttendanceUpdateModal v-if="showUpdateModal" :attendances="this.newAttendances" :meetingDates="this.newMeetingDates" :attendanceStatuses="this.attendanceStatuses" @closeModal="closeModal" @updateAttendance="updateAttendance" @deleteAttendance="deleteAttendance"/>
    </AppLayout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import ReportMenu from '@/Components/ReportMenu.vue';
    import AttendanceModal from '@/Modals/AttendanceModal.vue';
    import AttendanceUpdateModal from '@/Modals/AttendanceUpdateModal.vue';
    import AttendanceIcons from '@/Components/AttendanceIcons.vue';
    import AttendanceSelect from '@/Components/AttendanceSelect.vue';
    import { Inertia } from '@inertiajs/inertia';
    import Icon from '@/Components/Icon.vue';
    import axios from 'axios';

    export default {
        name: 'DashboardAttendance',
        components: {
            AppLayout,
            ReportMenu,
            AttendanceModal,
            AttendanceUpdateModal,
            AttendanceIcons,
            AttendanceSelect,
            Icon,
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
                if (this.$page.props.flash.success_object_save !== null) {
                    setTimeout(() => {
                        this.$page.props.flash.success_object_save = null
                    }, 3000);
                    return true;
                }
                else if(this.$page.props.flash.success_object_update_save !== null) {
                    setTimeout(() => {
                        this.$page.props.flash.success_object_update_save = null
                    }, 3000);
                    return true;
                }
                else if(this.$page.props.flash.success_object_delete !== null) {
                    setTimeout(() => {
                        this.$page.props.flash.success_object_delete = null
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
                showUpdateModal: false,
                newAttendances: {},
                newMeetingDates: {},
                newUsers: {},
                // newDate: null,
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
                axios.post(route('dashboard-change-meeting-type', param))
                .then((res) => {
                    this.newAttendances = res.data.attendances;
                    this.newMeetingDates = res.data.meetingDates;
                    this.newUsers = res.data.users;
                });
            },
            closeModal() {
                this.$page.props.errors.meeting_date = null;
                this.showModal = false;
                this.showUpdateModal = false;
            },
            openModal(){
                this.showModal = true;
            },
            openUpdateModal(){
                this.showUpdateModal = true;
            },
            showAddAttendanceButton(param){
                this.showButton = param;
            },
            // changeMonth(){
            //     console.log(this.newDate);
            // },
            storeAttendance(param){
                Inertia.post(route("dashboard-store-attendance"), param, {
                    onSuccess: page => {
                        if (Object.entries(page.props.errors).length === 0) {
                            this.newAttendances = page.props.attendances;
                            this.newMeetingDates = page.props.meetingDates;
                            this.newUsers = page.props.users;

                            this.closeModal();
                        }
                    }
                });
            },
            updateAttendance(param){
                Inertia.post(route("dashboard-update-attendance"), param, {
                    onSuccess: page => {
                        if (Object.entries(page.props.errors).length === 0) {
                            this.newAttendances = page.props.attendances;
                            this.closeModal();
                        }
                    }
                });
            },
            deleteAttendance(param){
                this.newMeetingDates = param.meetingDates;
                this.newAttendances = param.attendances;
            },
        },
        // beforeMount() {
        //     console.log('aaa');
        //     console.log(this.attendances);
        // }
    }
</script>

<style  scoped>
    .menu-margin {
        margin-right: 0.75rem;
    }

    @media (max-width: 768px) {
        .menu-margin {
            margin-right: 0;
        }
    }
</style>
<template>
    <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <!-- This element is to trick the browser into centering the modal contents. -->
            <div class="inline-block bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full mt-0"
                role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                <form>
                    <div class="flex justify-between border-b border-gray-100 px-4 pt-4 font-bold">
                        <div>
                            <span class="text-gray-700">Upraviť dochádzku</span>
                        </div>
                    </div>
                    <div class="bg-white px-4 pt-4 pb-4 sm:p-6 sm:pb-4">
                        <div>
                            <div class="mb-3">
                                <label for="meeting_date"
                                    class="block text-gray-700 text-sm font-bold mb-2">Dátum schôdze <span class="text-red-500">*</span></label>
                                <select id="meeting_date" @change="showUsers"
                                    class="mt-1 block form-select w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" required>
                                    <option value="0">Zvoľte dátum</option>
                                    <option v-for="(meetingDate, index) in this.meetingDates" :key="index" :value="meetingDate.id">{{ meetingDate.meeting_date }}</option>
                                </select>
                                <div v-if="$page.props.errors.meeting_date" class="text-red-500">
                                    {{ $page.props.errors.meeting_date }}
                                </div>
                            </div>
                            <div class="mb-3 text-sm" v-if="this.showUsersFlag">
                                <div class="font-bold mb-2">
                                    Dochádzka členov
                                </div>
                            </div>
                            <div class="overflow-y-auto rounded-lg border border-gray-200 shadow-md max-h-96" v-if="this.showUsersFlag">
                                <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
                                    <thead class="bg-gray-300">
                                        <tr>
                                            <th scope="col" class="p-3 font-medium text-gray-900">Meno</th>
                                            <th scope="col" class="p-3 font-medium text-gray-900">Účasť</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                                        <tr class="hover:bg-gray-50" v-for="(attendance, index) in this.newAttendances" :key="index">
                                            <td class="p-2 border-b-2 border-gray-300">
                                                <div class='px-2'>
                                                    {{ attendance.username }}
                                                </div>
                                            </td>
                                            <td class="p-2 border-b-2 border-gray-300">
                                                <select :id="attendance.userId" v-model="attendance[this.meetingDate]" @change="setAttendance"
                                                    class="mt-1 block form-select w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" required>
                                                    <option v-for="(attendanceStatus, index) in this.newAttendanceStatuses" :key="index" :value="attendanceStatus.id">{{ attendanceStatus.attendance_status_title }}</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button @click.prevent="updateAttendance" type="button" v-if="this.showUsersFlag"
                            class="inline-flex justify-center w-full border border-teal-500 bg-teal-500 text-white rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-teal-600 focus:outline-none focus:shadow-outline">Upraviť</button>
                        <button @click.prevent="deleteOrderModal" type="button" v-if="this.showUsersFlag"
                            class="inline-flex justify-center w-full border border-red-500 text-red-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-red-600 focus:outline-none focus:shadow-outline">Zmazať</button>
                        <button @click.prevent="closeModal" type="button"
                            class="inline-flex justify-center w-full border border-gray-200 bg-gray-200 text-gray-700 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-gray-300 focus:outline-none focus:shadow-outline">Zrušiť</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <DeleteModal v-if="this.showDeleteModal" @closeDeleteModal="closeDeleteModal" @deleteObject="deleteObject"/>
</template>

<script>
    import DeleteModal from '@/Modals/DeleteModal.vue';
    import { Inertia } from '@inertiajs/inertia';

    export default {
        name: "AttendanceUpdateModal",
        components: {
            DeleteModal,
        },
        props: {
            attendances: {
                type: Object,
                default: () => { }
            },
            meetingDates: {
                type: Object,
                default: () => { }
            },
            attendanceStatuses: {
                type: Object,
                default: () => { }
            },
        },
        data(){
            return{
                showDeleteModal: false,
                newAttendances: {},
                newAttendanceStatuses: {},
                showUsersFlag: false,
                meetingDate: '',
                meetingId: '',
                attendanceUsers: [],
            }
        },
        emits: {
            closeModal: null,
            updateAttendance: null,
            deleteAttendance: null,
        },
        methods: {
            closeModal() {
                this.$emit('closeModal');
            },
            closeDeleteModal(){
                this.showDeleteModal = false;
            },
            deleteOrderModal(){
                this.showDeleteModal = true;
            },
            deleteObject(){
                var request = {meeting_id: this.meetingId};

                Inertia.post(route("dashboard-delete-attendance"), request, {
                    onSuccess: page => {
                        if (Object.entries(page.props.errors).length === 0) {
                            this.closeDeleteModal()
                            this.closeModal();
                            this.$emit('deleteAttendance', page.props);
                        }
                    }
                });

                Inertia.on("error", event => {
                    event.preventDefault();
                    console.log('error pri deleteAttendance', event.message);
                });
            },
            showUsers(e){
                if(e.target.value == 0){
                    this.showUsersFlag = false;
                }
                else{
                    this.showUsersFlag = true;
                    this.meetingDate = e.target.options[e.target.options.selectedIndex].text;
                    this.meetingId = e.target.value;
                }
            },
            setAttendance(param){
                this.attendanceUsers[param.target.id] = param.target.value;
            },
            updateAttendance(){
                var attendance = [];

                const keys = Object.keys(this.attendanceUsers);
                keys.forEach((key, index) => {
                    var user = {
                        user_id: '',
                        attendance_status_id: '',
                    };
                    user.user_id = key;
                    user.attendance_status_id = this.attendanceUsers[key];
                    attendance.push(user);
                });

                var data = {
                    attendance: attendance, 
                    meeting_id: this.meetingId
                }

                this.$emit('updateAttendance', data);
            }
        },
        beforeMount(){
            this.newAttendances = this.attendances;
            this.newAttendanceStatuses = this.attendanceStatuses;
        }
    };
</script>

<style scoped>

</style>
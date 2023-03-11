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
                    <!-- <input type="hidden" name="id" /> -->
                    <div class="flex justify-between border-b border-gray-100 px-4 pt-4 font-bold">
                        <div>
                            <span class="text-gray-700">Pridať dochádzku</span>
                        </div>
                    </div>
                    <div class="bg-white px-4 pt-4 pb-4 sm:p-6 sm:pb-4">
                        <div>
                            <div class="mb-3">
                                <label for="meeting_date"
                                    class="block text-gray-700 text-sm font-bold mb-2">Dátum stretnutia <span class="text-red-500">*</span></label>
                                <input type="date"
                                    class="shadow appearance-none border rounded w-full mb-2 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="meeting_date" required/>
                                <div v-if="$page.props.errors.meeting_date" class="text-red-500">
                                    {{ $page.props.errors.meeting_date }}
                                </div>
                            </div>
                            <div class="mb-3 text-sm">
                                <div class="font-bold mb-2">
                                    Dochádzka členov
                                </div>
                                <div class="mb-3 text-red-500 text-base" v-if="this.showError">
                                    Je potrebné zvoliť účasť pre každého člena
                                </div>
                            </div>
                            <div class="overflow-y-auto rounded-lg border border-gray-200 shadow-md max-h-96">
                                <table class="w-full border-collapse bg-white text-left text-sm text-gray-500">
                                    <thead class="bg-gray-300">
                                        <tr>
                                            <th scope="col" class="p-3 font-medium text-gray-900">Meno</th>
                                            <th scope="col" class="p-3 font-medium text-gray-900">Účasť</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100 border-t border-gray-100">
                                        <tr class="hover:bg-gray-50" v-for="(user, index) in this.users" :key="index">
                                            <td class="p-2 border-b-2 border-gray-300">
                                                <div class='px-2'>
                                                    {{ user.name }}
                                                </div>
                                            </td>
                                            <td class="p-2 border-b-2 border-gray-300">
                                                <select :id="user.id" @change="setAttendance"
                                                    class="mt-1 block form-select w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" required>
                                                    <option value="0">Zvoľte účasť</option>
                                                    <option v-for="(attendanceStatus, index) in this.attendanceStatuses" :key="index" :value="attendanceStatus.id">{{ attendanceStatus.attendance_status_title }}</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button @click.prevent="storeAttendance()" type="button"
                            class="inline-flex justify-center w-full border border-teal-500 bg-teal-500 text-white rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-teal-600 focus:outline-none focus:shadow-outline">Pridať</button>
                        <!-- <button @click="updateReport(form)" type="button" :class="{ hidden:!updateReportFlag}"
                            class="inline-flex justify-center w-full border border-teal-500 bg-teal-500 text-white rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-teal-600 focus:outline-none focus:shadow-outline">Upraviť</button>
                        <button @click="deleteReport(form)" type="button" :class="{ hidden:!updateReportFlag}"
                            class="inline-flex justify-center w-full border border-red-500 text-red-500 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:text-white hover:bg-red-600 focus:outline-none focus:shadow-outline">Zmazať</button> -->
                        <button @click.prevent="closeModal" type="button"
                            class="inline-flex justify-center w-full border border-gray-200 bg-gray-200 text-gray-700 rounded-md px-4 py-2 m-2 transition duration-500 ease select-none hover:bg-gray-300 focus:outline-none focus:shadow-outline">Zrušiť</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: "AttendanceModal",
    props: {
        users: {
            type: Object,
            default: () => { }
        },
        attendanceStatuses: {
            type: Object,
            default: () => { }
        },
        meetingType: {
            type: Object,
            default: () => { }
        }
    },
    data(){
        return{
            showError: false,
            attendanceUsers: [],
        }
    },
    methods: {
        closeModal() {
            this.$emit('closeModal');
        },
        storeAttendance(){
            var attendanceDate = document.getElementById('meeting_date').value;

            if(Object.keys(this.attendanceUsers).length != Object.keys(this.users).length){
                this.showError = true;
                return false;
            }

            var userAttendances = Object.values(this.attendanceUsers);
            userAttendances.every((val)=>{
                if(val == 0){
                    this.showError = true;
                    return false;
                }
                return true;
            });

            this.showError = false;

            var form = [];
            form['meeting_date'] = attendanceDate;
            form['attendance'] = this.attendanceUsers;
            form['meeting_type_id'] = this.meetingType.meetingTypeId;
            if(this.meetingType.divisionId != 0){
                form['division_id'] = this.meetingType.divisionId;
            }

            this.$emit('storeAttendance', form);
        },
        setAttendance(param){
            var user = {
                user_id: '',
                attendance_status_id: '',
            };

            user.user_id = param.target.id;
            user.attendance_status_id = param.target.value;
            this.attendanceUsers.push(user);
        }
    },
};
</script>

<style scoped>

</style>
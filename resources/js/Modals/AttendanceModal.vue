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
                                    class="select-bordered w-full max-w-xs custom-select shadow appearance-none rounded-md mb-2 py-2 px-3"
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
                            <div class="overflow-y-auto border rounded-lg rounded-lg shadow max-h-96 hidden md:block">
                                <table class="w-full">
                                    <thead class="bg-gray-50 border-b-2 border-gray-200">
                                        <tr>
                                            <th class="p-3 text-sm font-semibold tracking-wide text-left">Meno</th>
                                            <th class="p-3 text-sm font-semibold tracking-wide text-left">Účasť</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        <tr class="bg-white" v-for="(user, index) in this.users" :key="index">
                                            <td class="p-3 text-sm text-gray-700 whitespace-nowrap">
                                                <div class='px-2'>
                                                    {{ user.name }}
                                                </div>
                                            </td>
                                            <td class="p-3 text-sm text-gray-700 whitespace-nowrap">
                                                <select class="select select-bordered w-full max-w-xs custom-select" :id="user.id" @change="setAttendance">
                                                    <option disabled selected value="0">Zvoľte účasť</option>
                                                    <option v-for="(attendanceStatus, index) in this.attendanceStatuses" :key="index" :value="attendanceStatus.id">{{ attendanceStatus.attendance_status_title }}</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="overflow-y-auto max-h-96 md:hidden mb-2 text-sm" v-for="(user, index) in this.users" :key="index">
                                <div class="bg-white rounded-md mb-3">
                                        <div>
                                            {{ user.name }}
                                        </div>
                                    <div>
                                        <select class="select select-bordered w-full max-w-xs custom-select" :id="user.id" @change="setAttendance">
                                            <option disabled selected value="0">Zvoľte účasť</option>
                                            <option v-for="(attendanceStatus, index) in this.attendanceStatuses" :key="index" :value="attendanceStatus.id">{{ attendanceStatus.attendance_status_title }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button @click.prevent="storeAttendance()" type="button"
                            class="inline-flex justify-center w-full rounded-md px-4 py-2 m-2 transition duration-500 ease select-none buttons">Pridať</button>
                        <button @click.prevent="closeModal" type="button"
                            class="inline-flex justify-center w-full rounded-md px-4 py-2 m-2 transition duration-500 ease select-none buttons-gray">Zrušiť</button>
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

            this.showError = false;

            var attendance = [];
            const keys = Object.keys(this.attendanceUsers);
            keys.forEach((key, index) => {
                var user = {
                    user_id: '',
                    attendance_status_id: '',
                };

                if(this.attendanceUsers[key] == 0){
                    this.showError = true;
                }

                user.user_id = key;
                user.attendance_status_id = this.attendanceUsers[key];
                attendance.push(user);
            });

            if(this.showError == true){
                return false;
            }

            var form = {
                meeting_date: attendanceDate,
                meeting_type_id: this.meetingType.meetingTypeId,
                division_id: null,
                attendance: attendance,
            };

            if(this.meetingType.divisionId != 0){
                form.division_id = this.meetingType.divisionId;
            }

            this.$emit('storeAttendance', form);
        },
        setAttendance(param){
            this.attendanceUsers[param.target.id] = param.target.value;
        }
    },
};
</script>

<style scoped>
  .custom-select {
    --tw-ring-color: #454545;
    --tw-ring-shadow: #454545;
  }

  .custom-select:focus {
    --tw-ring-color: #454545;
    --tw-ring-shadow: #454545;
    border-color: var(--sgt-color);
  }
</style>
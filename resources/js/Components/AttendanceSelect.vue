<template>
  <select id="meetingType" style="width: 250px;" @change="changeMeetingType" class="mt-1 block form-select py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" required>
    <option v-for="(meetingType, index) in this.meetingTypes" :key="index" :value="meetingType.id">{{ meetingType.meeting_type_title }}</option> 
  </select>

  <select id="divisionType" v-if="this.divisionSelect" style="width: 300px;" @change="changeDivision" class="mt-1 block form-select py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" required>
    <option value="0">Zvoľte divíziu</option>
    <option v-for="(division, index) in this.divisions" :key="index" :value="division.id">{{ division.division_title }}</option> 
  </select>                       
</template>

<script>
  export default {
    name: 'AttendanceSelect',
    props: {
      meetingTypes: {
        type: Object,
        default: () => { }
      },
      divisions: {
        type: Object,
        default: () => { }
      }
    },
    data(){
      return{
        divisionSelect: false,
        meetingType: {
          meetingTypeId: '',
          divisionId: null,
        },
      }
    },
    emits: {
      getMeetingTypeAttendance: null,
      showAddAttendanceButton: null,
    },
    methods:{
      changeMeetingType(param){
        if(param.target.value == 2){
          this.divisionSelect = true;
          this.meetingType.meetingTypeId = param.target.value;
          this.$emit('showAddAttendanceButton', false);
        }
        else{
          this.meetingType.meetingTypeId = param.target.value;
          this.meetingType.divisionId = null;
          this.$emit('getMeetingTypeAttendance', this.meetingType);
          this.$emit('showAddAttendanceButton', true);
          this.divisionSelect = false;
        }
      },
      changeDivision(param){
        if(param.target.value == 0){
          this.$emit('showAddAttendanceButton', false);
        }
        else{
          this.meetingType.divisionId = param.target.value;
          this.$emit('getMeetingTypeAttendance', this.meetingType);
          this.$emit('showAddAttendanceButton', true);
        }
      }
    }
  }
</script>
  
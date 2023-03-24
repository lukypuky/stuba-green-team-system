<template>
  <div class="mb-1 mr-3">
    <select id="meetingType" @change="changeMeetingType" class="w-64 block form-select py-2 px-3 bg-white rounded-md shadow-sm transition duration-150 ease-in-out leading-6 custom-select" required>
      <option v-for="(meetingType, index) in this.meetingTypes" :key="index" :value="meetingType.id">{{ meetingType.meeting_type_title }}</option> 
    </select>
  </div>

  <div class="mr-3">
    <select id="divisionType" v-if="this.divisionSelect" @change="changeDivision" class="w-64 block form-select py-2 px-3 bg-white rounded-md shadow-sm transition duration-150 ease-in-out leading-6 custom-select" required>
      <option value="0">Zvoľte divíziu</option>
      <option v-for="(division, index) in this.divisions" :key="index" :value="division.id">{{ division.division_title }}</option> 
    </select>  
  </div>
                     
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

<style>
  .custom-select {
    --tw-ring-color: #454545;
    --tw-ring-shadow: #454545;
  }

  option:hover {
    background-color: var(--sgt-color);
  }

  .custom-select:focus {
    --tw-ring-color: #454545;
    --tw-ring-shadow: #454545;
    border-color: var(--sgt-color);
  }
</style>
  
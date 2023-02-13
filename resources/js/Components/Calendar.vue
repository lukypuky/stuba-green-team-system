<script>
import Fullcalendar from '@fullcalendar/vue3'
import daygrid from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'
import timeGrid from '@fullcalendar/timegrid'
import skLocale from '@fullcalendar/core/locales/sk'

export default {
    components: {
        Fullcalendar,
    },
    data() {
        let self = this;
        return {
            calendarOptions: {
                plugins: [daygrid, interactionPlugin, timeGrid],
                initialView: 'timeGridWeek',
                locale: skLocale,
                buttonIcons: false, // show the prev/next text
                navLinks: true, // can click day/week names to navigate views
                height: 700,
                allDaySlot: false,
                headerToolbar: {
                    left: 'dayGridMonth,timeGridWeek,timeGridDay',
                    center: 'title',
                    right: 'prev,next today',
                },
                dateClick: this.handleDateClick,
                eventClick: function(info) {
                    // alert('Event: ' + info.event.title);
                    self.updateEventClick(info.event);
                }
            }
        }
    },
    beforeMount() {
        this.$data.calendarOptions.events = {
            url: route("report.index"),
            method: 'GET',
            failure: error => {
                console.log('pokazilo sa to beforeMount: ', error.message);
            }
        }
    },
    mounted() {
        // window.eventBus.on('refreshCalendar', function () {
        //     this.refreshCalendar();
        // });
    },
    methods: {
        handleDateClick(clickInfo) {
            this.$emit('dateClick', clickInfo);
        },
        updateEventClick(reportInfo){
            this.$emit('reportClick', reportInfo);
        },
        // refreshCalendar() {

        // },
    },
}
</script>

<template>
    <div>
        <Fullcalendar :options="calendarOptions" />
    </div>
</template>

<style>

</style>
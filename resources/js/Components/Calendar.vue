<template>
    <div>
        <Fullcalendar :options="this.calendarOptions" />
    </div>
</template>

<script>
    import Fullcalendar from '@fullcalendar/vue3'
    import daygrid from '@fullcalendar/daygrid'
    import interactionPlugin from '@fullcalendar/interaction'
    import timeGrid from '@fullcalendar/timegrid'
    import skLocale from '@fullcalendar/core/locales/sk'

    export default {
        name: 'Calendar',
        components: {
            Fullcalendar,
        },
        props: {
            reports: {
                type: Object,
                default: () => { }
            },
        },
        data() {
            var self = this;
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
                    },
                    events: this.reports,
                }
            }
        },
        watch: {
            reports: function(newValue, oldValue){
                this.calendarOptions.events = newValue;
            }
        },
        beforeMount() {
            // console.log('aaaaaaaaaaaa');
            // console.log(this.reports);
            // this.calendarOptions.events = this.reports;
            // console.log('xxxxx');
            // console.log(this.reports);
        },
        // created(){
        //     axios.get(route('report.index'))
        //     .then((res) => {
        //         // this.calendarOptions.events = res.data
        //     })
        // },
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

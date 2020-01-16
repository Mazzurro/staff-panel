import Vue from 'vue'
import Router from 'vue-router'
// import Calendar from '@/components/Calendar'
import CalendarTwo from '@/components/CalendarTwo'
import FullCalendar from 'vue-full-calendar'
Vue.use(Router)

export default new Router({
    // mode: 'history',
    routes: [{
            path: '/',
            name: 'hh',
            component: CalendarTwo
        },
        // {
        //   path:'/calendarOne',
        //   name:'CalendarOne',
        //   component:Calendar
        // },
        // {
        //   path:'/calendarTwo',
        //   name:'CalendarTwo',
        //   component:CalendarTwo
        // },
        {
            path: '/full-calendar',
            name: FullCalendar,
            component: FullCalendar
        }
    ]
})
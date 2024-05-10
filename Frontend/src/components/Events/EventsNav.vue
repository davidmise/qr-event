<script setup>
    import Ticketing from '@/components/Events/Ticketing.vue';
    import Payments from '@/components/Events/Payments.vue';
    import Attendance from '@/components/Events/Attendance.vue';
    import BookingSettings from '@/components/Events/BookingSettings.vue';
</script>
<template>
    <div>
        <div class="container">
            <ul class="nav nav-tabs">
              <li class="nav-item">
                <a :class="{ 'nav-link': true, 'active': currentService === 'Ticketing' }" aria-current="page" @click="showService('Ticketing')" > Ticketing </a>
              </li>
              <li class="nav-item">
                <a :class="{ 'nav-link': true, 'active': currentService === 'Payments' }" aria-current="page" @click="showService('Payments')" > Payments </a>
              </li>
              <li class="nav-item">
                <a :class="{ 'nav-link': true, 'active': currentService === 'Attendance' }" aria-current="page" @click="showService('Attendance')" > Attendance </a>
              </li>
              <li class="nav-item">
                <a :class="{ 'nav-link': true, 'active': currentService === 'BookingSettings' }" aria-current="page" @click="showService('BookingSettings')" > Booking Settings</a>
              </li>
            </ul>
          </div>

          <div class="pt-5 ">
            <div v-if="currentService === 'Ticketing' || currentService === null">
                <Ticketing class="slide-left"/>
            </div>
            <div v-else-if="currentService === 'Payments'">
                <Payments class="slide-left"/>
            </div>
            <div v-else-if="currentService === 'Attendance'">
                <Attendance class="slide-left"/>
            </div>
            <div v-else>
                <BookingSettings class="slide-left" :eventId="eventId"/>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props:['eventId'],
    data(){
        return{
            currentService: null
        }
    },
    methods: {
        showService(service){
            this.currentService = service
        }
    },
}
</script>

<style scoped>
.nav-link{
    color: #000;
}
</style>
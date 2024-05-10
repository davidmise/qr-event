<script setup>
import Sidebar from '@/components/Bars/Sidebar/SideBar.vue';
import { sidebarWidth } from '@/components/Bars/Sidebar/state';
import TopBar from '@/components/Bars/TopBar/TopBar.vue';
import EventsNav from '@/components/Events/EventsNav.vue';
import axios from "axios";
</script>
<template>
  <div>
    <Sidebar/>
    <div :style="{ marginLeft: sidebarWidth, transition: 'margin 0.8s' }">
      <TopBar/>
      <main class="py-6 bg-surface-secondary">
        <div class="container-fluid">
          <main class="py-6 bg-surface-secondary">
            <div class="container mb-5" v-if="eventInfo">
              <h1>{{ eventInfo.event_name }}</h1>
              <h6 class="text-secondary">{{ eventInfo.event_subtitle }}</h6>
              <p>Created at <span class="text-primary">{{ eventInfo.start_date }}</span></p>
              <button class="btn btn-outline-primary rounded rounded-5">Valid/Expired</button>
            </div>
            <!-- <hr> -->
            <EventsNav :eventId="eventId"/>
          </main>
        </div>
      </main>
    </div>
  </div>
</template>
<script>
export default {
  props: ['eventId'],
  data() {
    return {
      sidebarWidth,
      eventInfo: null,
    };
  },
  created() {
    const eventId = this.$route.params.eventId;
      this.pullEventInfo(eventId);  
  },
  methods: {
    async pullEventInfo(eventId) {
      try {
        const response = await axios.get(`http://127.0.0.1:8000/api/pull-event-info${eventId}`);
        this.eventInfo = response.data.data;
        console.log(response.data.data);
      } catch (error) {
        console.error('Error fetching event info:', error);
        // Optionally, display an error message to the user
      }
    },
  },
};
</script>

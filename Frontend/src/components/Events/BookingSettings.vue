<template>
    <div>
        <!-- <router-link to="/register-guest" target="_blank"> Invite guest </router-link> -->
        <router-link class="decoration-none" target="_blank"
            :to="{ name: 'register-guest', params: { eventId:eventId  } }">
            Invite guest 
        </router-link>   
    </div>
</template>
<script>
import axios from "axios";
// import useEventStore from '@/stores/eventinfo';
// import { mapState, mapActions } from 'pinia';
export default {
    props: ['eventId'],
  data(){
    return {
        eventInfo:null,
        event_id:null    
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
      console.log("eventInfo", this.eventInfo);
      this.event_id = response.data.data.id;
      console.log("eventInfoID", this.event_id);
    } catch (error) {
      console.error('Error fetching event info:', error);
      // Optionally, display an error message to the user
    }
  },
},

};
</script>
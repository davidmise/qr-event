<!-- eslint-disable vue/multi-word-component-names -->
<template>
    <div class="container mb-5">
      <div class="row">
        <!-- Ticket Info -->
        <div class="col-lg-5 col-md-12 col-sm-12 mb-4">
          <div class="container">
            <h6 class="fw-bold">Ticket Info</h6>
            <!-- Event Price Update -->
            <div class="form-floating input-group mb-3">
              <input v-model="price" type="number" class="form-control" placeholder="Event Price">
              <button @click="updatePrice" class="btn btn-outline-secondary" type="button">Update</button>
              <label>Event Price</label>
            </div>
            <!-- Special Label -->
            <div class="form-floating input-group mb-3">
              <input v-model="event_capacity" type="text" class="form-control" placeholder="Special Label">
              <button @click="updateEventCapacity" class="btn btn-outline-secondary" type="button">Update</button>
              <label>Event Capacity</label>
            </div>
          </div>
        </div>
        <!-- Ticket Preview -->
        <div class="col-lg-7 col-md-12 col-sm-12">
          <div class="card border-0 shadow">
            <div class="card-header border-0 text-center">
              <h6 class="fw-bold">Ticket Preview</h6>
              <TicketPreview :price="price" :event_capacity="event_capacity" />
            </div>
            <div class="card-body p-5"></div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script >
  import TicketPreview from '@/components/Events/TicketPreview.vue';
  import useGeneralStore from '@/stores/general';
  // import useEventStore from '@/stores/event';
  import {  mapState } from 'pinia';
  import axios from 'axios';
import useUserStore from '@/stores/users';
  
  export default {
    props: ['eventId'],
  data (){
    return {
      price: null,
      event_capacity: null,
      ticketId:null,

      // ticketId:null
    }
  },

  components:{
    TicketPreview,
  },

  created() {
    const eventId = this.$route.params.eventId;
    this.pullEventInfo(eventId);
  },

  computed:{
...mapState(useGeneralStore,[
  'API_URL'
]),

...mapState(useUserStore,['token'])
  },
  methods:{
      async updatePrice(){
    try {
      const response = await axios.put(`${this.API_URL}update-ticket/${this.ticketId}`, { price: this.price },
        {
          headers: {
            Authorization: `Bearer ${this.token}`,
          },
        }
      );
      console.log(response.data);
      // Optionally, provide user feedback
    } catch (error) {
      console.error('Error updating ticket price:', error);
      // Optionally, handle error and provide user feedback
    }
  },
  
  async updateEventCapacity(){
    try {
      const response = await axios.put(`${this.API_URL}update-ticket/${this.ticketId}`, 
      { event_capacity: this.eventCapacity },
      {
            headers: {
              Authorization: `Bearer ${this.token}`,
            },
          }
      );
      console.log(response.data);
      // Optionally, provide user feedback
    } catch (error) {
      console.error('Error updating event Capacity:', error);
      // Optionally, handle error and provide user feedback
    }
  },

  async pullEventInfo(eventId) {
      try {
        const response = await axios.get(`${this.API_URL}pull-event-info${eventId}`,
          {
            headers: {
              Authorization: `Bearer ${this.token}`,
            },
          }
        );
        this.eventInfo = response.data.event;
        this.eventName = response.data.event.event_name;
        this.eventSubtitle = response.data.event_subtitle;
        this.eventDate = response.data.event.start_date;
        this.eventStartTime = response.data.event.start_time;
        this.eventEndTime = response.data.event.end_time;
        this.city = response.data.event.location.city;
        this.country = response.data.event.location.country;
        this.street = response.data.event.location.street;
        this.eventPrice = response.data.event.ticket.price;
        this.ticketId = response.data.event.ticket.id;

        console.log(response.data.event);
        console.log('id is:', this.ticketId)
      } catch (error) {
        console.error('Error fetching event info:', error);
        // Optionally, display an error message to the user
      }
    },
  }
  
}
  </script>
  
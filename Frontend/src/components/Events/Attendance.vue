<!-- eslint-disable vue/multi-word-component-names -->
<template>
    <div>
       <h6 class="fw-bold text-secondary"> Attendance </h6>
        <table class="table align-middle mb-0 bg-white">
            <thead class="bg-light">
              <tr>
                <th>Info</th>
                <th>Email</th>
                <th>Created on</th>
                <th>Data Expires</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  <div class="d-flex align-items-center">
                    <img
                        src="https://mdbootstrap.com/img/new/avatars/8.jpg"
                        alt=""
                        style="width: 45px; height: 45px"
                        class="rounded-circle"
                    />
                    <div class="ms-3">
                      <p class="fw-bold mb-1">{{ name }}</p>
                      <p class="text-muted mb-0">{{ phone_number }}</p>
                    </div>
                  </div>
                </td>
                <td>
                  <p class="fw-normal mb-1"> {{ email }}</p>
                  <!-- <p class="text-muted mb-0">IT department</p> -->
                </td>
                <td>
                  <span class="badge badge-success rounded-pill d-inline">Active</span>
                </td>
                <td>{{ attended.data_expires }}</td>
                <td>
                  <button type="button" class="btn btn-outline-primary disabled btn-sm btn-rounded">
                    {{ attended.status }}
                  </button>
                </td>
              </tr>
              <tr v-for="(attended, index) in paginatedAttendance" :key="attended.id">
                <td class="text-heading font-semibold ">
                  {{ (currentPage - 1) * itemsPerPage + index + 1 }}
                </td>
                <td>4</td>
                <td>e</td>
                <td>4</td>
                <td>h</td>
                <td>h</td>
                <!-- <td>{{ attendance.ticket ? event.ticket.price : 'N/A' }}</td>
                <td><img v-if="event.media && event.media.poster" :src="event.media.poster" alt="Poster" style="max-width: 100px;">
                  <span v-else>N/A</span>
                </td> -->
              </tr>
            </tbody>
          </table>
    </div>
</template> 


<script>
// import Sidebar from '@/components/Bars/Sidebar/SideBar.vue'
// import { sidebarWidth } from '@/components/Bars/Sidebar/state';
// import TopBar from '@/components/Bars/TopBar/TopBar.vue';
import axios from "axios";
export default {
  props: ['eventId'],
  components: {
    // Sidebar,
    // TopBar,
  },
  data() {
    return {
      attended: [],
      name:'',
      email: '',
      phone_number:'',
      eventInfo: null,
      // sidebarWidth,
      itemCount: 20,
      currentPage: 1,
      itemsPerPage: 10,
    }
  },
  created() {
    const eventId = this.$route.params.eventId;
    this.fetchEventInfo(eventId);
    // console.log( 'current event id',localStorage.getItem("event_id"))
  },
  methods: {

    async fetchEventInfo(eventId) {
      try {
        const response = await axios.get(`http://127.0.0.1:8000/api/pull-event-info${eventId}`);
        this.eventInfo = response.data.data;
        this.attended = this.eventInfo.attendance;
        this.name = this.attended.guest.name;
        this.email = this.attended.guest.email;
        this.phone_number = this.attended.guest.phone_number;
        

        console.log('attended:', this.name);
        
        console.log(response.data.data);
      } catch (error) {
        console.error('Error fetching event info:', error);
        // Optionally, display an error message to the user
      }
    },
    handlePageChange(page) {
    this.currentPage = page;
  },
  previousPage() {
    if (this.currentPage > 1) {
      this.currentPage--;
    }
  },
  nextPage() {
    if (this.currentPage < this.totalPages) {
      this.currentPage++;
    }
  },
},
computed: {
  paginatedEvents() {
    const startIndex = (this.currentPage - 1) * this.itemsPerPage;
    const endIndex = startIndex + this.itemsPerPage;
    return this.events.slice(startIndex, endIndex);
  },
  formattedEvents() {
    return this.events.map(event => ({
      ...event,
      ticketPrice: event.ticket ? event.ticket.price : 'N/A', // Check for null ticket object
    }));
  },
  totalPages() {
    return Math.ceil(this.events.length / this.itemsPerPage);
  }
}
};
</script>

<style>
  /* Your existing styles */
</style>

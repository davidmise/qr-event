<template>
    <div>
      <Sidebar />
      <div :style="{ marginLeft: sidebarWidth, transition: 'margin 0.8s' }">
        <TopBar />
        <main class="py-6 bg-surface-secondary">
          <div class="container-fluid">
            <p>Events List</p>
            <main class="py-6 bg-surface-secondary">
              <div class="container-fluid">
                <!-- Table -->
                <h2 class="mb-5">All Events</h2>
                <div class="card shadow border-0 mb-7">
                  <div class="card-header">
                    <h5 class="mb-0">Applications</h5>
                  </div>
                  <div class="table-responsive">
                    <table class="table table-hover table-nowrap">
                      <thead class="thead-light">
                        <tr>
                          <th scope="col" class="fw-bold">#</th>
                          <th scope="col" class="fw-bold">Event Name</th>
                          <th scope="col" class="fw-bold">Event Subtitle</th>
                          <th scope="col" class="fw-bold">Start Date</th>
                          <th scope="col" class="fw-bold">Start Time</th>
                          <th scope="col" class="fw-bold">Ticket Price</th>
                          <th scope="col" class="fw-bold">Poster</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(event, index) in paginatedEvents" :key="event.id">
                          <td class="text-heading font-semibold">
                            <router-link :to="{ name: 'viewEvent', params: { eventId: event.id } }">{{ (currentPage - 1) * itemsPerPage + index + 1 }}</router-link>
                          </td>
                          <td>{{ event.event_name }}</td>
                          <td>{{ event.event_subtitle }}</td>
                          <td>{{ event.start_date }}</td>
                          <td>{{ event.start_time }}</td>
                          <td>{{ event.ticket ? event.ticket.price : 'N/A' }}</td>
                          <td><img v-if="event.media && event.media.poster" :src="event.media.poster" alt="Poster" style="max-width: 100px;">
                            <span v-else>N/A</span>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
               <!-- Pagination Component -->
              <Paginate :totalItems="events.length" :itemsPerPage="itemsPerPage" @page-changed="handlePageChange" />
              <div class="mt-3">
                <button class="btn btn-primary me-2" @click="previousPage" :disabled="currentPage === 1">Previous</button>
                <button class="btn btn-primary" @click="nextPage" :disabled="currentPage === totalPages">Next</button>
              </div></div>  
            </main>
          </div>
        </main>
        <RouterView />
      </div>
    </div>
  </template>
  
  <script>
  import Sidebar from '@/components/Bars/Sidebar/SideBar.vue'
  import { sidebarWidth } from '@/components/Bars/Sidebar/state';
  import TopBar from '@/components/Bars/TopBar/TopBar.vue';
  import axios from "axios";
  
  export default {
    components: {
      Sidebar,
      TopBar,
    },
    data() {
      return {
        events: [],
        sidebarWidth,
        itemCount: 20,
        currentPage: 1,
        itemsPerPage: 10,
      }
    },
    created() {
      this.fetchEventInfo();
      console.log( 'current event id',localStorage.getItem("event_id"))
    },
    methods: {
      async fetchEventInfo() {
        try {
          const response = await axios.get('http://127.0.0.1:8000/api/all-events');
          this.events = response.data; 
          console.log( 'events',this.events)
          // console.log( 'event id ', this.event.id)
        } catch (error) {
          console.error('Error fetching Event Info:', error);
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
  
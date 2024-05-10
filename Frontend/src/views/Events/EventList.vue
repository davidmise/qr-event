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
                      <tr v-for="(event, index) in paginatedEvents" :key="event.id" @click="route">
                        <td class="text-heading font-semibold ">
                          <router-link class="decoration-none"
                            :to="{ name: 'viewEvent', params: { eventId: event.id } }">{{ (currentPage - 1) *
      itemsPerPage + index + 1 }}</router-link>
                        </td>
                        <td>{{ event.event_name }}</td>
                        <td>{{ event.event_subtitle }}</td>
                        <td>{{ event.start_date }}</td>
                        <td>{{ event.start_time }}</td>
                        <td>{{ event.ticket ? event.ticket.price : 'N/A' }}</td>
                        <td>
                          <img v-if="event.media && event.media.poster" :src="event.media.poster" alt="Poster"
                            style="max-width: 100px;">
                          <span v-else>N/A</span>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>

              <div class="mt-3">
                <ul class="pagination justify-content-center">
                  <li class="page-item" :class="{ disabled: currentPage === 1 }">
                    <button class="page-link btn btn-outline-success" @click="handlePreviousPage"
                      :disabled="currentPage === 1" style="color:teal">Previous</button>
                  </li>
                  <li class="page-item" v-for="page in lastPage" :key="page"
                    :class="{ active: currentPage === page }">
                    <button class=" btn btn-outline-success border-0" @click="fetchEventInfo(page)">{{ page
                        }}</button>
                  </li>
                  <li class="page-item" :class="{ disabled: currentPage === lastPage }">
                    <button class="page-link btn btn-outline-success" @click="handleNextPage"
                      :disabled="currentPage === lastPage" style="color:teal">Next</button>
                  </li>
                </ul>
              </div>
              
            </div>
          </main>

          <div>
            <h1>WELCOME TO THE HOME PAGE</h1>
            <h2>Price Per Laptop: {{ pricePerEvents }}</h2>
            <h2>Total Laptops: {{ totalEvents }}</h2>
            <h2>Total Laptop Prices: {{ totalEventsPrices }}</h2>
            <button @click="addEvent()">Add Laptop</button>
          </div>

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
// import axios from "axios";

import useEventStore from '@/stores/eventinfo';
import { mapState, mapActions } from 'pinia';

export default {
  components: {
    Sidebar,
    TopBar
  },
  data() {
    return {
      // events: [],
      sidebarWidth,
      // itemCount: 20,
      // currentPage: 1,
      // itemsPerPage: 5,
      // totalItems: 0,
      // nextPageUrl: null, // Store next page URL from backend response (if pro
    }
  },
  created() {
    this.fetchEventInfo(1)
    // console.log(this.totalPages)
    // console.log(this.totalPages)
    // this.$on('paginate', this.handlePagination); // Listen for 'paginate' event
    // console.log('current event id', localStorage.getItem("event_id"))
  },
  methods: {
    // ...

    ...mapActions(useEventStore, [
      'addEvent',
      'fetchEventInfo',
      'handlePageChange',
      'handlePreviousPage',
      'handleNextPage',
      // 'fetchEventsFromUrl'
    ])

  },
  computed: {

    ...mapState(useEventStore, [
      'totalEvents',
      'pricePerEvents',
      'totalEventsPrices',

      'events',
      'data',
      'event',

      'itemCount',
      'currentPage',
      'itemsPerPage',
      'totalItems',
      'totalPages',
      'lastPage',
      'nextPageUrl'
    ]),

    paginatedEvents() {
      if (!this.events.length) return []; // Return empty array if no events yet

      const startIndex = (this.currentPage - 1) * this.itemsPerPage;
      const endIndex = startIndex + this.itemsPerPage;
      // console.log(this.currentPage)
      return this.events.slice(startIndex, endIndex);
    },

    formattedEvents() {
      return this.events.map(event => ({
        ...event,
        ticketPrice: event.ticket ? event.ticket.price : 'N/A',
      }));
    },
    totalPages() {
      // Assuming total is provided by the backend (refer to backend changes)
      const totalPages = Math.ceil(this.totalItems / this.itemsPerPage);
      console.log("Total pages: ", totalPages);
      return totalPages;
    }
  },
  mounted() {
    this.fetchEventInfo(1)
  }
};
</script>
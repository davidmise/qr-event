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
                      <tr
                        v-for="(event, index) in events"
                        :key="event.id"
                        @click="route(event.id)"
                      >
                        <td class="text-heading font-semibold">
                          {{ (currentPage - 1) * itemsPerPage + index + 1 }}
                        </td>
                        <td>{{ event.event_name }}</td>
                        <td>{{ event.event_subtitle }}</td>
                        <td>{{ event.start_date }}</td>
                        <td>{{ event.start_time }}</td>
                        <td>{{ event.ticket ? event.ticket.price : 'N/A' }}</td>
                        <td>
                          <img
                            v-if="event.media && event.media.poster"
                            :src="event.media.poster"
                            alt="Poster"
                            style="max-width: 100px"
                          />
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
                    <button
                      class="page-link btn btn-outline-success"
                      @click="handlePreviousPage"
                      :disabled="currentPage === 1"
                      style="color: teal"
                    >
                      Previous
                    </button>
                  </li>
                  <li
                    class="page-item"
                    v-for="page in lastPage"
                    :key="page"
                    :class="{ active: currentPage === page }"
                  >
                    <button class="btn btn-outline-success border-0" @click="fetchEventInfo(page)">
                      {{ page }}
                    </button>
                  </li>
                  <li class="page-item" :class="{ disabled: currentPage === lastPage }">
                    <button
                      class="page-link btn btn-outline-success"
                      @click="handleNextPage"
                      :disabled="currentPage === lastPage"
                      style="color: teal"
                    >
                      Next
                    </button>
                  </li>
                </ul>
              </div>
            </div>
          </main>
        </div>
      </main>
      <RouterView />
    </div>
  </div>
</template>
<script>
import Sidebar from '@/components/Bars/Sidebar/SideBar.vue'
import { sidebarWidth } from '@/components/Bars/Sidebar/state'
import TopBar from '@/components/Bars/TopBar/TopBar.vue'
import axios from 'axios'

import useEventStore from '@/stores/eventinfo'
import useGeneralStore from '@/stores/general'
import useUserStore from '@/stores/users'
import { mapState, mapActions } from 'pinia'

export default {
  components: {
    Sidebar,
    TopBar
  },
  data() {
    return {
      sidebarWidth,
      data: {},
      events: [],
      event: null,
      currentPage: 1,
      itemsPerPage: 10,
      lastPage: null
    }
  },
  created() {
    this.fetchEventInfo(1)
  },

  computed: {
    ...mapState(useGeneralStore, ['API_URL']),
    ...mapState(useUserStore, ['token']),
    ...mapState(useEventStore, ['event']),

    paginatedEvents() {
      if (!this.events.length) return []
      const startIndex = (this.currentPage - 1) * this.itemsPerPage
      const endIndex = startIndex + this.itemsPerPage
      return this.events.slice(startIndex, endIndex)
    }
  },
  methods: {
    ...mapActions(useEventStore, ['storeEvent']),

    async fetchEventInfo(index) {
      this.currentPage = index
      try {
        const response = await axios.get(`${this.API_URL}all-events?page=` + this.currentPage, {
          headers: {
            Authorization: `Bearer ${this.token}`
          }
        })
        this.data = response.data
        this.events = this.data.data
        this.lastPage = response.data.last_page
      } catch (error) {
        console.error('Error fetching Event Info:', error)
      }
    },

    handlePreviousPage() {
      if (this.currentPage > 1) {
        this.currentPage--
        this.fetchEventInfo(this.currentPage)
      }
    },

    handleNextPage() {
      if (this.currentPage < this.data.last_page) {
        this.currentPage++
        this.fetchEventInfo(this.currentPage)
      }
    },

    route(eventId) {
      this.$router.push({ name: 'hostviewEvent', params: { eventId: eventId } })
    }
  },

  mounted() {
    this.fetchEventInfo(1)
  }
}
</script>

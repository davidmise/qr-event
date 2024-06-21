<template>
  <div>
    <TopNav />
    <!-- Main -->
    <main class="bg-surface-secondary">
      <div class="container-fluid">
        <!-- Card stats -->

        <!-- Card 1 - Bootstrap Brain Component -->
        <section class="py-3 py-md-5">
          <div class="container">
            <div class="row justify-content-center">
              <div class="col-12 col-lg-10 col-xl-8 col-xxl-7">
                <div class="row gy-4">
                  <div class="col-12 col-sm-6" v-for="(event, index) in events" :key="event.id">
                    <div
                      class="card widget-card border-light shadow-sm"
                      style="cursor: pointer"
                      @click="route(event.id, event.event_name)"
                    >
                      <div class="card-body p-4">
                        <div class="row">
                          <div class="col-8">
                            <h5 class="card-title widget-card-title mb-3">
                              {{ event.event_name }}
                            </h5>
                            <h4 class="card-subtitle text-body-secondary m-0">
                              {{ event.start_date }} @
                              <span class="text-success">{{ event.start_time }}</span>
                            </h4>
                          </div>
                          <div class="col-4">
                            <div class="d-flex justify-content-end">
                              <div
                                class="lh-1 text-white bg-info rounded-pill p-3 d-flex align-items-center justify-content-center"
                              >
                                <!-- <i class="bi bi-truck fs-4"></i> -->
                                <span class="text-heading font-semibold text-white">
                                  {{ (currentPage - 1) * itemsPerPage + index + 1 }}
                                </span>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-12">
                            <div class="d-flex align-items-center mt-3">
                              <span
                                class="lh-1 me-3 bg-danger-subtle text-danger rounded-circle p-1 d-flex align-items-center justify-content-center"
                              >
                                <i class="bi bi-arrow-right-short bsb-rotate-45"></i>
                              </span>
                              <div>
                                <p class="fs-7 mb-0">registerted</p>
                                <p class="fs-7 mb-0 text-secondary">attendade</p>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Loader Component -->
                <Loader v-if="isLoading" />
              </div>
            </div>
          </div>
        </section>

        <!-- Pagination controls -->
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

        <!-- Items showing -->
        <div class="pagination justify-content-center card-footer border-0 py-5">
          <span class="text-muted text-sm">
            Showing {{ currentItems }} items out of {{ total }} results found
          </span>
        </div>
      </div>
    </main>
  </div>
</template>

<script>
import axios from 'axios'
import Swal from 'sweetalert2'
import TopNav from '@/components/doorman/TopNav.vue'
import Loader from '@/components/CssLoader.vue'
import useUserStore from '@/stores/users' // Ensure this path is correct
import useEventStore from '@/stores/eventinfo' // Ensure this path is correct
import useGeneralStore from '@/stores/general'
import { mapActions, mapState } from 'pinia'

export default {
  data() {
    return {
      data: {},
      events: [],
      event: null,
      currentPage: 1,
      itemsPerPage: 10,
      lastPage: null,
      message: null,
      searchQuery: '',
      searchedData: '',
      currentItems: 0,
      total: 0,
      isLoading: false
    }
  },
  setup() {
    const eventStore = useEventStore()
    eventStore.fetchEvents()
  },

  created() {
    this.fetchEventInfo(1)
  },
  computed: {
    ...mapState(useGeneralStore, ['API_URL']),
    ...mapState(useUserStore, ['token']),
    ...mapState(useEventStore, ['totalEvents']),

    paginatedEvents() {
      if (!this.events.length) return []
      const startIndex = (this.currentPage - 1) * this.itemsPerPage
      const endIndex = startIndex + this.itemsPerPage
      return this.events.slice(startIndex, endIndex)
    }
  },
  components: {
    TopNav,
    Loader
  },
  methods: {
    ...mapActions(useEventStore, ['fetchEvents']),

    async fetchEventInfo(page) {
      this.isLoading = true
      this.currentPage = page
      try {
        const response = await axios.get(`${this.API_URL}all-events?page=${this.currentPage}`, {
          headers: {
            Authorization: `Bearer ${this.token}`
          }
        })
        this.data = response.data
        this.events = this.data.data
        this.lastPage = this.data.last_page
        this.currentItems = response.data.to - response.data.from + 1
        this.total = response.data.total
      } catch (error) {
        console.error('Error fetching Event Info:', error)
        this.message = error.response.statusText
        this.handelErrorToast()
      } finally {
        this.isLoading = false
      }
    },
    handlePreviousPage() {
      if (this.currentPage > 1) {
        this.currentPage--
        this.fetchEventInfo(this.currentPage, this.searchQuery)
      }
    },
    handleNextPage() {
      if (this.currentPage < this.lastPage) {
        this.currentPage++
        this.fetchEventInfo(this.currentPage, this.searchQuery)
      }
    },

    route(eventId, eventName) {
      this.$router.push({
        name: 'doormanEventView',
        params: { eventId: eventId, eventName: eventName }
      })
    },

    handelErrorToast() {
      Swal.fire({
        icon: 'error',
        title: 'An error has occurred',
        text: this.message
      })
    }
  },
  mounted() {
    this.fetchEventInfo(1)
  }
}
</script>

<style scoped>
/* Add scoped styles here */
.card {
  transition: transform 0.2s ease;
}

.card:hover {
  transform: translateY(-5px); /* Example: Lift card on hover */
}
</style>

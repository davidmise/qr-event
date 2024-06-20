<template>
  <div>
    <TopNav />
    <!-- Main content -->

    <!-- Card 2 - Bootstrap Brain Component -->
    <section class="py-3 py-md-5">
      <div class="container">
        <div class="row justify-content-center">
          <span class="h3"> {{ eventName }} </span> <QrCode></QrCode>
          <div class="col-12 col-sm-10 col-md-7 col-lg-6 col-xl-5 col-xxl-4">
            <div class="card widget-card border-light shadow-sm">
              <div class="card-body p-4">
                <h5 class="card-title widget-card-title mb-4">Guests Overview</h5>
                <div class="row gy-4">
                  <div class="col-12" v-for="(guest, index) in guests" :key="guest.id">
                    <div class="row align-items-center">
                      <div class="col-8">
                        <div class="d-flex align-items-center">
                          <div>
                            <div
                              class="fs-5 bsb-w-50 bsb-h-50 bg-primary-subtle text-primary rounded-pill d-flex align-items-center justify-content-center me-4 p-2"
                            >
                              <!-- <i class="bi bi-paypal"></i> -->
                              <span class="text-heading font-semibold">
                                {{ (currentPage - 1) * itemsPerPage + index + 1 }}
                              </span>
                            </div>
                          </div>
                          <div>
                            <h6 class="m-0">{{ guest.name }}</h6>
                            <p class="text-secondary m-0 fs-7">
                              contacts: {{ guest.phone_number }}
                            </p>
                            <p class="text-secondary m-0 fs-7">date and time</p>
                          </div>
                        </div>
                      </div>
                      <div class="col-4">
                        <h6 class="text-end">{{ guest.status }}</h6>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
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
          <button class="btn btn-outline-success border-0" @click="fetchGuestListInfo(page)">
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
</template>

<script>
import axios from 'axios'
import Swal from 'sweetalert2'
import QrCode from '@/components/doorman/QrScanner.vue'
import TopNav from '@/components/doorman/TopNav.vue'
import useUserStore from '@/stores/users' // Ensure this path is correct
import useGuestStore from '@/stores/guests' // Ensure this path is correct
import useGeneralStore from '@/stores/general'
import { mapActions, mapState } from 'pinia'

export default {
  data() {
    return {
      data: {},
      guests: [],
      guest: null,
      currentPage: 1,
      itemsPerPage: 10,
      currentItems: 0,
      total: 0,
      lastPage: null,
      searchQuery: '',
      searchedData: '',
      eventName: null,
      eventId: null
      // eventName:''
    }
  },
  created() {
    // Fetch initial guest list and set eventName and eventId from route params
    this.eventId = this.$route.params.eventId
    this.eventName = this.$route.params.eventName
    console.log(this.eventName, this.eventId)
    this.fetchGuestListInfo(1)
  },
  computed: {
    ...mapState(useGeneralStore, ['API_URL']),
    ...mapState(useUserStore, ['token']),
    paginatedGuests() {
      if (!this.guests.length) return []
      const startIndex = (this.currentPage - 1) * this.itemsPerPage
      const endIndex = startIndex + this.itemsPerPage
      return this.guests.slice(startIndex, endIndex)
    }
  },
  components: {
    TopNav,
    QrCode
  },
  methods: {
    ...mapActions(useGuestStore, ['fetchGuests']),

    async fetchGuestListInfo(page) {
      this.currentPage = page
      try {
        const response = await axios.get(
          `${this.API_URL}events/${this.eventId}/guests?page=` + this.currentPage,
          {
            headers: {
              Authorization: `Bearer ${this.token}`
            }
          }
        )
        this.data = response.data
        this.eventName = this.data.event_name
        this.guests = this.data.guests.data
        console.log(this.data)
        this.total = response.data.guests.total
        this.currentItems = response.data.guests.to - response.data.guests.from + 1
        this.lastPage = response.data.guests.last_page
      } catch (error) {
        console.error('Error fetching Guest Info:', error)
        Swal.fire({
          icon: 'error',
          title: 'An error has occurred',
          text: error.message
        })
      }
    },
    handlePreviousPage() {
      if (this.currentPage > 1) {
        this.currentPage--
        this.fetchGuestListInfo(this.currentPage)
      }
    },
    handleNextPage() {
      if (this.currentPage < this.lastPage) {
        this.currentPage++
        this.fetchGuestListInfo(this.currentPage)
      }
    }
    //   route(guestId) {
    //     this.$router.push({ name: 'guestView', params: { guestId } })
    //   }
  },
  mounted() {
    this.fetchGuestListInfo(1)
  }
}
</script>

<style scoped>
.shadow-blue {
  box-shadow: 0 0 20px rgba(0, 0, 255, 0.2); /* Blue shadow effect */
}
</style>

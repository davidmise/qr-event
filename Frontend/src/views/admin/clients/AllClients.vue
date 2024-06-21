<template>
  <div>
    <Sidebar />
    <div :style="{ marginLeft: sidebarWidth, transition: 'margin 0.8s' }">
      <TopBar />
      <main class="py-6 bg-surface-secondary">
        <div class="container-fluid">
          <p>Client List</p>
          <main class="py-6 bg-surface-secondary">
            <div class="container-fluid">
              <h2 class="mb-5">All Clients</h2>
              <!-- searchbar -->
              <div class="form-floating mb-3">
                <input
                  type="search"
                  class="form-control"
                  id="datatable-search-input"
                  v-model="searchQuery"
                  @input="searchData"
                />
                <label for="datatable-search-input">Search</label>
                <!-- <button class="btn btn-outline-success" type="submit">Search</button> -->
              </div>
              <div class="card shadow border-0 mb-7">
                <div class="card-header">
                  <h5 class="mb-0">Applications</h5>
                </div>
                <div class="table-responsive">
                  <table class="table table-hover table-nowrap">
                    <thead class="thead-light">
                      <tr>
                        <th scope="col" class="fw-bold">#</th>
                        <th scope="col" class="fw-bold">Name</th>
                        <th scope="col" class="fw-bold">Email</th>
                        <th scope="col" class="fw-bold">Phone</th>
                        <th scope="col" class="fw-bold">Event Type</th>
                        <th scope="col" class="fw-bold">Event Capacity</th>
                        <th scope="col" class="fw-bold">Cost</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr
                        v-for="(client, index) in clients"
                        :key="client.id"
                        @click="route(client.id)"
                      >
                        <td class="text-heading font-semibold">
                          {{ (currentPage - 1) * itemsPerPage + index + 1 }}
                        </td>
                        <td>{{ client.name }}</td>
                        <td>{{ client.email }}</td>
                        <td>{{ client.phone }}</td>
                        <td>{{ client.event_type }}</td>
                        <td>{{ client.event_capacity }}</td>
                        <td>{{ client.cost }}</td>
                      </tr>
                    </tbody>
                  </table>
                  <!-- Loader Component -->
                  <Loader v-if="isLoading" />
                </div>
              </div>

              <!-- not found message -->
              <div class="container">
                <div class="row">
                  <div class="col-12 d-flex justify-content-center align-items-center mt-4">
                    <div
                      v-show="searchQuery !== '' && clients.length == 0"
                      class="not-found-message text-center"
                    >
                      <span class="icon">
                        <svg
                          style="color: red"
                          xmlns="http://www.w3.org/2000/svg"
                          width="16"
                          height="16"
                          fill="currentColor"
                          class="bi bi-info-circle"
                          viewBox="0 0 16 16"
                        >
                          <path
                            d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"
                          />
                          <path
                            d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"
                          />
                        </svg>
                      </span>
                      <span class="message">
                        The search key does not match any data from the Database
                      </span>
                    </div>
                  </div>
                </div>
              </div>

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
                    <button class="btn btn-outline-success border-0" @click="fetchClientInfo(page)">
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
import Loader from '@/components/CssLoader.vue'
import Swal from 'sweetalert2'
import useEventStore from '@/stores/eventinfo'
import useGeneralStore from '@/stores/general'
import useUserStore from '@/stores/users'
import { mapState, mapActions } from 'pinia'

export default {
  components: {
    Sidebar,
    TopBar,
    Loader
  },
  data() {
    return {
      sidebarWidth,
      data: {},
      clients: [],
      client: null,
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
  created() {
    this.fetchClientInfo(1)
  },

  computed: {
    ...mapState(useGeneralStore, ['API_URL']),
    ...mapState(useUserStore, ['token']),
    ...mapState(useEventStore, ['event']),

    paginatedClients() {
      if (!this.clients.length) return []
      const startIndex = (this.currentPage - 1) * this.itemsPerPage
      const endIndex = startIndex + this.itemsPerPage
      return this.clients.slice(startIndex, endIndex)
    }
  },
  methods: {
    ...mapActions(useEventStore, ['storeEvent']),

    searchData() {
      this.isLoading = true
      console.log(this.searchQuery)

      axios
        .get(`${this.API_URL}search-client`, {
          headers: {
            Authorization: `Bearer ${this.token}`
          },
          params: { search_term: this.searchQuery }
        })
        .then((response) => {
          this.data = response.data
          this.clients = response.data.client.data
          console.log(this.data)
        })

        .catch((error) => {
          console.log('error searching client', error)
          this.isLoading = false
          this.message = error.message
          // this.handelErrorToast()
        })
        .then(() => {
          // _this.submitting = false
          this.isLoading = false
        })
    },

    async fetchClientInfo(page) {
      this.isLoading = true
      this.currentPage = page
      try {
        const response = await axios.get(`${this.API_URL}all-clients?page=${this.currentPage}`, {
          headers: {
            Authorization: `Bearer ${this.token}`
          }
        })
        this.data = response.data
        this.clients = this.data.data
        this.lastPage = response.data.last_page
        this.total = response.data.total
        console.log(this.data)
        this.currentItems = response.data.to - response.data.from + 1
      } catch (error) {
        console.error('Error fetching Client Info:', error)
        this.isLoading = false // Set loading state to false after failed fetch
        this.message = error.response.statusText

        this.handelErrorToast()
      } finally {
        this.isLoading = false
      }
    },

    handlePreviousPage() {
      if (this.currentPage > 1) {
        this.fetchClientInfo(this.currentPage - 1)
      }
    },

    handleNextPage() {
      if (this.currentPage < this.lastPage) {
        this.fetchClientInfo(this.currentPage + 1)
      }
    },

    route(clientId) {
      this.$router.push({ name: 'adminDashboard', params: { clientId: clientId } })
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
    this.fetchClientInfo(1)
  }
}
</script>

<template>
  <div>
    <Sidebar />
    <div :style="{ marginLeft: sidebarWidth, transition: 'margin 0.8s' }">
      <TopBar />
      <main class="py-6 bg-surface-secondary">
        <div class="container-fluid">
          <h2 class="mb-5">All Guests</h2>
          <button @click="googleSheet" class="btn btn-primary mb-3">Refresh Guest List</button>
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
              <h5 class="mb-0">Guests</h5>
            </div>
            <div class="table-responsive">
              <table class="table table-hover table-nowrap">
                <thead class="thead-light">
                  <tr>
                    <th scope="col" class="fw-bold">#</th>
                    <th scope="col" class="fw-bold">Name</th>
                    <th scope="col" class="fw-bold">Email</th>
                    <th scope="col" class="fw-bold">Phone</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(guest, index) in guests" :key="guest.id" @click="route(guest.id)">
                    <td class="text-heading font-semibold">
                      {{ (currentPage - 1) * itemsPerPage + index + 1 }}
                    </td>
                    <td class="text-heading font-semibold">{{ guest.name }}</td>
                    <td>{{ guest.email }}</td>
                    <td>{{ guest.phone_number }}</td>
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
                  v-show="searchQuery !== '' && guests.length == 0"
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
import useGeneralStore from '@/stores/general'
import useUserStore from '@/stores/users'
import { mapState } from 'pinia'
import Loader from '@/components/CssLoader.vue'

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
      guests: [],
      guest: null,
      currentPage: 1,
      itemsPerPage: 10,
      currentItems: 0,
      total: 0,
      lastPage: null,
      earchQuery: '',
      searchedData: '',
      isLoading: false
    }
  },
  created() {
    this.fetchGuestListInfo(1), this.googleSheet()
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
  methods: {
    searchData() {
      this.isLoading = true
      console.log(this.searchQuery)

      axios
        .get(`${this.API_URL}search-guest`, {
          headers: {
            Authorization: `Bearer ${this.token}`
          },
          params: { search_term: this.searchQuery }
        })
        .then((response) => {
          this.guests = response.data.guest.data

          console.log(this.guests)
        })

        .catch((error) => {
          console.log('error searching events', error)
          this.isLoading = false
          this.message = error.response.statusText
          this.handelErrorToast()
        })
        .then(() => {
          // _this.submitting = false
          this.isLoading = false
        })
    },
    async fetchGuestListInfo(index) {
      this.isLoading = true
      this.currentPage = index
      try {
        const response = await axios.get(`${this.API_URL}guest-list?page=` + this.currentPage, {
          headers: {
            Authorization: `Bearer ${this.token}`
          }
        })
        this.data = response.data
        this.guests = this.data.data

        this.total = response.data.total
        console.log(this.total)

        console.log(this.data)
        this.currentItems = response.data.to - response.data.from + 1

        this.lastPage = response.data.last_page
      } catch (error) {
        this.isLoading = false
        console.error('Error fetching Guest Info:', error)
      } finally {
        this.isLoading = false
      }
    },

    async googleSheet() {
      this.isLoading = true
      try {
        const response = await axios.get(`${this.API_URL}google-sheets`, {
          headers: {
            Authorization: `Bearer ${this.token}`
          }
        })
        this.data = response.data
        //   this.googleSheets = JSON.parse(JSON.stringify(this.data))
        //   console.log(this.googleSheets)
      } catch (error) {
        this.isLoading = false
        console.error('Error fetching Guest Info:', error)
      } finally {
        this.isLoading = false
      }
    },

    handlePreviousPage() {
      if (this.currentPage > 1) {
        this.currentPage--
        this.fetchGuestListInfo(this.currentPage)
      }
    },

    handleNextPage() {
      if (this.currentPage < this.data.last_page) {
        this.currentPage++
        this.fetchGuestListInfo(this.currentPage)
      }
    }

    //   route(guestId) {
    //     this.$router.push({ name: 'viewGuest', params: { guestId: guestId } })
    //   }
  },

  mounted() {
    this.fetchGuestListInfo(1)
  }
}
</script>

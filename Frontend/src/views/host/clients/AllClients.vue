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
                    <tbody v-if="hasData">
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

import Swal from 'sweetalert2'
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
      isLoading:true,
      data: {},
      clients: [],
      client: null,
      currentPage: 1,
      itemsPerPage: 10,
      lastPage: null,
      message: null,
        searchQuery: '',
        searchedData:''
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
      // if (!this.clients.length) return []
      const startIndex = (this.currentPage - 1) * this.itemsPerPage
      const endIndex = startIndex + this.itemsPerPage
      return this.clients.slice(startIndex, endIndex)
    },
    hasData() {
    return this.clients.length > 0
  }
  },
  methods: {
    ...mapActions(useEventStore, ['storeEvent']),

    searchData(){
            console.log(this.searchQuery);
            
            axios.get(`${this.API_URL}search-client`, { 
            headers: {
              Authorization: `Bearer ${this.token}`
            },
            params: { search_term: this.searchQuery} })
           .then(response =>{
                this.data = response.data;
                this.clients = response.data.client.data;
                console.log(this.data)
            })

            .catch(error=>{
            console.log("error searching client", error)
            this.isLoading = false
          this.message = error.message;
          this.handelErrorToast()
            });
        },

    async fetchClientInfo(page) {
      this.currentPage = page
      this.isLoading = true // Set loading state to true
      try {
        const response = await axios.get(`${this.API_URL}all-clients?page=${this.currentPage}`, {
          headers: {
            Authorization: `Bearer ${this.token}`
          }
        })
        this.data = response.data
        this.clients = this.data.data
        this.updateClients() // Call updateClients after data is received
        this.lastPage = response.data.last_page
        this.isLoading = false // Set loading state to false after successful fetch
        console.log(this.data)
      } catch (error) {
        console.error('Error fetching Client Info:', error)
        this.isLoading = false // Set loading state to false after failed fetch
        this.message = error.response.statusText

        this.handelErrorToast()
      }
    },


    handlePreviousPage() {
      if (this.currentPage > 1) {
        this.fetchClientInfo(this.currentPage - 1)
      }
    },

    handleNextPage() {
      if (this.currentPage < this.lastPage) {
        this.currentPage++;
        this.fetchClientInfo(this.currentPage)
      }
    },
    updateClients() {
      this.$forceUpdate() // Force re-render
      console.log('update successfully')
},
    changePage(page) {
      this.currentPage = page
      this.fetchClientInfo(this.currentPage)
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
    },
  },

  mounted() {
    this.fetchClientInfo(1)
  }
}

</script>

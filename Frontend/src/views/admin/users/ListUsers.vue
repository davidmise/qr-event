<template>
    <div>
      <Sidebar />
      <div :style="{ marginLeft: sidebarWidth, transition: 'margin 0.8s' }">
        <TopBar />
        <main class="py-6 bg-surface-secondary">
          <div class="container-fluid">
            <main class="py-6 bg-surface-secondary">
              <div class="container-fluid">
                <h2 class="mb-5">All Users</h2>
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
                          <th scope="col" class="fw-bold">Username</th>
                          <th scope="col" class="fw-bold">Email</th>
                          <th scope="col" class="fw-bold">Role</th>
                          <th scope="col" class="fw-bold">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr
                          v-for="(user, index) in users"
                          :key="user.id"
                          @click="route(user.id)"
                        >
                          <td class="text-heading font-semibold">
                            {{ (currentPage - 1) * itemsPerPage + index + 1 }}
                          </td>
                          <td>{{ user.name }}</td>
                          <td>{{ user.username }}</td>
                          <td>{{ user.email }}</td>
                          <td>{{ user.role }}</td>
                          <td>
                            <button @click="route(user.id)" class="btn btn-primary">View</button>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>

              <!-- not found message -->
              <div class="container">
                <div class="row">
                  <div class="col-12 d-flex justify-content-center align-items-center mt-4">
                    <div v-show= "searchQuery !== '' && users.length == 0" class="not-found-message text-center">
                      <span class="icon">
                        <svg style="color: red" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                        </svg>
                      </span>
                      <span class="message">
                        The search key does not match any data from the Database
                      </span>
                     
                    </div>
                  </div>
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
                      <button class="btn btn-outline-success border-0" @click="fetchUserInfo(page)">
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
  import { sidebarWidth } from '@/components/Bars/Sidebar/state.js'
  import TopBar from '@/components/Bars/TopBar/TopBar.vue'
  import axios from 'axios'
  import Swal from 'sweetalert2'
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
        users: [],
        user: null,
        currentPage: 1,
        itemsPerPage: 10,
        totalUsers:null,
        lastPage: null,
        message: null,
        searchQuery: '',
        searchedData:''
      }
    },
    created() {
      this.fetchUserInfo(1)
    },
    computed: {
      ...mapState(useGeneralStore, ['API_URL']),
      ...mapState(useUserStore, ['token', 'user']),
      paginatedUsers() {
        if (!this.users.length) return []
        const startIndex = (this.currentPage - 1) * this.itemsPerPage
        const endIndex = startIndex + this.itemsPerPage
        return this.users.slice(startIndex, endIndex)
      }
    },
    methods: {
      ...mapActions(useUserStore, ['storeLoggedInUser']),
      searchData(){
            console.log(this.searchQuery);
            
            axios.get(`${this.API_URL}search-user`, { 
            headers: {
              Authorization: `Bearer ${this.token}`
            },
            params: { search_term: this.searchQuery} })
           .then(response =>{
                this.data = response.data;
                this.users = response.data.users.data;
                console.log(this.data)
            })

            .catch(error=>{
            console.log("error searching user", error)
            this.isLoading = false
          this.message = error.response.statusText
          // this.handelErrorToast()
            });
        },
      async fetchUserInfo(page) {
        this.currentPage = page
        try {
          const response = await axios.get(`${this.API_URL}users?page=${this.currentPage}`, {
            headers: {
              Authorization: `Bearer ${this.token}`
            }
          })
          this.data = response.data
          this.users = this.data.data
          this.lastPage = this.data.last_page
          this.totalUsers = this.data.total
        // //   console.log(this.totalUsers)
        // localStorage.setItem('totalUsers', this.totalUsers)
        //   console.log('total:' + localStorage.getItem('totalUsers'))

        } catch (error) {
          console.error('Error fetching user info:', error)
          this.isLoading = false
          this.message = error.response.statusText
          this.handelErrorToast()
        }
      },
      handlePreviousPage() {
        if (this.currentPage > 1) {
          this.currentPage--
          this.fetchUserInfo(this.currentPage, this.searchQuery)
        }
      },
      handleNextPage() {
        if (this.currentPage < this.lastPage) {
          this.currentPage++
          this.fetchUserInfo(this.currentPage, this.searchQuery)
        }
      },
      searchUsers() {
        this.fetchUserInfo(1, this.searchQuery)
      },
      route(userId) {
        this.$router.push({ name: 'adminViewUser', params: { userId } })
      },
      handelErrorToast() {
        Swal.fire({
          icon: 'error',
          title: 'An error has occurred',
          text: this.message
        })
      },
    }
  }
  </script>
  
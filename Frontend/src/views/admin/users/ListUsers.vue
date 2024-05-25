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
                        <!-- <th scope="col" class="fw-bold">Phone</th> -->
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
                        <!-- <td>{{ user.phone }}</td> -->
                        <td>{{ user.role }}</td>
                        <td>
                          <button @click="route(user.id)" class="btn btn-primary">View</button>
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
      lastPage: null
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
    async fetchUserInfo(index) {
      this.currentPage = index
      try {
        const response = await axios.get(`${this.API_URL}users?page=${this.currentPage}`, {
          headers: {
            Authorization: `Bearer ${this.token}`
          }
        })
        this.data = response.data
        this.users = this.data.data
        this.lastPage = this.data.last_page
      } catch (error) {
        console.error('Error fetching user info:', error)
      }
    },
    handlePreviousPage() {
      if (this.currentPage > 1) {
        this.currentPage--
        this.fetchUserInfo(this.currentPage)
      }
    },
    handleNextPage() {
      if (this.currentPage < this.lastPage) {
        this.currentPage++
        this.fetchUserInfo(this.currentPage)
      }
    },
    route(userId) {
      this.$router.push({ name: 'adminViewUser', params: { userId } })
    }
  }
}
</script>

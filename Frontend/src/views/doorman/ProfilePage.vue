<template>
  <div>
    <TopNav />
    <main class="p-6 bg-surface-secondary">
      <div class="container-fluid p-0">
        <h1 class="h3 mb-3"><strong> Doorman</strong> Profile</h1>

        <section>
          <div class="container py-5">
            <div class="row">
              <div class="col-lg-8">
                <div class="card mb-4" v-if="userInfo">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-sm-3">
                        <p class="mb-0">Full Name</p>
                      </div>
                      <div class="col-sm-9">
                        <p class="text-muted mb-0">{{ userInfo.name }}</p>
                      </div>
                    </div>
                    <hr />
                    <div class="row">
                      <div class="col-sm-3">
                        <p class="mb-0">Email</p>
                      </div>
                      <div class="col-sm-9">
                        <p class="text-muted mb-0">{{ userInfo.email }}</p>
                      </div>
                    </div>
                    <hr />
                    <div class="row">
                      <div class="col-sm-3">
                        <p class="mb-0">Username</p>
                      </div>
                      <div class="col-sm-9">
                        <p class="text-muted mb-0">{{ userInfo.username }}</p>
                      </div>
                    </div>
                    <!-- <hr /> -->
                    <div class="row">
                      <!-- <div class="col-sm-3">
                          <p class="mb-0">Phone</p>
                        </div> -->
                      <div class="col-sm-9">
                        <p class="text-muted mb-0">{{ userInfo.phone }}</p>
                      </div>
                    </div>
                    <hr />
                    <div class="row">
                      <div class="col-sm-3">
                        <p class="mb-0">Role</p>
                      </div>
                      <div class="col-sm-9">
                        <p class="text-muted mb-0">{{ userInfo.role }}</p>
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
      </div>
    </main>
  </div>
</template>

<script>
import TopNav from '@/components/doorman/TopNav.vue'
import axios from 'axios'
import { mapState } from 'pinia'
import useGeneralStore from '@/stores/general'
import useUserStore from '@/stores/users'
import Loader from '@/components/CssLoader.vue'

export default {
  data() {
    return {
      userInfo: {}, // Initialize as an empty object
      userId: null,
      message: null,
      isLoading: false
    }
  },
  computed: {
    ...mapState(useGeneralStore, ['API_URL']),
    ...mapState(useUserStore, ['token', 'user'])
  },
  components: {
    TopNav,
    Loader
  },
  created() {
    this.userId = localStorage.getItem('userId')
    this.getUserInfo()
  },
  methods: {
    async getUserInfo() {
      this.isLoading = true
      try {
        const response = await axios.get(`${this.API_URL}user${this.userId}`, {
          headers: {
            Authorization: `Bearer ${this.token}`
          }
        })
        this.userInfo = response.data.user
        console.log(this.userInfo)
      } catch (error) {
        console.error('Error fetching user info:', error)
        this.message = 'An error occurred while fetching user information. Please try again.'
      } finally {
        this.isLoading = false
      }
    }
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

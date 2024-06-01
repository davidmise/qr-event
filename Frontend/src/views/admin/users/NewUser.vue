<script setup>
import Sidebar from '@/components/Bars/Sidebar/SideBar.vue'
import { sidebarWidth } from '@/components/Bars/Sidebar/state'
import TopBar from '@/components/Bars/TopBar/TopBar.vue'
import axios from 'axios'
import useGeneralStore from '@/stores/general'
import { mapState } from 'pinia'
import useUserStore from '@/stores/users'
import Swal from 'sweetalert2'
// import { useRouter } from "vue-router";
</script>

<template>
  <div>
    <Sidebar />
    <div :style="{ marginLeft: sidebarWidth, transition: 'margin 0.8s' }">
      <TopBar />
      <main class="py-6 bg-surface-secondary">
        <div class="container-fluid">
          <main class="py-6 bg-surface-secondary ms-4">
            <h2 class="mb-3">Create User</h2>
            <form action="" @submit.prevent="createEvent">
              <div class="container mb-5">
                <!-- first row  -->
                <div class="row mt-5 mx-lg-auto">
                  <!-- Organizer Table -->
                  <div class="col-lg-5 col-md-6 col-sm-12">
                    <div class="card border-0 shadow form-group py-3 px-4">
                      <h5 class="text-secondary fw-bold">User Info</h5>
                      <!-- <label for="name">Name</label> -->
                      <!-- event name -->
                      <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput" v-model="name" />
                        <label for="floatingInput">Name</label>
                      </div>

                      <div class="form-floating mb-3">
                        <input
                          type="text"
                          class="form-control"
                          id="floatingInput"
                          v-model="email"
                        />
                        <label for="floatingInput">Email</label>
                      </div>

                      <!-- event subtitle -->
                      <div class="form-floating mb-3">
                        <input
                          type="text"
                          class="form-control"
                          id="floatingInput"
                          v-model="phone"
                        />
                        <label for="floatingInput">Phone</label>
                      </div>
                      <div class="form-floating mb-3 position-relative">
                        <input
                          :type="passwordFieldType"
                          class="form-control"
                          name="password"
                          id="password"
                          placeholder="Password"
                          v-model="password"
                          required
                        />
                        <i
                          :class="passwordToggleIcon"
                          id="togglePassword"
                          @click="togglePasswordVisibility"
                          style="
                            position: absolute;
                            right: 10px;
                            top: 50%;
                            transform: translateY(-50%);
                            cursor: pointer;
                          "
                        ></i>
                        <label for="password" class="form-label">Password</label>
                      </div>
                      <div class="form-floating mb-3 position-relative">
                        <input
                          class="form-control"
                          name="confirmPassword"
                          id="confirmPassword"
                          placeholder="Confirm Password"
                          v-model="confirmPassword"
                          :type="confirmPasswordFieldType"
                          required
                        />
                        <label for="confirmPassword" class="form-label">Confirm Password</label>
                        <span class="password-toggle-icon" @click="toggleConfirmPasswordVisibility">
                          <i
                            :class="confirmPasswordToggleIcon"
                            style="
                              position: absolute;
                              right: 10px;
                              top: 50%;
                              transform: translateY(-50%);
                              cursor: pointer;
                            "
                          ></i>
                        </span>
                      </div>
                      <div class="form-check">
                        <input
                          class="form-check-input"
                          type="radio"
                          name="exampleRadios"
                          id="exampleRadios1"
                          value="Host"
                          checked
                        />
                        <label class="form-check-label" for="exampleRadios1"> Host </label>
                      </div>
                      <div class="form-check">
                        <input
                          class="form-check-input"
                          type="radio"
                          name="exampleRadios"
                          id="exampleRadios2"
                          value="Doorman"
                        />
                        <label class="form-check-label" for="exampleRadios2"> Doorman </label>
                      </div>
                    </div>
                    <!-- submit BUTTON -->
                    <div class="btn-container d-grid mt-5">
                      <button type="submit" class="btn btn-secondary btn-lg rounded">
                        Create Event
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </main>
        </div>
      </main>
    </div>
  </div>
</template>

<script>
export default {
  name: 'CreateEvent',
  data() {
    return {
      name: '',
      email: '',
      phone: '',
      password: '',
      confirmPassword: '',
      role: '',
      submitting: false,
      message: null,
      passwordFieldType: 'password',
      passwordToggleIcon: 'bi bi-eye-slash',
      confirmPasswordFieldType: 'password',
      confirmPasswordToggleIcon: 'bi bi-eye-slash'
    }
  },

  computed: {
    ...mapState(useGeneralStore, ['API_URL']),

    ...mapState(useUserStore, ['token'])
  },

  methods: {
    async createEvent() {
      try {
        const response = await axios.post(`${this.API_URL}create-event`, this.event_info, {
          headers: {
            Authorization: `Bearer ${this.token}`
          }
        })

        const event_id = response.data.event.event_info.id
        console.log(response.data.event)
        localStorage.setItem('event_id', event_id)
        console.log('this event id is: ' + event_id)
        this.resetForm()
        this.$router.push({ name: 'AllEvents' })
      } catch (error) {
        if (error.response && error.response.status === 500) {
          console.error('Internal server error:', error.response.data)
          // Show user-friendly error message (optional)
          this.isLoading = false // Set loading state to false after failed fetch
        this.message = error.response.statusText
        this.handelErrorToast()
        } else {
          console.error('Error creating event:', error)
          this.isLoading = false // Set loading state to false after failed fetch
        this.message = error.response.statusText

        this.handelErrorToast()
        }
      }

      // console.log(this.name, this.description, this.date, this.time, this.city, this.state, this.country, this.postalCode, this.googleMapUrl)
    },
    togglePasswordVisibility() {
      if (this.passwordFieldType === 'password') {
        this.passwordFieldType = 'text'
        this.passwordToggleIcon = 'bi bi-eye'
      } else {
        this.passwordFieldType = 'password'
        this.passwordToggleIcon = 'bi bi-eye-slash'
      }
    },
    toggleConfirmPasswordVisibility() {
      if (this.confirmPasswordFieldType === 'password') {
        this.confirmPasswordFieldType = 'text'
        this.confirmPasswordToggleIcon = 'bi bi-eye'
      } else {
        this.confirmPasswordFieldType = 'password'
        this.confirmPasswordToggleIcon = 'bi bi-eye-slash'
      }
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

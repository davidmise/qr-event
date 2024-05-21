<!-- ResetPassword.vue -->
<template>
  <div class="centerd-container">
    <div class="centered-container">
      <div class="card border-0 shadow text-center" style="width: 400px">
        <div class="card-header h5 text-white bg-primary">Password Reset</div>
        <div class="card-body px-5">
          <p class="card-text py-2">
            Enter your email address and we'll send you an email with instructions to reset your
            password.
          </p>
          <form @submit.prevent="submit">
            <!-- email -->
            <div class="form-floating mb-3">
              <input
                type="email"
                class="form-control"
                name="email"
                id="email"
                placeholder="name@example.com"
                v-model="email"
                required
              />
              <label for="email" class="form-label">Email</label>
            </div>
            <!-- new Password -->
            <div class="form-floating mb-3">
              <input
                type="password"
                class="form-control"
                name="password"
                id="Password"
                placeholder="name@example.com"
                v-model="Password"
                required
              />
              <label for="newPassword" class="form-label">New Password</label>
            </div>
            <!-- confirm Password -->
            <div class="form-floating mb-3">
              <input
                type="password"
                class="form-control"
                name="confirmPassword"
                id="confirmPassword"
                placeholder="name@example.com"
                v-model="password_confirmation"
                required
              />
              <label for="confirmPassword" class="form-label">confirm Password</label>
            </div>

            <button class="btn btn-primary w-100" type="submit">Send Reset Link</button>
          </form>
          <!-- <a href="#" data-mdb-ripple-init class="btn btn-primary ">Reset password</a> -->
          <div class="d-flex justify-content-between mt-4">
            <router-link class="text-decoration-non" :to="{ name: 'login' }">Login</router-link>
            <router-link class="text-decoration-non" :to="{ name: 'register' }"
              >Register</router-link
            >
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<style scoped>
.centered-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}
</style>

<script>
import { computed } from 'vue' // Import computed from Vue

import axios from 'axios'
import Swal from 'sweetalert2'

import { mapState } from 'pinia'
import useGeneralStore from '@/stores/general'
import useUserStore from '@/stores/users'
import { useRoute } from 'vue-router'

export default {
  data() {
    const userIsLoggedIn = computed(() => useUserStore.userIsLoggedIn)
    return {
      email: '',
      password: '',
      password_confirmation: '',
      userIsLoggedIn
    }
  },
  setup() {
    const route = useRoute()
    return { route }
  },
  computed: {
    ...mapState(useGeneralStore, ['API_URL']),
    ...mapState(useUserStore, ['storedUser', 'token'])
  },
  methods: {
    async submit() {
      try {
        const response = await axios.post(
          `${this.API_URL}reset-password`,
          {
            token: this.route.query.token,
            email: this.email,
            password: this.password,
            password_confirmation: this.password_confirmation
          },
          {
            headers: {
              Authorization: `Bearer ${this.token}`
            }
          }
        )
        // alert(response.data.message)
        this.handelSuccessToast()
        this.message = response.data.message
      } catch (error) {
        // alert(error.response.data.message)
        this.handelErrorToast()
        this.message = error.response.data.message
      }
    },
    handelErrorToast() {
      Swal.fire({
        icon: 'error',
        title: 'Authentication failed!',
        text: this.message
      })
    },
    handelSuccessToast() {
      Swal.fire({
        icon: 'success',
        title: 'Logged in Successfully!'
      })
    }
  }
}
</script>

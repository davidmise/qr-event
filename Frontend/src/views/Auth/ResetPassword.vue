<!-- ResetPassword.vue -->
<template>
  <div class="centered-container">
    <div class="card border-0 shadow text-center" style="width: 400px">
      <div class="card-header h5 text-white bg-primary">Password Reset</div>
      <div class="card-body px-5">
        <p class="card-text py-2">
          Enter your email address and we'll send you an email with instructions to reset your
          password.
        </p>
        <form @submit.prevent="submit"> 
          <!-- Email -->
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
           <!-- Token -->
           <div class="form-floating mb-3">
            <input
              type="text"
              class="form-control"
              name="token"
              id="token"
              placeholder="token"
              v-model="token"
              required
            />
            <label for="token" class="form-label">Token</label>
          </div>
          <!-- New Password -->
          <div class="form-floating mb-3">
            <input
              type="password"
              class="form-control"
              name="password"
              id="password"
              placeholder="new password"
              v-model="password"
              required
            />
            <label for="password" class="form-label">New Password</label>
          </div>
          <!-- Confirm Password -->
          <div class="form-floating mb-3">
            <input
              type="password"
              class="form-control"
              name="password_confirmation"
              id="password_confirmation"
              placeholder="confirm password"
              v-model="password_confirmation"
              required
            />
            <label for="password_confirmation" class="form-label">Confirm Password</label>
          </div>

          <button class="btn btn-primary w-100" type="submit">Send Reset Link</button>
        </form>
        <div class="d-flex justify-content-between mt-4">
          <router-link class="text-decoration-non" :to="{ name: 'login' }">Login</router-link>
          <router-link class="text-decoration-non" :to="{ name: 'register' }">Register</router-link>
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
import { computed } from 'vue'
import axios from 'axios'
import Swal from 'sweetalert2'
import { mapState } from 'pinia'
import useGeneralStore from '@/stores/general'
import useUserStore from '@/stores/users'
import { useRoute, useRouter } from 'vue-router'

export default {
  data() {
    const userIsLoggedIn = computed(() => useUserStore.userIsLoggedIn)
    return {
      token: '',
      email: '',
      password: '',
      password_confirmation: '',
      userIsLoggedIn,
      message: null,
      validationErrors: null // Add validationErrors to data
    }
  },
  setup() {
    const route = useRoute()
    const router = useRouter()
    return { route, router }
  },
  computed: {
    ...mapState(useGeneralStore, ['API_URL']),
    ...mapState(useUserStore, ['storedUser', 'token'])
  },
  methods: {
    async submit() {
      try {
        const response = await axios.post(
          `${this.API_URL}reset`,
          {
            token: this.token,
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
        this.handleSuccessToast(response.data.message)
        this.message = response.data.message
        this.validationErrors = null // Clear validation errors on success
      } catch (error) {
        if (error.response && error.response.status === 422) {
          // Handle validation errors
          this.validationErrors = error.response.data.errors
          this.handleValidationErrors(this.validationErrors)
        } else {
          this.handleErrorToast(error.response.data.message)
          this.message = error.response.statusText
        }
      }
    },
    handleErrorToast(message) {
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: message
      })
    },
    handleSuccessToast(message) {
      Swal.fire({
        icon: 'success',
        title: 'Success',
        text: message
      }).then(() => {
        // Clear form fields
        this.token = ''
        this.email = ''
        this.password = ''
        this.password_confirmation = ''
        // Redirect to login page
        this.router.push({ name: 'login' })
      })
    },
    handleValidationErrors(errors) {
      let errorMessages = ''
      for (const key in errors) {
        if (Object.prototype.hasOwnProperty.call(errors, key)) {
          errorMessages += `${errors[key].join(' ')}\n`
        }
      }
      Swal.fire({
        icon: 'error',
        title: 'Validation Error',
        text: errorMessages.trim()
      })
    }
  }
}
</script>

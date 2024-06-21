<!-- ForgotPassword.vue -->
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

          <button class="btn btn-primary w-100" type="submit">Send Reset Link</button>
        </form>
        <!-- Loader Component -->
        <Loader v-if="isLoading" />
        <!-- <a href="#" data-mdb-ripple-init class="btn btn-primary ">Reset password</a> -->
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
import { computed } from 'vue' // Import computed from Vue

import axios from 'axios'
import Swal from 'sweetalert2'
import Loader from '@/components/CssLoader.vue'

import { mapActions, mapState } from 'pinia'
import useGeneralStore from '@/stores/general'
import useUserStore from '@/stores/users'

export default {
  data() {
    const userIsLoggedIn = computed(() => useUserStore.userIsLoggedIn)
    return {
      email: '',
      message: null,
      userIsLoggedIn,
      isLoading: false,
      validationErrors: null // Add validationErrors to data
    }
  },
  computed: {
    ...mapState(useGeneralStore, ['API_URL']),
    ...mapState(useUserStore, ['storedUser', 'token'])
  },
  components: {
    // TopNav,
    Loader
  },
  methods: {
    ...mapActions(useUserStore, ['storeLoggedInUser']),
    async submit() {
      this.isLoading = true
      try {
        const response = await axios.post(`${this.API_URL}forgot`, {
          email: this.email
        })
        console.log(response.data)
        this.handleSuccessToast(response.data.message)
        this.message = response.data.message
        this.validationErrors = null // Clear validation errors on success
        this.$router.push({ name: 'ResetPassword' })
      } catch (error) {
        if (error.response && error.response.status === 422) {
          // Handle validation errors
          this.validationErrors = error.response.data.message
          this.handleValidationErrors(this.validationErrors)
        } else {
          this.message = error.response
          this.handleErrorToast(this.message, error.response)
        }
      } finally {
        this.isLoading = false
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
      })
    },
    handleValidationErrors(errors) {
      let errorMessages = ''
      for (const key in errors) {
        // eslint-disable-next-line no-prototype-builtins
        if (errors.hasOwnProperty(key)) {
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

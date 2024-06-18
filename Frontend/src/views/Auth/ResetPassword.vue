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
              :type="passwordFieldType"
              class="form-control"
              name="password"
              id="password"
              placeholder="new password"
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
            <label for="password" class="form-label">New Password</label>
          </div>
          <!-- Confirm Password -->
          <div class="form-floating mb-3">
            <input
              class="form-control"
              name="confirmPassword"
              id="confirmPassword"
              placeholder="Confirm Password"
              v-model="confirmPassword"
              :type="confirmPasswordFieldType"
              required
            />
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
#togglePassword {
  position: absolute;
  right: 10px;
  top: 50%;
  transform: translateY(-50%);
  cursor: pointer;
}
#toggleConfirmPassword {
  position: absolute;
  right: 10px;
  top: 50%;
  transform: translateY(-50%);
  cursor: pointer;
}
.centered-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}
.cover {
  background-color: hsl(218, 41%, 15%);
  background-image: radial-gradient(
      650px circle at 0% 0%,
      hsl(218, 41%, 35%) 15%,
      hsl(218, 41%, 30%) 35%,
      hsl(218, 41%, 20%) 75%,
      hsl(218, 41%, 19%) 80%,
      transparent 100%
    ),
    radial-gradient(
      1250px circle at 100% 100%,
      hsl(218, 41%, 45%) 15%,
      hsl(218, 41%, 30%) 35%,
      hsl(218, 41%, 20%) 75%,
      hsl(218, 41%, 19%) 80%,
      transparent 100%
    );
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
      validationErrors: null, // Add validationErrors to data
      passwordFieldType: 'password', // Add password field type
      passwordToggleIcon: 'bi bi-eye-slash',
      confirmPasswordFieldType: 'password',
      confirmPasswordToggleIcon: 'bi bi-eye-slash'
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
    }
  }
}
</script>

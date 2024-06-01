<template>
  <section class="bg-primary py-3 py-md-5 py-xl-8">
    <div class="container">
      <div class="row gy-4 align-items-center">
        <div class="col-12 col-md-6 col-xl-7">
          <div class="d-flex justify-content-center text-bg-primary">
            <div class="col-12 col-xl-9">
              <img
                class="img-fluid rounded mb-4"
                loading="lazy"
                src="./assets/img/bsb-logo-light.svg"
                width="245"
                height="80"
                alt="BootstrapBrain Logo"
              />
              <hr class="border-primary-subtle mb-4" />
              <h2 class="h1 mb-4">We make digital products that drive you to stand out.</h2>
              <p class="lead mb-5">
                We write words, take photos, make videos, and interact with artificial intelligence.
              </p>
              <div class="text-endx">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="48"
                  height="48"
                  fill="currentColor"
                  class="bi bi-grip-horizontal"
                  viewBox="0 0 16 16"
                >
                  <path
                    d="M2 8a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm0-3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm3 3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm0-3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm3 3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm0-3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm3 3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm0-3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm3 3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm0-3a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"
                  />
                </svg>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-6 col-xl-5">
          <div class="card border-0 rounded-4">
            <div class="card-body p-3 p-md-4 p-xl-5">
              <div class="row">
                <div class="col-12">
                  <div class="mb-4">
                    <h3>Sign in</h3>
                    <p>
                      Don't have an account? <router-link to="/auth/register">Sign up</router-link>
                    </p>
                  </div>
                </div>
              </div>
              <form action="#!" @submit.prevent="submitting === false && loginUser()">
                <div class="row gy-3 overflow-hidden">
                  <div class="col-12">
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
                  </div>
                  <div class="col-12">
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
                  </div>
                  <div class="col-12">
                    <div class="form-check">
                      <input
                        class="form-check-input"
                        type="checkbox"
                        value=""
                        name="remember_me"
                        id="remember_me"
                      />
                      <label class="form-check-label text-secondary" for="remember_me">
                        Keep me logged in
                      </label>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="d-grid">
                      <button class="btn btn-primary btn-lg" type="submit">Log in now</button>
                    </div>
                  </div>
                </div>
              </form>
              <div class="row">
                <div class="col-12">
                  <div
                    class="d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-md-end mt-4"
                  >
                    <router-link :to="{ name: 'forgotPassword' }">Forgot password</router-link>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <p class="mt-4 mb-4">Or continue with</p>
                  <div class="d-flex gap-2 gap-sm-3 justify-content-centerX">
                    <a href="#!" class="btn btn-outline-danger bsb-btn-circle bsb-btn-circle-2xl">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        fill="currentColor"
                        class="bi bi-google"
                        viewBox="0 0 16 16"
                      >
                        <path
                          d="M15.545 6.558a9.42 9.42 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.689 7.689 0 0 1 5.352 2.082l-2.284 2.284A4.347 4.347 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.792 4.792 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.702 3.702 0 0 0 1.599-2.431H8v-3.08h7.545z"
                        />
                      </svg>
                    </a>
                    <a href="#!" class="btn btn-outline-primary bsb-btn-circle bsb-btn-circle-2xl">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        fill="currentColor"
                        class="bi bi-facebook"
                        viewBox="0 0 16 16"
                      >
                        <path
                          d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"
                        />
                      </svg>
                    </a>
                    <a href="#!" class="btn btn-outline-dark bsb-btn-circle bsb-btn-circle-2xl">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        fill="currentColor"
                        class="bi bi-github"
                        viewBox="0 0 16 16"
                      >
                        <path
                          d="M8 0C3.58 0 0 3.58 0 8c0 3.539 2.292 6.533 5.47 7.59.4.074.546-.173.546-.385 0-.19-.007-.693-.01-1.36-2.226.483-2.695-1.073-2.695-1.073-.364-.923-.89-1.168-.89-1.168-.727-.497.055-.487.055-.487.803.057 1.226.824 1.226.824.714 1.223 1.872.87 2.329.665.072-.517.279-.87.508-1.07-1.776-.201-3.644-.888-3.644-3.951 0-.872.31-1.585.823-2.144-.083-.202-.357-1.013.078-2.112 0 0 .67-.215 2.2.82a7.59 7.59 0 0 1 2.002-.269c.68.003 1.364.092 2.002.27 1.53-1.036 2.2-.821 2.2-.821.437 1.1.162 1.91.08 2.112.513.56.822 1.272.822 2.144 0 3.07-1.87 3.748-3.652 3.947.287.247.543.735.543 1.48 0 1.07-.01 1.933-.01 2.197 0 .214.144.462.55.384A8.008 8.008 0 0 0 16 8c0-4.42-3.58-8-8-8z"
                        />
                      </svg>
                    </a>
                    <a href="#!" class="btn btn-outline-info bsb-btn-circle bsb-btn-circle-2xl">
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        fill="currentColor"
                        class="bi bi-twitter"
                        viewBox="0 0 16 16"
                      >
                        <path
                          d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.01-.423A6.68 6.68 0 0 0 16 3.542a6.56 6.56 0 0 1-1.889.518 3.3 3.3 0 0 0 1.443-1.817 6.573 6.573 0 0 1-2.084.797 3.281 3.281 0 0 0-5.593 2.99A9.325 9.325 0 0 1 1.114 2.1a3.28 3.28 0 0 0 1.015 4.382A3.301 3.301 0 0 1 .64 6.575v.045A3.283 3.283 0 0 0 3.277 10.1a3.273 3.273 0 0 1-.865.115c-.211 0-.417-.02-.617-.058a3.283 3.283 0 0 0 3.065 2.278A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045 9.29 9.29 0 0 0 5.026 1.466"
                        />
                      </svg>
                    </a>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <p class="small text-secondary mt-4">
                    By continuing, you agree to our <a href="#">Terms of Service</a> and acknowledge
                    our <a href="#">Privacy Policy</a>.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
<script>
import { computed } from 'vue' // Import computed from Vue
import axios from 'axios'
import Swal from 'sweetalert2'
import { mapActions, mapState } from 'pinia'
import useGeneralStore from '@/stores/general'
import useUserStore from '@/stores/users'

export default {
  data() {
    const userIsLoggedIn = computed(() => useUserStore.userIsLoggedIn)
    return {
      email: '',
      password: '',
      submitting: false,
      message: null,
      userIsLoggedIn,
      passwordFieldType: 'password', // Add password field type
      passwordToggleIcon: 'bi bi-eye-slash' // Add password toggle icon
    }
  },

  computed: {
    ...mapState(useGeneralStore, ['API_URL']),
    ...mapState(useUserStore, ['storedUser', 'token'])
  },
  methods: {
    ...mapActions(useUserStore, ['storeLoggedInUser']),
    loginUser() {
      const _this = this
      _this.submitting = true

      axios
        .post(
          `${this.API_URL}login`,
          {
            email: _this.email,
            password: _this.password
          },
          {
            headers: {
              Authorization: `Bearer ${this.token}`
            }
          }
        )
        .then((response) => {
          const user = response.data.user
          const token = response.data.token
          _this.storeLoggedInUser(user, token)
          this.message = response.data.message
          console.log(response.data)
          this.handelSuccessToast()
          this.resetForm()
        })
        .catch((error) => {
          console.log(error)
          this.message = error.response.statusText
          this.handelErrorToast()
        })
        .then(() => {
          _this.submitting = false
        })
    },
    resetForm() {
      this.email = ''
      this.password = ''
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
    },
    togglePasswordVisibility() {
      if (this.passwordFieldType === 'password') {
        this.passwordFieldType = 'text'
        this.passwordToggleIcon = 'bi bi-eye'
      } else {
        this.passwordFieldType = 'password'
        this.passwordToggleIcon = 'bi bi-eye-slash'
      }
    }
  }
}
</script>

<style scoped>
#togglePassword {
  position: absolute;
  right: 10px;
  top: 50%;
  transform: translateY(-50%);
  cursor: pointer;
}
</style>

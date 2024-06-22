<template>
    <section class="cover py-3 py-md-5 py-xl-8 h-100">
      <div class="container">
        <div class="row gy-4 align-items-center">
          <div class="col-12 col-sm-12 col-md-4 col-xl-7">
            <div class="d-flex justify-content-center">
              <div class="col-12 col-xl-9">
                <img
                  class="img-fluid rounded mb-4"
                  loading="lazy"
                  :src="img"
                  width="245"
                  height="80"
                  alt="BootstrapBrain Logo"
                />
                <hr class="border-primary-subtle mb-4" />
                <h2 class="h1 mb-4" style="color: #f3b41b">
                 Printing and Media Solutions
                </h2>
                 <div class="row">
                <div class="col-12">
                  <p class="mt-4 mb-4 text-white">Our Social Links</p>
                  <div class="d-flex gap-2 gap-sm-3 justify-content-centerX">
                    <a href="https://wa.me/255744648052" target="_blank" class="btn btn-outline-success bsb-btn-circle bsb-btn-circle-2xl">
                        <i class="bi bi-whatsapp"></i>
                    </a>
                    <a href="https://www.instagram.com/creative.hub.tz?igsh=MXA3NWcwa2pvMW10dQ==" class="btn btn-outline-primary bsb-btn-circle bsb-btn-circle-2xl">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="#!" class="btn btn-outline-primary bsb-btn-circle bsb-btn-circle-2xl">
                        <i class="bi bi-facebook"></i>
                    </a>
                  </div></div></div>
                <div class="text-endx">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="48"
                    height="48"
                    fill="#f3b41b"
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
          <div class="col-12 col-md-8 col-sm-12 col-xl-5">
            <div class="card bg-body-tertiary border-0 rounded-4">
              <div class="card-body p-3 p-md-4 p-xl-5">
                <div class="row">
                  <div class="col-12">
                    <div class="mb-4">
                      <h3>Register</h3>
                      <p>
                        Don't have an account? <router-link to="/auth/login">Sign in</router-link>
                      </p>
                    </div>
                  </div>
                </div>
                <form action="#!" @submit.prevent="submitting === false && registerUser()">
                  <div class="row gy-3 overflow-hidden">
                    <!-- name -->
                    <div class="col-12">
                      <div class="form-floating mb-3">
                        <input
                          type="text"
                          class="form-control"
                          name="name"
                          id="name"
                          placeholder="user"
                          v-model="name"
                          required
                        />
                        <label for="name" class="form-label">Name</label>
                      </div>
                    </div>
                    <!-- username -->
                    <div class="col-12">
                      <div class="form-floating mb-3">
                        <input
                          type="text"
                          class="form-control"
                          name="username"
                          id="username"
                          placeholder="user"
                          v-model="username"
                          required
                        />
                        <label for="username" class="form-label">User name</label>
                      </div>
                    </div>
                    <!-- email -->
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
                    <!-- password -->
                    <div class="col-12">
                      <div class="form-floating mb-3 position-relative">
                        <input
                          class="form-control"
                          name="password"
                          id="password"
                          placeholder="Password"
                          v-model="password"
                          :type="passwordFieldType"
                          required
                        />
                        <label for="password" class="form-label">Password</label>
                        <span class="password-toggle-icon" @click="togglePasswordVisibility">
                          <i
                            :class="passwordToggleIcon"
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
                    </div>
                    <!-- Confirm Password -->
                    <div class="col-12">
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
                    </div>
                    <div class="col-12">
                      <div class="d-grid">
                        <button class="btn btn-primary btn-lg" type="submit">Register</button>
                      </div>
                    </div>
                  </div>
                </form>
                <!-- Loader Component -->
                <Loader v-if="isLoading" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </template>
  
  <script>
  import axios from 'axios'
  import Swal from 'sweetalert2'
  import useGeneralStore from '@/stores/general'
  import { mapState } from 'pinia'
  import router from '@/router'
  import logo from '@/assets/Images/crhl.png'
  import Loader from '@/components/CssLoader.vue'
  
  export default {
    data() {
      return {
        name: '',
        email: '',
        username: '',
        password: '',
        confirmPassword: '',
        submitting: false,
        isLoading: false,
        message: null,
        passwordFieldType: 'password',
        passwordToggleIcon: 'bi bi-eye-slash',
        confirmPasswordFieldType: 'password',
        confirmPasswordToggleIcon: 'bi bi-eye-slash',
        img: logo
      }
    },
    computed: {
      ...mapState(useGeneralStore, ['API_URL'])
    },
    components: {
      Loader
    },
    methods: {
      async registerUser() {
        const _this = this
        _this.submitting = true
        _this.isLoading = true
  
        // Password length validation
        if (_this.password.length < 8) {
          _this.message = 'Password must be at least 8 characters long'
          _this.handleErrorToast()
          _this.isLoading = false
          _this.submitting = false
          return
        }
  
        // Password match validation
        if (_this.password !== _this.confirmPassword) {
          _this.message = 'Passwords do not match'
          _this.handleErrorToast()
          _this.isLoading = false
          _this.submitting = false
          return
        }
  
        try {
          const response = await axios.post(`${this.API_URL}register`, {
            name: _this.name,
            username: _this.username,
            email: _this.email,
            password: _this.password
          })
          _this.message = response.data.message
          _this.handleSuccessToast()
          _this.resetForm()
          router.push({ name: 'login' })
        } catch (error) {
          console.log(error)
          _this.message = error.response.data.message || 'An error occurred during registration. Please try again.'
          _this.handleErrorToast()
        } finally {
          _this.isLoading = false
          _this.submitting = false
        }
      },
      handleSuccessToast() {
        Swal.fire({
          icon: 'success',
          text: this.message
        })
      },
      handleErrorToast() {
        Swal.fire({
          icon: 'error',
          title: 'Registration failed!',
          text: this.message
        })
      },
      resetForm() {
        this.email = ''
        this.password = ''
        this.confirmPassword = ''
        this.name = ''
        this.username = ''
      },
      togglePasswordVisibility() {
        this.passwordFieldType = this.passwordFieldType === 'password' ? 'text' : 'password'
        this.passwordToggleIcon = this.passwordToggleIcon === 'bi bi-eye-slash' ? 'bi bi-eye' : 'bi bi-eye-slash'
      },
      toggleConfirmPasswordVisibility() {
        this.confirmPasswordFieldType = this.confirmPasswordFieldType === 'password' ? 'text' : 'password'
        this.confirmPasswordToggleIcon = this.confirmPasswordToggleIcon === 'bi bi-eye-slash' ? 'bi bi-eye' : 'bi bi-eye-slash'
      }
    }
  }
  </script>
  
  <style scoped>
  .bsb-btn-circle {
    border-radius: 50%;
}
.bsb-btn-circle-2xl {
    width: 60px;
    height: 60px;
    padding: 10px 16px;
    font-size: 24px;
}
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
  
  .cover {
    background-color: hsl(218, 41%, 15%);
    background-image: radial-gradient(
        650px circle at 0% 0%,
        hsl(217, 26%, 16%) 15%,
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
       /* Make the cover section full-screen */
  height: 100vh; /* Use viewport height */
  display: flex;
  justify-content: center;
  align-items: center;
  }
  </style>
  
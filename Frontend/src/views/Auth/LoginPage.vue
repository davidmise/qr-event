<template>
  <section class="cover py-3 py-md-5 py-xl-8">
    <div class="container">
      <div class="row gy-4 align-items-center">
        <div class="col-12 col-md-6 col-xl-7">
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
              <h2 class="h1 mb-4" style="color: #f3b41b">Printing and Media Solutions</h2>
              <div class="row">
                <div class="col-12">
                  <p class="mt-4 mb-4 text-white">Our Social Links</p>
                  <div class="d-flex gap-2 gap-sm-3 justify-content-centerX">
                    <a
                      href="https://wa.me/255744648052"
                      target="_blank"
                      class="btn btn-outline-success bsb-btn-circle bsb-btn-circle-2xl"
                    >
                      <i class="bi bi-whatsapp"></i>
                    </a>
                    <a
                      href="https://www.instagram.com/creative.hub.tz?igsh=MXA3NWcwa2pvMW10dQ=="
                      class="btn btn-outline-primary bsb-btn-circle bsb-btn-circle-2xl"
                    >
                      <i class="bi bi-instagram"></i>
                    </a>
                    <a href="#!" class="btn btn-outline-primary bsb-btn-circle bsb-btn-circle-2xl">
                      <i class="bi bi-facebook"></i>
                    </a>
                  </div>
                </div>
              </div>
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
        <div class="col-12 col-md-6 col-xl-5">
          <div class="card bg-body-tertiary border-0 rounded-4">
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
              <!-- <div class="row">
                <div class="col-12">
                  <p class="small text-secondary mt-4">
                    By continuing, you agree to our <a href="#">Terms of Service</a> and acknowledge
                    our <a href="#">Privacy Policy</a>.
                  </p>
                </div>
              </div> -->
            </div>
          </div>
          <!-- Loader Component -->
          <Loader v-if="isLoading" />
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
import logo from '@/assets/Images/crhl.png'
import Loader from '@/components/CssLoader.vue'

export default {
  data() {
    const userIsLoggedIn = computed(() => useUserStore.userIsLoggedIn)
    return {
      isLoading: false,
      img: logo,
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
  components: {
    Loader
  },
  methods: {
    ...mapActions(useUserStore, ['storeLoggedInUser']),
    loginUser() {
      const _this = this
      _this.submitting = true
      _this.isLoading = true

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
          const userId = response.data.user.id
          localStorage.setItem('userId', userId)
          console.log(userId)

          const token = response.data.token
          _this.storeLoggedInUser(user, token)
          this.message = response.data.message
          console.log(response.data)
          this.handelSuccessToast()
          this.resetForm()
        })
        .catch((error) => {
          console.log(error)
          this.message = error.response.data.message

          this.handelErrorToast()
        })
        .then(() => {
          _this.submitting = false
          this.isLoading = false
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
  /* Make the cover section full-screen */
  height: 100vh; /* Use viewport height */
  display: flex;
  justify-content: center;
  align-items: center;
}
</style>

<template>
  <div>
    <Sidebar />
    <div :style="{ marginLeft: sidebarWidth, transition: 'margin 0.8s' }">
      <TopBar />
      <main class="py-6 bg-surface-secondary">
        <div class="container-fluid">
          <main class="py-6 bg-surface-secondary ms-4">
            <h2 class="mb-3">Create User</h2>
            <form action="" @submit.prevent="registerUser">
              <div class="container mb-5">
                <!-- first row  -->
                <div class="row mt-5 mx-lg-auto">
                  <!-- User Info Table -->
                  <div class="col-lg-5 col-md-6 col-sm-12">
                    <div class="card border-0 shadow form-group py-3 px-4">
                      <h5 class="text-secondary fw-bold">User Info</h5>
                      <!-- Name input -->
                      <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="name" v-model="name" />
                        <label for="name">Name</label>
                      </div>

                      <!-- Username input -->
                      <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="username" v-model="username" />
                        <label for="username">Username</label>
                      </div>

                      <!-- Email input -->
                      <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="email" v-model="email" />
                        <label for="email">Email</label>
                      </div>

                      <!-- Phone input -->
                      <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="phone" v-model="phone" />
                        <label for="phone">Phone</label>
                      </div>

                      <!-- Password input -->
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

                      <!-- Confirm Password input -->
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

                      <!-- Role selection -->
                      <div class="form-check">
                        <input
                          class="form-check-input"
                          type="radio"
                          name="role"
                          id="hostRadio"
                          value="host"
                          v-model="role"
                          checked
                        />
                        <label class="form-check-label" for="hostRadio">Host</label>
                      </div>
                      <div class="form-check">
                        <input
                          class="form-check-input"
                          type="radio"
                          name="role"
                          id="doormanRadio"
                          value="doorman"
                          v-model="role"
                        />
                        <label class="form-check-label" for="doormanRadio">Doorman</label>
                      </div>
                    </div>

                    <!-- Submit button -->
                    <div class="btn-container d-grid mt-5">
                      <button type="submit" class="btn btn-secondary btn-lg rounded">
                        Create User
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
            <!-- Loader Component -->
            <Loader v-if="isLoading" />
          </main>
        </div>
      </main>
    </div>
  </div>
</template>

<script setup>
import Sidebar from '@/components/Bars/Sidebar/SideBar.vue'
import { sidebarWidth } from '@/components/Bars/Sidebar/state'
import TopBar from '@/components/Bars/TopBar/TopBar.vue'
import axios from 'axios'
import Swal from 'sweetalert2'
import router from '@/router'
import useGeneralStore from '@/stores/general.js'
import { ref } from 'vue'
import Loader from '@/components/CssLoader.vue'

const name = ref('')
const email = ref('')
const username = ref('')
const phone = ref('')
const password = ref('')
const confirmPassword = ref('')
const role = ref('host')
const submitting = ref(false)
const isLoading = ref(false)
const passwordFieldType = ref('password')
const passwordToggleIcon = ref('bi bi-eye-slash')
const confirmPasswordFieldType = ref('password')
const confirmPasswordToggleIcon = ref('bi bi-eye-slash')
const API_URL = useGeneralStore().API_URL

const registerUser = () => {
  submitting.value = true
  isLoading.value = true
  if (password.value !== confirmPassword.value) {
    handleError('Passwords do not match')
    return
  }

  axios
    .post(`${API_URL}register`, {
      name: name.value,
      username: username.value,
      email: email.value,
      phone: phone.value,
      password: password.value,
      role: role.value
    })
    .then((response) => {
      console.log(response.data.message)
      handelSuccessToast(response.data.message)
      resetForm()
      router.push({ name: 'login' })
    })
    .catch((error) => {
      console.log(error)
      handelErrorToast(error.response ? error.response.statusText : 'An error occurred')
    })
    .finally(() => {
      submitting.value = false
      isLoading.value = false
    })
}

const handelSuccessToast = (message) => {
  Swal.fire({
    icon: 'success',
    text: message
  })
}

const handelErrorToast = (message) => {
  Swal.fire({
    icon: 'error',
    title: 'Registration failed!',
    text: message
  })
}

const handleError = (message) => {
  handelErrorToast(message)
  submitting.value = false
  resetForm()
}

const resetForm = () => {
  name.value = ''
  email.value = ''
  username.value = ''
  phone.value = ''
  password.value = ''
  confirmPassword.value = ''
  role.value = 'host'
}

const togglePasswordVisibility = () => {
  passwordFieldType.value = passwordFieldType.value === 'password' ? 'text' : 'password'
  passwordToggleIcon.value =
    passwordToggleIcon.value === 'bi bi-eye-slash' ? 'bi bi-eye' : 'bi bi-eye-slash'
}

const toggleConfirmPasswordVisibility = () => {
  confirmPasswordFieldType.value =
    confirmPasswordFieldType.value === 'password' ? 'text' : 'password'
  confirmPasswordToggleIcon.value =
    confirmPasswordToggleIcon.value === 'bi bi-eye-slash' ? 'bi bi-eye' : 'bi bi-eye-slash'
}
</script>

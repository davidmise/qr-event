<template>
    <!-- User edit form template -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5 text-secondary fw-bold" id="exampleModalLabel">Eddit User Details</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div><form @submit.prevent="updateUser">
            <div class="modal-body">
                <div>
                    <!-- Form elements for editing user information -->
                    
                        <div class="form-floating mb-3">
                            <input
                              type="text"
                              class="form-control"
                              id="floatingInput"
                              v-model="user.name"
                            />
                            <label for="floatingInput"> Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input
                              type="text"
                              class="form-control"
                              id="floatingInput"
                              v-model="user.username"
                            />
                            <label for="floatingInput"> Username</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input
                              type="text"
                              class="form-control"
                              id="floatingInput"
                              v-model="user.email"
                            />
                            <label for="floatingInput"> Email</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input
                            
                            type="password"
                              class="form-control"
                              id="floatingInput"
                              v-model="user.password"
                            />
                            <label for="floatingInput"> Password</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select
                              class="form-select form-select-lg"
                              aria-label="Large select example"
                              v-model="user.role"
                            >
                              <option disabled selected>Open this select menu</option>
                              <option value="admin">Admin</option>
                              <option value="host">Host</option>
                              <option value="doorman">Doorman</option>
                            </select>
                            <label for="floatingInput">Event Type</label>
                          </div>
                     
                      <!-- <button type="submit" class="btn btn-primary">Update User</button> -->
                    
                  </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div></form>
          </div>
        </div>
      </div>
   
  </template>
  
  <script>
  import axios from 'axios'
  import { mapState } from 'pinia'
  import useUserStore from '@/stores/users'
  import useGeneralStore from '@/stores/general'
  
  export default {
    data() {
      return {
        user: {
          id: null,
          name: '',
          username: '',
          email: '',
        //   number:'',
          password: '',
          role: ''
        }
      }
    },
    computed: {
      ...mapState(useUserStore, ['token']),
      ...mapState(useGeneralStore, ['API_URL']),
    },
    methods: {
      async updateUser() {
        try {
          const response = await axios.put(`${this.API_URL}update-user${this.user.id}`, this.user, {
            headers: {
              Authorization: `Bearer ${this.token}`
            }
          })
          if (response.data.status) {
            // Handle success, e.g., redirect to user list or show success message
            console.log('User updated successfully', response.data.user)
          } else {
            // Handle validation errors
            console.error('Validation errors:', response.data.errors)
          }
        } catch (error) {
          console.error('Error updating user:', error)
        }
      },
      async fetchUser(id) {
        try {
          const response = await axios.get(`${this.API_URL}user${id}`, {
            headers: {
              Authorization: `Bearer ${this.token}`
            }
          })
          this.user = response.data.user
        } catch (error) {
          console.error('Error fetching user:', error)
        }
      }
    },
    created() {
      // Fetch the user data when the component is created
      this.fetchUser(this.$route.params.userId)
    }
  }
  </script>
  
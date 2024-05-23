<template>
    <!-- User edit form template -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Eddit User Details</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>
                    <!-- Form elements for editing user information -->
                    <form @submit.prevent="updateUser">
                      <div class="form-group">
                        <label for="name">Name</label>
                        <input v-model="user.name" type="text" id="name" class="form-control" />
                      </div>
                      <div class="form-group">
                        <label for="username">Username</label>
                        <input v-model="user.username" type="text" id="username" class="form-control" />
                      </div>
                      <div class="form-group">
                        <label for="email">Email</label>
                        <input v-model="user.email" type="email" id="email" class="form-control" />
                      </div>
                      <!-- <div class="form-group">
                        <label for="email">Phone</label>
                        <input v-model="user.phone" type="number" id="number" class="form-control" />
                      </div> -->
                      <div class="form-group">
                        <label for="password">Password</label>
                        <input v-model="user.password" type="password" id="password" class="form-control" />
                      </div>
                      <div class="form-group">
                        <label for="role">Role</label>
                        <select v-model="user.role" id="role" class="form-control">
                          <option value="admin">Admin</option>
                          <option value="host">Host</option>
                          <option value="doorman">Doorman</option>
                        </select>
                      </div>
                      <button type="submit" class="btn btn-primary">Update User</button>
                    </form>
                  </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
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
  
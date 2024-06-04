import { defineStore } from 'pinia'
import router from '../router'
import axios from 'axios'
import useGeneralStore from './general.js'

const useUserStore = defineStore('user', {
  state: () => ({
    storedUser: JSON.parse(localStorage.getItem('user')) || null,
    token: localStorage.getItem('token') || null,
    totalUsers:  0
  }),

  getters: {
    userIsLoggedIn: (state) => state.storedUser !== null && state.token !== null,
    getToken: (state) => state.token,
    getUserRole: (state) => state.storedUser?.role || null,
    getTotalUsers: (state) => state.totalUsers,
    API_URL: () => useGeneralStore().API_URL
  },

  actions: {
    storeLoggedInUser(user, token) {
      localStorage.setItem('user', JSON.stringify(user))
      localStorage.setItem('token', token)
      this.storedUser = user
      this.token = token

      switch (user.role) {
        case 'admin':
          router.push({ name: 'adminDashboard' })
          break
        case 'doorman':
          router.push({ name: 'doorman' })
          break
        case 'host':
          router.push({ name: 'hostDashboard' })
          break
        default:
          router.push({ name: 'home' })
          break
      }
    },
    
    logoutUser() {
      localStorage.removeItem('user')
      localStorage.removeItem('token')
      localStorage.removeItem('totalUsers')
      this.storedUser = null
      this.token = null
      this.totalUsers = null
      router.push({ name: 'home' })
    },

    async fetchUsers() {
      try {
        const API_URL = this.API_URL 
        const response = await axios.get(`${API_URL}users`, {
          headers: {
            Authorization: `Bearer ${this.token}`
          }
        })
        this.totalUsers = response.data.total
        localStorage.setItem('totalUsers', this.totalUsers)
        console.log('Total', this.totalUsers)
      } catch (error) {
        console.error('Error fetching user info:', error)
      }
    }
  }
})

export default useUserStore

import { defineStore } from 'pinia'
import router from '../router'
import axios from 'axios'
import useGeneralStore from './general.js'

const useUserStore = defineStore('user', {
  state: () => {
    let storedUser = null
    let token = null
    // let userId = localStorage.getItem('userId');

    try {
      storedUser = JSON.parse(localStorage.getItem('user'))
    } catch (error) {
      console.error('Failed to parse stored user:', error)
    }

    token = localStorage.getItem('token')

    return {
      storedUser: storedUser || null,
      token: token || null,
      totalUsers: localStorage.getItem('totalUsers') || 0,
      userId: localStorage.getItem('userId'), // Add userId to state
      userProfile: null // Add userProfile to state
    }
  },

  getters: {
    userIsLoggedIn: (state) => state.storedUser !== null && state.token !== null,
    getToken: (state) => state.token,
    getUserId: (state) => state.userId,
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
          router.push({ name: 'doormanHome' })
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
      localStorage.removeItem('userId')
      this.storedUser = null
      this.token = null
      this.totalUsers = 0
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

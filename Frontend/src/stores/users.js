import { defineStore } from 'pinia'
import router from '../router'

const useUserStore = defineStore('user', {
  state: () => ({
    storedUser: JSON.parse(localStorage.getItem('user')) || null,
    token: localStorage.getItem('token') || null
  }),
  getters: {
    userIsLoggedIn: (state) => state.storedUser !== null && state.token !== null,
    getToken: (state) => state.token,
    getUserRole: (state) => state.storedUser?.role || null // Return the role or null if not set
  },
  actions: {
    storeLoggedInUser(user, token) {
      // Save the user to localStorage
      localStorage.setItem('user', JSON.stringify(user))
      localStorage.setItem('token', token)

      // Save the user and the token to the store state
      this.storedUser = user
      this.token = token

      // Route user based on role
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

      this.storedUser = null
      this.token = null
      router.push({ name: 'home' })
    }
  }
})

export default useUserStore

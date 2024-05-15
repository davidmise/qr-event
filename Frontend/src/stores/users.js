import { defineStore } from 'pinia'
import router from '../router'

const useUserStore = defineStore('user', {
  state: () => ({
    storedUser: localStorage.getItem('user') || null,
    token: localStorage.getItem('token') || null
  }),
  getters: {
    userIsLoggedIn: (state) => state.storedUser !== null && state.token !== null,
    getToken: (state) => state.token
  },
  actions: {
    storeLoggedInUser(user, token) {
      const _this = this

      // Save the user to localStorage
      localStorage.setItem('user', JSON.stringify(user))
      localStorage.setItem('token', token)

      // Save the user and the token to the store state
      _this.storedUser = user
      _this.token = token

      router.push({ name: 'home' })
    },
    // Add other actions like logout
    logoutUser() {
      localStorage.removeItem('user')
      localStorage.removeItem('token')

      this.storedUser = null
      this.token = null
      router.push({ name: 'login' })
    }
  }
})

export default useUserStore

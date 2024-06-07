import { defineStore } from 'pinia'
import axios from 'axios'
import useUserStore from './users.js' // Import useUserStore
import useGeneralStore from './general.js'

const useGuestStore = defineStore('guest', {
  state: () => ({
    //   storedClient: localStorage.getItem('client') || null,
    totalGuests: 0
  }),

  getters: {
    //   UserIsStoredL: (state) => state.storedClient !== null,
    getTotalGuests: (state) => state.totalGuests,
    authToken: () => useUserStore().token,
    API_URL: () => useGeneralStore().API_URL
  },
  actions: {
    async fetchGuests() {
      try {
        const token = this.authToken // Use token getter
        const API_URL = this.API_URL
        const response = await axios.get(`${API_URL}guest-list`, {
          headers: {
            Authorization: `Bearer ${token}`
          }
        })
        this.totalGuests = response.data.total
        localStorage.setItem('totalGuests', this.totalGuests)
        console.log('Total', this.totalGuests)
      } catch (error) {
        console.error('Error fetching Guest info:', error)
      }
    }
  }
})
export default useGuestStore

import { defineStore } from 'pinia'
import axios from 'axios'
import useUserStore from './users.js' // Import useUserStore
import useGeneralStore from './general.js'

const useClientStore = defineStore('client', {
  state: () => ({
    //   storedClient: localStorage.getItem('client') || null,
    totalClients: 0
  }),

  getters: {
    //   UserIsStoredL: (state) => state.storedClient !== null,
    getTotalClients: (state) => state.totalClients,
    authToken: () => useUserStore().token,
    API_URL: () => useGeneralStore().API_URL
  },
  actions: {
    async fetchClients() {
      try {
        const token = this.authToken // Use token getter
        const API_URL = this.API_URL
        const response = await axios.get(`${API_URL}all-clients`, {
          headers: {
            Authorization: `Bearer ${token}`
          }
        })
        this.totalClients = response.data.total
        localStorage.setItem('totalClients', this.totalClients)
        console.log('Total', this.totalClients)
      } catch (error) {
        console.error('Error fetching clients info:', error)
      }
    }
  }
})
export default useClientStore

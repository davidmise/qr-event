import { defineStore } from 'pinia'
import axios from 'axios'
import useUserStore from './users.js' // Import useUserStore
import useGeneralStore from './general.js'

const useEventStore = defineStore('event', {
  state: () => ({
    storedEvent: localStorage.getItem('event') || null,
    totalEvents: 0
  }),

  getters: {
    UserIsStoredL: (state) => state.storedEvent !== null,
    getTotalEvents: (state) => state.totalEvents,
    authToken: () => useUserStore().token,
    API_URL: () => useGeneralStore().API_URL
  },

  actions: {
    storeEvent(event) {
      const _this = this
      localStorage.setItem('event', JSON.stringify(event))
      _this.storedEvent = event
      // router.push({name: 'home'})
      console.log(event)

      // Save the event to the Store State

      _this.storeEvent = event
    },
    async fetchEvents() {
      try {
        const token = this.authToken // Use token getter
        const API_URL = this.API_URL
        const response = await axios.get(`${API_URL}all-events`, {
          headers: {
            Authorization: `Bearer ${token}`
          }
        })
        this.totalEvents = response.data.total
        localStorage.setItem('totalEvents', this.totalEvents)
        console.log('Total', this.totalEvents)
      } catch (error) {
        console.error('Error fetching events info:', error)
      }
    }
  }
})

export default useEventStore

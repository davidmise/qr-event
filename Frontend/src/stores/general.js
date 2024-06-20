import { defineStore } from 'pinia'

const useGeneralStore = defineStore('general', {
  state: () => ({
    //
    API_URL: 'http://127.0.0.1:8000/api/'
  }),
  getters: {},

  actions: {}
})

export default useGeneralStore

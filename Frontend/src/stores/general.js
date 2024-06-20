import { defineStore } from 'pinia'

const useGeneralStore = defineStore('general', {
  state: () => ({
    //
    API_URL: 'https://20a14069f78254864da24b0c1c09196a.serveo.net/api/'
  }),
  getters: {},

  actions: {}
})

export default useGeneralStore

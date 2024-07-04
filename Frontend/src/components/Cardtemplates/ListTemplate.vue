<template>
  <div class="row justify-content-center">
    <div class="col-12 col-lg-10 col-xl-8 col-xxl-7">
      <div class="row gy-4">
        <div class="col-12 col-sm-6" v-for="cardTemplate in cardTemplates" :key="cardTemplate.id">
          <div class="card widget-card border-light shadow-sm" style="cursor: pointer">
            <div class="card-body">
              <div class="row">
                <div class="col-8">
                  <h5 class="card-title widget-card-title mb-3">
                    {{ cardTemplate.name }}
                  </h5>
                </div>
                <div class="col-4">
                  <div class="d-flex justify-content-end">
                    <img
                      :src="serverPath + cardTemplate.path"
                      class="img img-thumbnail"
                      alt=""
                      width="200px"
                      height="200px"
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import { mapState } from 'pinia'
import useGeneralStore from '@/stores/general'

export default {
  data() {
    return {
      cardTemplates: [],
      serverPath: 'http://127.0.0.1:8000/storage/',
      
    }
  },
  computed: {
    ...mapState(useGeneralStore, ['API_URL'])
  },
  created() {
    this.getCardTemplates()
  },
  methods: {
    getCardTemplates() {
      axios
        .get(`${this.API_URL}templates`)
        .then((response) => {
          this.cardTemplates = response.data
        })
        .catch((error) => {
          console.log(error)
        })
    }
  }
}
</script>

<style scoped>
/* Add your styles here */
</style>

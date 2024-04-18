<script setup>
import Sidebar from '@/components/Bars/Sidebar/SideBar.vue';
import { sidebarWidth } from '@/components/Bars/Sidebar/state';
import TopBar from '@/components/Bars/TopBar/TopBar.vue';
import axios from "axios"
</script>


<template>
  <div>
    <Sidebar />
    <div :style="{ marginLeft: sidebarWidth, transition: 'margin 0.8s' }">
      <TopBar />
      <main class="py-6 bg-surface-secondary">
        <div class="container-fluid">
          <main class="py-6 bg-surface-secondary">
            <div>
              <label for="guestName">Name:</label>
              <input type="text" id="guestName" v-model="qrData.Guest.name">
              <br>
              <label for="guestEmail">Email:</label>
              <input type="email" id="guestEmail" v-model="qrData.Guest.email">
              <br>
              <label for="guestPhone">Phone Number:</label>
              <input type="text" id="guestPhone" v-model="qrData.Guest.phone_number">
              <br>
              <button class="btn btn-outline-success" @click="fetchQrCodeData">view</button>
            </div>
            <img :src="qrCode" alt="QR Code" width="100px">
            <div class="car">
            </div>
          </main>
        </div>
      </main>
    </div>
  </div>
</template>
<script>

export default {
  data() {
    return {
      qrCode: '',
      qrData: {
        Guest: {
          name: '',
          email: '',
          phone_number: ''
        }
      }
    }
  },
  // computed: {
  //   sidebarWidth() {
  //     return this.$store.state.sidebarWidth
  //   }
  // },
  methods: {
    async fetchQrCodeData() {
      // this.$store.dispatch('fetchQrCodeData', this.qrData.value)
      try {
        const response = await axios.post('http://127.0.0.1:8000/api/generate-qrcode', this.qrData.Guest);
        this.qrCode = 'data:image/svg+xml;base64,' + btoa(response.data.qr_code);
      } catch (error) {
        console.error('Error fetching QR code:', error);
      }
    },


  }
}

</script>




<style scoped>
/* Add any component-specific styles here */
</style>

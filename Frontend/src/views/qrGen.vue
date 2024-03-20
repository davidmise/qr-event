<script setup>
  import Sidebar from '@/components/Bars/Sidebar/SideBar.vue';
  import { sidebarWidth } from '@/components/Bars/Sidebar/state';
  import TopBar from '@/components/Bars/TopBar/TopBar.vue';
</script>

<template>
  <div>
    <Sidebar/>
    <div :style="{ marginLeft: sidebarWidth, transition: 'margin 0.8s' }">
      <TopBar/>
      <main class="py-6 bg-surface-secondary">
        <div class="container-fluid">
            <main class="py-6 bg-surface-secondary">
              <div>
                <input type="text" v-model="qrData">
                <button class="btn btn-outline-success" @click="fetchQrCodeData">view</button>
              <img :src="qrCode" alt="QR Code" width="100px">
              <div class="car">
                
              </div>
            </div>
            </main>
          </div>
        </main>
    </div>
  </div>
</template>

<script>
import axios from "axios"
export default {
  data() {
    return {
      qrCode: '',
      qrData: ''
    };
  },
  mounted() {
    // Assuming you have a method to fetch QR code data from the backend
  //   this.fetchQrCodeData();
  console.log(this.qrData)
  },
  methods: {
    fetchQrCodeData() {
      var qrCodeData = this.qrData
      // Assuming you're using axios for HTTP requests
      axios.post('http://127.0.0.1:8003/api/generate-qrcode', {
          data: qrCodeData
          // Adjust data as needed
      })
      .then(response => {
        // Assuming the response contains the SVG QR code
        this.qrCode = 'data:image/svg+xml;base64,' + btoa(response.data.qr_code);
        console.log(this.qrCode);
        console.log(response.data);
      })
      .catch(error => {
        console.error('Error fetching QR code:', error);
      });
    }
  }
};
</script>

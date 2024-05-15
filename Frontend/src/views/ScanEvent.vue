<template>
  <div>
    <video ref="video" autoplay></video>
    <button @click="scanQRCode">Scan QR Code</button>
  </div>
</template>

<script>
import Quagga from 'quagga' // Import QuaggaJS library
import axios from 'axios' // Import

export default {
  methods: {
    scanQRCode() {
      const videoElement = this.$refs.video

      Quagga.init(
        {
          inputStream: {
            name: 'Live',
            type: 'LiveStream',
            target: videoElement
          },
          decoder: {
            readers: ['code_128_reader'] // Specify QR code reader type
          }
        },
        function (err) {
          if (err) {
            console.error(err)
            return
          }
          Quagga.start()
        }
      )

      Quagga.onDetected(this.handleDetection)
    },

    handleDetection(result) {
      const qrCodeData = result.codeResult.code // Extract QR code data
      this.recordAttendance(qrCodeData)
    },

    async recordAttendance(qrCodeData) {
      try {
        const response = await axios.post('YOUR_BACKEND_ENDPOINT_URL', { qrCodeData })
        console.log('Attendance recorded:', response.data)
        // Display success message or update UI accordingly
      } catch (error) {
        console.error('Error recording attendance:', error)
        // Display error message or update UI accordingly
      }
    }
  },

  beforeUnmount() {
    Quagga.stop() // Stop camera when component is destroyed
  }
}
</script>

<style>
/* Add your styles here */
</style>

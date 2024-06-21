<template>
  <div>
    <div class="d-flex align-items-center mb-3">
      <p class="mb-0 me-3">Scan QR Code:</p>
      <button class="btn btn-primary" @click="startScan">Start Scan</button>
    </div>
    <StreamBarcodeReader
      v-if="isScannerActive"
      @decode="onDecode"
      @loaded="onLoaded"
    ></StreamBarcodeReader>
    <div v-if="decodedText">
      <p>Decoded QR Code Data: {{ decodedText }}</p>
    </div>
    <Loader v-if="isLoading" />
  </div>
</template>

<script>
import axios from 'axios'
import { StreamBarcodeReader } from 'vue-barcode-reader'
import useUserStore from '@/stores/users' // Ensure this path is correct
import useEventStore from '@/stores/eventinfo' // Ensure this path is correct
import useGeneralStore from '@/stores/general'
import Loader from '@/components/CssLoader.vue'
import { mapState } from 'pinia'

export default {
  components: {
    StreamBarcodeReader,
    Loader
  },
  data() {
    return {
      decodedText: null,
      isScannerActive: false, // Flag to track scanner activation
      isLoading: false // Flag to track loading state
    }
  },
  computed: {
    ...mapState(useGeneralStore, ['API_URL']),
    ...mapState(useUserStore, ['token']),
    ...mapState(useEventStore, ['totalEvents'])
  },
  methods: {
    async onDecode(text) {
      this.decodedText = text
      console.log(`Decoded text from QR code is ${text}`)
      // Parse the JSON data from the QR code
      const qrData = JSON.parse(text)
      console.log(`Parsed QR data:`, qrData)

      if (qrData && qrData.guest_id && qrData.event_info_id) {
        this.isLoading = true // Start loading
        try {
          const response = await axios.post(
            `${this.API_URL}mark-attendance`,
            {
              guest_id: qrData.guest_id,
              event_info_id: qrData.event_info_id
            },
            {
              headers: {
                Authorization: `Bearer ${this.token}`
              }
            }
          )

          console.log('API response:', response.data)

          if (response.data.status) {
            alert('Attendance marked successfully')
          } else {
            alert('Failed to mark attendance: ' + response.data.message)
          }
        } catch (error) {
          console.error('Error marking attendance:', error)
          // Enhanced error handling
          if (error.response) {
            console.log('Error data:', error.response.data)
            console.log('Error status:', error.response.status)
            console.log('Error headers:', error.response.headers)
            alert(`Error marking attendance: ${error.response.data.message || 'Unknown error'}`)
          } else if (error.request) {
            console.log('Error request:', error.request)
            alert('Network error: No response received from the server')
          } else {
            console.log('Error message:', error.message)
            alert(`Error marking attendance: ${error.message}`)
          }
        } finally {
          this.isLoading = false // End loading
        }
      } else {
        alert('Invalid QR code data')
      }
    },
    onLoaded() {
      console.log('Ready to start scanning barcodes')
    },
    startScan() {
      this.isScannerActive = true
    }
  }
}
</script>

<template>
  <div>
    <div class="d-flex align-items-center mb-3">
      <p class="mb-0 me-3">Scan QR Code:</p>
      <button class="btn btn-primary" @click="startScan">Start Scan</button>
    </div>
    <StreamBarcodeReader v-if="isScannerActive" @decode="onDecode" @loaded="onLoaded"></StreamBarcodeReader>
    <div v-if="decodedText">
      <p>Decoded QR Code Data: {{ decodedText }}</p>
    </div>
  </div>
</template>

<script>
import { StreamBarcodeReader } from "vue-barcode-reader";

export default {
  components: {
    StreamBarcodeReader,
  },
  data() {
    return {
      decodedText: null,
      isScannerActive: false, // Flag to track scanner activation
    };
  },
  methods: {
    onDecode(text) {
      this.decodedText = text;
      console.log(`Decoded text from QR code is ${text}`);
      // Optionally, you can perform actions with the decoded text here
    },
    onLoaded() {
      console.log(`Ready to start scanning barcodes`);
    },
    startScan() {
      this.isScannerActive = true;
    },
  },
};
</script>

<template>
    <div class="container">
      <div id="invitation-card-template" ref="invitationCardTemplate" class="invitation-card">
        <!-- Dynamic Template Image -->
        <img :src="templateImageUrl" class="template-image" />
  
        <!-- Dynamic Event Details -->
        <div v-if="eventName" class="event-name" :style="eventNameStyle">{{ eventName }}</div>
        <div v-if="eventDate" class="event-date" :style="eventDateStyle">{{ eventDate }}</div>
        <div v-if="eventTime" class="event-time" :style="eventTimeStyle">{{ eventTime }}</div>
        <div v-if="eventAddress" class="event-address" :style="eventAddressStyle">{{ eventAddress }}</div>
  
        <!-- Dynamic Guest Name -->
        <div v-if="guestName" class="guest-name" :style="guestNameStyle">{{ guestName }}</div>
  
        <!-- Dynamic QR Code -->
        <div id="qrcode" class="qr-code" :style="qrCodeStyle"></div>
      </div>
      <button @click="generateInvitationCard">Generate Invitation Card</button>
    </div>
  </template>
  
  <script>
  import QRCode from 'qrcode';
  import html2canvas from 'html2canvas';
  import axios from 'axios';
  import useGeneralStore from '@/stores/general'
  import useUserStore from '@/stores/users'
  import { mapState } from 'pinia'
  
  export default {
    data() {
      return {
        eventName: '', // Placeholder, will be fetched dynamically
        guestName: '', // Placeholder, will be fetched dynamically
        eventDate: '', // Placeholder, will be fetched dynamically
        eventTime: '', // Placeholder, will be fetched dynamically
        eventAddress: '', // Placeholder, will be fetched dynamically
        guestId: '', // Placeholder, will be fetched dynamically
        eventId: 1, // Example event ID
        templateImageUrl: '', // Path to the designer's template, will be fetched dynamically
        templateDetails: {}, // Placeholder for dynamic style details
        eventNameStyle: {},
        eventDateStyle: {},
        eventTimeStyle: {},
        eventAddressStyle: {},
        guestNameStyle: {},
        qrCodeStyle: {
          bottom: '20px', // Adjust according to the template
          left: '50%',
          transform: 'translateX(-50%)',
          position: 'absolute',
        },
      };
    },
    computed: {
      ...mapState(useGeneralStore, ['API_URL']),
      ...mapState(useUserStore, ['token']),
    },
    created(){
        this.fetchEventDetails();
        this.fetchGuestData();
  
    },
    methods: {
      async fetchEventDetails() {
        try {
          const response = await axios.get(`${this.API_URL}pull-event-info${this.eventId}`);
          const event = response.data;
          this.eventName = event.name;
          this.eventDate = event.date;
          this.eventTime = event.time;
          this.eventAddress = event.address;
          this.templateImageUrl = event.templateImageUrl; // Fetch the template image URL
          this.templateDetails = event.templateDetails; // Fetch the template details (styles)
  
          // Update styles dynamically
          this.eventNameStyle = this.templateDetails.eventNameStyle || {};
          this.eventDateStyle = this.templateDetails.eventDateStyle || {};
          this.eventTimeStyle = this.templateDetails.eventTimeStyle || {};
          this.eventAddressStyle = this.templateDetails.eventAddressStyle || {};
          this.guestNameStyle = this.templateDetails.guestNameStyle || {};
          this.qrCodeStyle = this.templateDetails.qrCodeStyle || this.qrCodeStyle;
        } catch (error) {
          console.error('Error fetching event details:', error);
        }
      },
      async fetchGuestData() {
        try {
          const response = await axios.get(`${this.API_URL}guests/${this.eventId}`);
          const guest = response.data;
          this.guestName = guest.name;
          this.guestId = guest.id;
        } catch (error) {
          console.error('Error fetching guest data:', error);
        }
      },
      async generateInvitationCard() {
        await this.fetchEventDetails();
        await this.fetchGuestData();
  
        // Generate QR code
        const qrCodeData = JSON.stringify({
          eventId: this.eventId,
          guestId: this.guestId,
        });
  
        const qrCodeUrl = await QRCode.toDataURL(qrCodeData);
        document.getElementById('qrcode').innerHTML = '';
        const img = new Image();
        img.src = qrCodeUrl;
        document.getElementById('qrcode').appendChild(img);
  
        // Convert the invitation card template to canvas
        const invitationCardTemplate = this.$refs.invitationCardTemplate;
        html2canvas(invitationCardTemplate).then((canvas) => {
          const imgData = canvas.toDataURL('image/png');
          const link = document.createElement('a');
          link.href = imgData;
          link.download = 'invitation-card.png';
          link.click();
        });
      },
    },
    mounted() {
      this.fetchEventDetails();
    },
  };
  </script>
  
  <style scoped>
  .container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100vh;
    background-color: #f8f8f8;
  }
  
  .invitation-card {
    width: 600px;
    height: 900px;
    position: relative;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
  }
  
  .template-image {
    width: 100%;
    height: 100%;
    border-radius: 10px;
  }
  
  .event-name,
  .event-date,
  .event-time,
  .event-address,
  .guest-name {
    text-align: center;
  }
  
  .qr-code {
    width: 100px;
    height: 100px;
  }
  </style>
  
<template>
  <div class="row">
    <article class="card fl-left">
      <!-- Qr code goes here -->
      <section class="date">
        <time datetime="23th feb">
          <img src="https://via.placeholder.com/150?text=qrCode" alt="QR Code" width="100px" />
          <!-- <span>23</span><span>feb</span> -->
        </time>
      </section>
      <section class="card-cont">
        <h3>{{ eventName }}</h3>
        <small>{{ eventSubtitle }}</small>

        <div class="even-date">
          <i class="bi bi-calendar"></i>
          <time>
            <span> {{ eventDate }} </span>
            <span>{{ eventStartTime }} to {{ eventEndTime }}</span>
          </time>
        </div>
        <div class="even-info">
          <i class="fa fa-map-marker"></i>
          <p>{{ street }}, {{ city }}, {{ country }}</p>
        </div>
        <a href="#">{{ eventPrice }}</a>
      </section>
    </article>
  </div>
</template>

<script>
import axios from 'axios'
import useGeneralStore from '@/stores/general'
import useUserStore from '@/stores/users'
import { mapState } from 'pinia'
export default {
  props: ['eventId'],

  data() {
    return {
      //   sidebarWidth,
      ticketId: null,
      eventInfo: null,
      eventName: '',
      eventSubtitle: '',
      eventDate: '',
      eventStartTime: '',
      eventEndTime: '',
      city: '',
      country: '',
      street: '',
      eventPrice: ''
    }
  },
  created() {
    const eventId = this.$route.params.eventId
    this.pullEventInfo(eventId)
  },
  computed: {
    ...mapState(useGeneralStore, ['API_URL']),
    ...mapState(useUserStore, ['token'])
  },
  methods: {
    async pullEventInfo(eventId) {
      try {
        const response = await axios.get(`${this.API_URL}pull-event-info${eventId}`, {
          headers: {
            Authorization: `Bearer ${this.token}`
          }
        })
        this.eventInfo = response.data.event
        this.eventName = response.data.event.event_name
        this.eventSubtitle = response.data.event.event_subtitle
        this.eventDate = response.data.event.start_date
        this.eventStartTime = response.data.event.start_time
        this.eventEndTime = response.data.event.end_time
        this.city = response.data.event.location.city
        this.country = response.data.event.location.country
        this.street = response.data.event.location.street
        this.eventPrice = response.data.event.ticket.price
        this.ticketId = response.data.event.ticket.id

        console.log(response.data.data)
        console.log(this.ticket)
      } catch (error) {
        console.error('Error fetching event info:', error)
        // Optionally, display an error message to the user
      }
    }
  }
}
</script>

<!-- @import url('https://fonts.googleapis.com/css?family=Oswald');/ -->
<style lang="css" scoped>
* {
  margin: 0;
  padding: 0;
  border: 0;
  box-sizing: border-box;
}

body {
  background-color: #dadde6;
  font-family: arial;
}

.fl-left {
  float: left;
}

.fl-right {
  float: right;
}

h1 {
  text-transform: uppercase;
  font-weight: 900;
  border-left: 10px solid #fec500;
  padding-left: 10px;
  margin-bottom: 30px;
}

.row {
  overflow: hidden;
}

.card {
  display: table-row;
  width: 100%;
  height: 60%;
  background-color: #fff;
  color: #989898;
  margin-bottom: 10px;
  font-family: 'Oswald', sans-serif;
  border-radius: 4px;
  position: relative;
}

.card + .card {
  margin-left: 2%;
}

.date {
  display: table-cell;
  width: 25%;
  position: relative;
  text-align: center;
  border-right: 2px dashed #dadde6;
}

.date:before,
.date:after {
  content: '';
  display: block;
  width: 30px;
  height: 30px;
  background-color: #dadde6;
  position: absolute;
  top: -15px;
  right: -15px;
  z-index: 1;
  border-radius: 50%;
}

.date:after {
  top: auto;
  bottom: -15px;
}

.date time {
  display: block;
  position: absolute;
  top: 50%;
  left: 50%;
  -webkit-transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);
}

.date time span {
  display: block;
}

.date time span:first-child {
  color: #2b2b2b;
  font-weight: 600;
  font-size: 250%;
}

.date time span:last-child {
  text-transform: uppercase;
  font-weight: 600;
  margin-top: -10px;
}

.card-cont {
  display: table-cell;
  width: 75%;
  font-size: 85%;
  padding: 10px 10px 30px 50px;
}

.card-cont h3 {
  color: #3c3c3c;
  font-size: 130%;
}

.card-cont > div {
  display: table-row;
}

.card-cont .even-date i,
.card-cont .even-info i,
.card-cont .even-date time,
.card-cont .even-info p {
  display: table-cell;
}

.card-cont .even-date i,
.card-cont .even-info i {
  padding: 5% 5% 0 0;
}

.card-cont .even-info p {
  padding: 30px 50px 0 0;
}

.card-cont .even-date time span {
  display: block;
}

.card-cont a {
  display: block;
  text-decoration: none;
  width: 80px;
  height: 30px;
  background-color: #d8dde0;
  color: #fff;
  text-align: center;
  line-height: 30px;
  border-radius: 2px;
  position: absolute;
  right: 10px;
  bottom: 10px;
}

.row:last-child .card:first-child .card-cont a {
  background-color: #037fdd;
}

.row:last-child .card:last-child .card-cont a {
  background-color: #f8504c;
}

@media screen and (max-width: 860px) {
  .card {
    display: block;
    float: none;
    width: 100%;
    margin-bottom: 10px;
  }
  .card + .card {
    margin-left: 0;
  }
  .card-cont .even-date,
  .card-cont .even-info {
    font-size: 75%;
  }
}
</style>

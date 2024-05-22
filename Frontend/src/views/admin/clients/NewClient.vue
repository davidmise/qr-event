<script setup>
import Sidebar from '@/components/Bars/Sidebar/SideBar.vue'
import { sidebarWidth } from '@/components/Bars/Sidebar/state'
import TopBar from '@/components/Bars/TopBar/TopBar.vue'
import axios from 'axios'
import useGeneralStore from '@/stores/general'
import { mapState } from 'pinia'
import useUserStore from '@/stores/users'
// import { useRouter } from "vue-router";
</script>

<template>
  <div>
    <Sidebar />
    <div :style="{ marginLeft: sidebarWidth, transition: 'margin 0.8s' }">
      <TopBar />
      <main class="py-6 bg-surface-secondary d-flex justify-content-center align-items-center">
        <div class="container-fluid">
          <main class="py-6 bg-surface-secondary ms-4">
            <div class="container">
              <h2 class="mb-3">Create Client</h2>
              <form action="" @submit.prevent="createEvent">
                <div class="container-fluid mb-5">
                  <!-- first row  -->
                  <div class="row mt-5">
                    <!-- Organizer Table -->
                    <div class="col-lg-5 col-md-6 col-sm-12">
                      <div class="card border-0 shadow form-group py-3 px-4">
                        <h5 class="text-secondary fw-bold">Client Info</h5>
                        <!-- <label for="name">Name</label> -->
                        <!-- event name -->
                        <div class="form-floating mb-3">
                          <input
                            type="text"
                            class="form-control"
                            id="floatingInput"
                            v-model="event_info.name"
                          />
                          <label for="floatingInput">Client Name</label>
                        </div>

                        <div class="form-floating mb-3">
                          <input
                            type="text"
                            class="form-control"
                            id="floatingInput"
                            v-model="event_info.email"
                          />
                          <label for="floatingInput">Client Email</label>
                        </div>

                        <!-- event subtitle -->
                        <div class="form-floating mb-3">
                          <input
                            type="text"
                            class="form-control"
                            id="floatingInput"
                            v-model="event_info.phone"
                          />
                          <label for="floatingInput">Client Phone</label>
                        </div>
                        <h5 class="text-secondary fw-bold">Pricing</h5>
                        <div class="form-floating mb-3">
                          <select
                            class="form-select form-select-lg"
                            aria-label="Large select example"
                            v-model="event_info.event_type"
                          >
                            <option disabled selected>Open this select menu</option>
                            <option value="conference">Conference</option>
                            <option value="Wedding">Wedding</option>
                            <option value="Exhibition">Exhibition</option>
                            <option value="Coorporate">Coorporate</option>
                            <option value="Seminars">Seminars</option>
                            <option value="Festivals">Festivals</option>
                            <option value="Others">Others</option>
                          </select>
                          <label for="floatingInput">Event Type</label>
                        </div>

                        <!-- <div class="form-floating mb-3">
                          <select
                            class="form-select form-select-lg"
                            aria-label="Large select example"
                            v-model="event_info.payment_method"
                          >
                            <option disabled selected>Open this select menu</option>
                            <option value="mpesa">M-Pesa</option>
                            <option value="tigo_pesa">Tigo Pesa</option>
                            <option value="airtel_money">Airtel Money</option>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="credit_card">Credit/Debit Card</option>
                            <option value="cash">Cash</option>
                            <option value="paypal">PayPal</option>
                            <option value="pesapal">PesaPal</option>
                          </select>
                          <label for="floatingInput">Payment Method</label>
                        </div>

                        <div v-if="event_info.payment_method" class="form-floating mb-3">
                          <input
                            type="text"
                            class="form-control"
                            id="paymentAccountInput"
                            v-model="event_info.payment_account"
                          />
                          <label for="paymentAccountInput">Payment Account Number</label>
                        </div> -->
                        <!-- <label for="name">Name</label> -->
                        <div class="form-floating mb-3">
                          <input
                            type="number"
                            class="form-control"
                            id="floatingInput"
                            v-model="event_info.event_capacity"
                          />
                          <label for="floatingInput">Event Capacity</label>
                        </div>
                        <div class="form-floating mb-3">
                          <input
                            type="number"
                            class="form-control"
                            id="floatingInput"
                            v-model="event_info.price"
                          />
                          <label for="floatingInput">Event Cost</label>
                        </div>
                      </div>

                      <!-- submit BUTTON -->
                      <div class="btn-container d-grid mt-5">
                        <button type="submit" class="btn btn-secondary btn-lg rounded">
                          Save Client
                        </button>
                      </div>
                    </div>
                  </div>
                  <!-- third row -->
                  <div class="row mb-2">
                    <!-- Event info column -->
                    <!-- event ... -->
                    <div class="col-lg-5 col-md-6 col-sm-12"></div>
                  </div>
                </div>
              </form>
            </div>
          </main>
        </div>
      </main>
    </div>
  </div>
</template>

<script>
export default {
  name: 'CreateEvent',
  data() {
    return {
      event_info: {
        event_name: '',
        event_subtitle: '',
        start_date: '',
        end_date: '',
        start_time: '',
        end_time: '',
        location: {
          city: '',
          state: '',
          country: '',
          postal_code: '',
          google_map_url: ''
        },
        organizer: {
          name: '',
          email: '',
          phone: ''
        },
        ticket: {
          price: '',
          event_capacity: ''
        },
        media: {
          poster: '',
          banner: '',
          logo: ''
        },
        social_links: {
          instagram: '',
          twitter: '',
          facebook: ''
        }
      }
    }
  },

  computed: {
    ...mapState(useGeneralStore, ['API_URL']),

    ...mapState(useUserStore, ['token'])
  },

  methods: {
    async createEvent() {
      try {
        const response = await axios.post(`${this.API_URL}create-event`, this.event_info, {
          headers: {
            Authorization: `Bearer ${this.token}`
          }
        })

        const event_id = response.data.event.event_info.id
        console.log(response.data.event)
        localStorage.setItem('event_id', event_id)
        console.log('this event id is: ' + event_id)
        this.resetForm()
        this.$router.push({ name: 'AllEvents' })
      } catch (error) {
        if (error.response && error.response.status === 500) {
          console.error('Internal server error:', error.response.data)
          // Show user-friendly error message (optional)
        } else {
          console.error('Error creating event:', error)
        }
      }

      // console.log(this.name, this.description, this.date, this.time, this.city, this.state, this.country, this.postalCode, this.googleMapUrl)
    },
    resetForm() {
      this.event_info = {
        event_name: '',
        event_subtitle: '',
        start_date: '',
        end_date: '',
        start_time: '',
        end_time: '',
        location: {
          city: '',
          state: '',
          country: '',
          postal_code: '',
          google_map_url: ''
        },
        organizer: {
          name: '',
          email: '',
          phone: ''
        },
        ticket: {
          price: '',
          event_capacity: ''
        },
        media: {
          poster: '',
          banner: '',
          logo: ''
        },
        social_links: {
          instagram: '',
          twitter: '',
          facebook: ''
        }
      }
    }
  }
}
</script>

<style scoped>
.centered-container {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  min-height: 80vh; /* Adjust as needed */
}
</style>

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
      <main class="py-6 bg-surface-secondary">
        <div class="container-fluid">
          <main class="py-6 bg-surface-secondary ms-4">
            <h2 class="mb-3">Create Event</h2>
            <form action="" @submit.prevent="createEvent">
              <div class="container mb-4">
                <div class="row">
                  <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card shadow border-0 py-3 px-4">
                      <label for="logoFile" class="form-label">Upload Logo</label>
                      <input
                        class="form-control form-control-md"
                        id="logoFile"
                        type="text"
                        v-model="event_info.logo"
                      />
                    </div>
                  </div>
                  <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card shadow border-0 py-3 px-4">
                      <label for="posterFile" class="form-label">Upload Poster</label>
                      <input
                        class="form-control form-control-md"
                        id="posterFile"
                        type="text"
                        v-model="event_info.poster"
                      />
                    </div>
                  </div>
                  <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card shadow border-0 py-3 px-4">
                      <label for="bannerFile" class="form-label">Upload Banner</label>
                      <input
                        class="form-control form-control-md"
                        id="bannerFile"
                        type="text"
                        v-model="event_info.banner"
                      />
                    </div>
                  </div>
                </div>
              </div>
              <div class="container mb-5">
                <!-- first row  -->
                <div class="row mb-2">
                  <!-- Event info column -->
                  <div class="col-lg-5 col-md-6 col-sm-12">
                    <div class="card border-0 shadow form-group py-3 px-4">
                      <h5 class="text-secondary fw-bold">Event info</h5>
                      <!-- <label for="name">Name</label> -->
                      <!-- event name -->
                      <div class="form-floating mb-3">
                        <input
                          type="text"
                          class="form-control"
                          id="floatingInput"
                          v-model="event_info.event_name"
                        />
                        <label for="floatingInput">Event Name</label>
                      </div>
                      <!-- event subtitle -->
                      <div class="form-floating mb-3">
                        <input
                          type="text"
                          class="form-control"
                          id="floatingInput"
                          v-model="event_info.event_subtitle"
                        />
                        <label for="floatingInput">Event Subtitle</label>
                      </div>
                      <!-- event duration (date) -->
                      <div class="row">
                        <div class="form-floating mb-3 col-lg-6 col-sm-12">
                          <input
                            type="date"
                            class="form-control"
                            id="floatingInput"
                            v-model="event_info.start_date"
                          />
                          <label for="floatingInput" class="ms-3">Starting Date </label>
                        </div>
                        <!-- event end date -->
                        <div class="form-floating mb-3 col-lg-6 col-sm-12">
                          <input
                            type="date"
                            class="form-control"
                            id="floatingInput"
                            v-model="event_info.end_date"
                          />
                          <label for="floatingInput" class="ms-3">Ending Date </label>
                        </div>
                      </div>
                      <!-- event duration (time) -->
                      <div class="row">
                        <div class="form-floating mb-3 col-lg-6 col-sm-12">
                          <input
                            type="time"
                            class="form-control"
                            id="floatingInput"
                            v-model="event_info.start_time"
                          />
                          <label for="floatingInput" class="ms-3">Starting time </label>
                        </div>
                        <!-- event end time -->
                        <div class="form-floating mb-3 col-lg-6 col-sm-12">
                          <input
                            type="time"
                            class="form-control"
                            id="floatingInput"
                            v-model="event_info.end_time"
                          />
                          <label for="floatingInput" class="ms-3">Ending time</label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- event ... -->
                  <div class="col-lg-5 col-md-6 col-sm-12">
                    <div class="card border-0 shadow form-group py-3 px-4">
                      <h5 class="text-secondary fw-bold">Ticketing</h5>
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
                        <label for="floatingInput">Ticket Price</label>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- second row -->
                <div class="row mt-5">
                  <!-- Event info column -->
                  <div class="col-lg-5 col-md-6 col-sm-12">
                    <div class="card border-0 shadow form-group py-3 px-4">
                      <h5 class="text-secondary fw-bold">Event Location</h5>
                      <!-- <label for="name">Name</label> -->
                      <!-- event name -->
                      <div class="form-floating mb-3">
                        <input
                          type="text"
                          class="form-control"
                          id="floatingInput"
                          v-model="event_info.city"
                        />
                        <label for="floatingInput">City</label>
                      </div>
                      <!-- event duration (date) -->
                      <div class="row">
                        <div class="form-floating mb-3 col-lg-6 col-sm-12">
                          <input
                            type="text"
                            class="form-control"
                            id="floatingInput"
                            v-model="event_info.postal_code"
                          />
                          <label for="floatingInput" class="ms-3">Postal Code </label>
                        </div>
                        <!-- event end date -->
                        <div class="form-floating mb-3 col-lg-6 col-sm-12">
                          <input
                            type="text"
                            class="form-control"
                            id="floatingInput"
                            v-model="event_info.street"
                          />
                          <label for="floatingInput" class="ms-3">Street </label>
                        </div>
                      </div>
                      <!-- event duration (time) -->
                      <div class="row">
                        <div class="form-floating mb-3 col-lg-12 col-sm-12">
                          <input
                            type="text"
                            class="form-control"
                            id="floatingInput"
                            v-model="event_info.country"
                          />
                          <label for="floatingInput" class="ms-3"> Country</label>
                        </div>
                        <!-- event end time -->
                        <!-- <div class="form-floating mb-3 col-lg-6 col-sm-12">
                          <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com">
                          <label for="floatingInput" class="ms-3">Postal </label>
                        </div> -->
                      </div>
                      <!-- event subtitle -->
                      <div class="form-floating mb-3">
                        <input
                          type="text"
                          class="form-control"
                          id="floatingInput"
                          v-model="event_info.google_map_url"
                        />
                        <label for="floatingInput">Google Map Url</label>
                      </div>
                    </div>
                  </div>
                  <!-- event ... -->
                  <div class="col-lg-5 col-md-6 col-sm-12">
                    <div class="card border-0 shadow form-group py-3 px-4">
                      <h5 class="text-secondary fw-bold">Social Links</h5>
                      <!-- <label for="name">Name</label> -->
                      <div class="input-group mb-3">
                        <span class="input-group-text"><i class="bi bi-instagram"></i></span>
                        <div class="form-floating">
                          <input
                            type="text"
                            class="form-control"
                            id="floatingInputGroup1"
                            v-model="event_info.instagram"
                          />
                          <label for="floatingInputGroup1">URL (Optional)</label>
                        </div>
                      </div>
                      <div class="input-group mb-3">
                        <span class="input-group-text"><i class="bi bi-twitter-x"></i></span>
                        <div class="form-floating">
                          <input
                            type="text"
                            class="form-control"
                            id="floatingInputGroup1"
                            v-model="event_info.twitter"
                          />
                          <label for="floatingInputGroup1">URL (Optional)</label>
                        </div>
                      </div>
                      <div class="input-group mb-3">
                        <span class="input-group-text"><i class="bi bi-facebook"></i></span>
                        <div class="form-floating">
                          <input
                            type="text"
                            class="form-control"
                            id="floatingInputGroup1"
                            v-model="event_info.facebook"
                          />
                          <label for="floatingInputGroup1">URL (Optional)</label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- third row -->
                <div class="row mt-5">
                  <!-- Organizer Table -->
                  <div class="col-lg-5 col-md-6 col-sm-12">
                    <div class="card border-0 shadow form-group py-3 px-4">
                      <h5 class="text-secondary fw-bold">Organizer Info</h5>
                      <!-- <label for="name">Name</label> -->
                      <!-- event name -->
                      <div class="form-floating mb-3">
                        <input
                          type="text"
                          class="form-control"
                          id="floatingInput"
                          v-model="event_info.name"
                        />
                        <label for="floatingInput">Organizer Name</label>
                      </div>

                      <div class="form-floating mb-3">
                        <input
                          type="text"
                          class="form-control"
                          id="floatingInput"
                          v-model="event_info.email"
                        />
                        <label for="floatingInput">Organizer Email</label>
                      </div>

                      <!-- event subtitle -->
                      <div class="form-floating mb-3">
                        <input
                          type="text"
                          class="form-control"
                          id="floatingInput"
                          v-model="event_info.phone"
                        />
                        <label for="floatingInput">Organizer Phone</label>
                      </div>
                    </div>
                    <!-- submit BUTTON -->
                    <div class="btn-container d-grid mt-5">
                      <button type="submit" class="btn btn-secondary btn-lg rounded">
                        Create Event
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
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
        this.$router.push({ name: 'adminEventsAll' })
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

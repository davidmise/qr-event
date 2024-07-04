<template>
  <section class="vh-100" style="background-color: #f4f5f7">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col col-lg-6 mb-4 mb-lg-0">
          <div class="card border-0 mb-3" style="border-radius: 0.5rem">
            <div class="row g-0">
              <div
                class="col-md-4 gradient-custom text-center text-white"
                style="border-top-left-radius: 0.5rem; border-bottom-left-radius: 0.5rem"
              >
                <img
                  src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp"
                  alt="Avatar"
                  class="img-fluid my-5"
                  style="width: 80px"
                />
                <h5>Organizer</h5>
                <p>{{ organizer.name }}</p>
                <p>{{ location.city }}</p>
                <i class="far fa-edit mb-5"></i>
                <div class="car" v-if="qrCodeVisible">
                  <img :src="qrCode" alt="QR Code" width="100px" />
                </div>
              </div>
              <div class="col-md-8">
                <div class="card-body p-4">
                  <h6>Information</h6>
                  <hr class="mt-0 mb-4" />
                  <div class="row pt-2">
                    <p>{{ organizer.phone }}</p>
                  </div>
                  <div class="row pt-1">
                    <div class="row gy-2 overflow-hidden">
                      <form @submit.prevent="generateAndDownloadTemplate">
                        <div class="col-12">
                          <div class="form-floating mb-3">
                            <input
                              type="text"
                              class="form-control border-0 border-bottom rounded-0"
                              name="name"
                              id="name"
                              placeholder="Degratus"
                              v-model="guestName"
                              required
                            />
                            <label for="name" class="form-label">Name</label>
                          </div>
                        </div>
                        <div class="col-12">
                          <div class="form-floating mb-3">
                            <input
                              type="email"
                              class="form-control border-0 border-bottom rounded-0"
                              name="email"
                              id="email"
                              placeholder="name@example.com"
                              v-model="email"
                              required
                            />
                            <label for="email" class="form-label">Email</label>
                          </div>
                        </div>
                        <div class="col-12">
                          <div class="form-floating mb-3">
                            <input
                              type="number"
                              class="form-control border-0 border-bottom rounded-0"
                              name="number"
                              id="number"
                              placeholder="0754323421"
                              v-model="phoneNumber"
                              required
                            />
                            <label for="number" class="form-label">Phone Number:</label>
                          </div>
                        </div>
                        <div class="col-12">
                          <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Register</button>
                          </div>
                        </div>
                      </form>
                      <div v-if="downloadLink">
                        <a
                          :href="downloadLink"
                          download="customized-invitation.png"
                          class="btn btn-success mt-3"
                          >Download Invitation</a
                        >
                      </div>
                    </div>
                  </div>
                  <div class="d-flex justify-content-start mt-3">
                    <a href="#!"><i class="bi bi-facebook fa-lg me-3"></i></a>
                    <a href="#!"><i class="bi bi-twitter fa-lg me-3"></i></a>
                    <a href="#!"><i class="bi bi-instagram fa-lg"></i></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <Loader v-if="isLoading" />
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import axios from 'axios'
import Swal from 'sweetalert2'
import Loader from '@/components/CssLoader.vue'
import useGeneralStore from '@/stores/general'
import { mapState } from 'pinia'
import useUserStore from '@/stores/users'

export default {
  data() {
    return {
      qrCodeVisible: false,
      eventInfo: '',
      location: '',
      organizer: '',
      media: '',
      ticket: '',
      social_Links: '',
      isLoading: false,
      qrCode: '',
      guestName: '',
      email: '',
      phoneNumber: '',
      downloadLink: null,
      qrData: {
        Guest: {
          name: '',
          email: '',
          phone_number: '',
          event_info_id: null
        }
      }
    }
  },
  components: {
    Loader
  },
  created() {
    const eventId = this.$route.params.eventId
    this.fetchEventInfo(eventId)
  },
  computed: {
    ...mapState(useGeneralStore, ['API_URL']),
    ...mapState(useUserStore, ['token'])
  },
  methods: {
    async fetchEventInfo(eventId) {
      this.isLoading = true
      try {
        const response = await axios.get(`${this.API_URL}pull-event-info${eventId}`)
        this.eventInfo = response.data.event
        this.location = response.data.event.location
        this.organizer = response.data.event.organizer
        this.media = response.data.event.media
        this.ticket = response.data.event.ticket
        this.social_Links = response.data.event.social_Links
        console.log(this.eventInfo, this.location, this.organizer, this.media)
      } catch (error) {
        this.handelErrorToast(error)
        console.error('Error fetching event info data:', error)
      } finally {
        this.isLoading = false
      }
    },
    async generateAndDownloadTemplate() {
      this.isLoading = true
      try {
        const response = await axios.post(`${this.API_URL}templates/generate`, {
          identifier: this.$route.params.eventId,
          guest_name: this.guestName,
          event_info_id: this.$route.params.eventId
        })
        this.downloadLink = `http://127.0.0.1:8000/storage/${response.data.path}`
        this.handelSuccessToast()
      } catch (error) {
        this.handelErrorToast(error)
        console.error('Error generating and downloading template:', error)
      } finally {
        this.isLoading = false
      }
    },
    handelErrorToast() {
      Swal.fire({
        icon: 'error',
        title: 'Submission Failed!',
        text: 'Try Again!'
      })
    },
    handelSuccessToast() {
      Swal.fire({
        icon: 'success',
        title: 'Added Successfully!'
      })
    }
  }
}
</script>

<style scoped>
input:focus {
  outline: none;
}
.gradient-custom {
  background: #f6d365;
  background: linear-gradient(to right bottom, rgba(246, 211, 101, 1), rgba(253, 160, 133, 1));
}
</style>

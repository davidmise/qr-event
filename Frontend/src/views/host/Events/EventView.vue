<template>
  <div>
    <Sidebar />
    <div :style="{ marginLeft: sidebarWidth, transition: 'margin 0.8s' }">
      <TopBar />
      <main class="py-6 bg-surface-secondary">
        <div class="container-fluid">
          <main class="py-6 bg-surface-secondary">
            <div class="container mb-5" v-if="eventInfo">
              <h1>{{ eventInfo.event_name }}</h1>
              <h6 class="text-secondary">{{ eventInfo.event_subtitle }}</h6>
              <p>
                Event date <span class="text-primary">{{ eventInfo.start_date }}</span>
              </p>
              <button :class="eventStatusClass">{{ eventStatus }}</button>
            </div>
            <!-- <hr> -->
            <EventsNav :eventId="eventId" />
          </main>
        </div>
      </main>
      <!-- Loader Component -->
      <Loader v-if="isLoading" />
    </div>
  </div>
</template>

<script>
import Sidebar from '@/components/Bars/Sidebar/SideBar.vue'
import { sidebarWidth } from '@/components/Bars/Sidebar/state'
import TopBar from '@/components/Bars/TopBar/TopBar.vue'
import EventsNav from '@/components/Events/EventsNav.vue'
import axios from 'axios'
import Loader from '@/components/CssLoader.vue'
import Swal from 'sweetalert2'
import { mapState } from 'pinia'
import useGeneralStore from '@/stores/general'
import useUserStore from '@/stores/users'

export default {
  components: {
    Sidebar,
    TopBar,
    EventsNav,
    Loader
  },

  data() {
    return {
      sidebarWidth,
      eventInfo: null,
      eventId: null,
      message: null,
      isLoading: false
    }
  },

  computed: {
    ...mapState(useGeneralStore, ['API_URL']),
    ...mapState(useUserStore, ['token']),
    eventStatus() {
      const eventDate = new Date(this.eventInfo.start_date)
      const currentDate = new Date()
      return eventDate > currentDate ? 'Valid' : 'Expired'
    },
    eventStatusClass() {
      return this.eventStatus === 'Valid' ? 'btn btn-outline-primary rounded rounded-5' : 'btn btn-outline-danger rounded rounded-5'
    }
  },

  created() {
    this.eventId = this.$route.params.eventId
    this.getEventInfo()
  },

  methods: {
    getEventInfo() {
      this.isLoading = true

      axios
        .get(`${this.API_URL}pull-event-info${this.eventId}`, {
          headers: {
            Authorization: `Bearer ${this.token}`
          }
        })
        .then((response) => {
          this.eventInfo = response.data.event
          console.log(this.eventInfo)
        })
        .catch((error) => {
          console.log(error)
          this.isLoading = false
          this.message = error.response.statusText

          this.handelErrorToast()
        })
        .then(() => {
          this.isLoading = false
        })
    },
    handelErrorToast() {
      Swal.fire({
        icon: 'error',
        title: 'An error has occurred',
        text: this.message
      })
    }
  }
}
</script>

<style>
.btn-outline-primary {
  color: #007bff;
  border-color: #007bff;
}

.btn-outline-danger {
  color: #dc3545;
  border-color: #dc3545;
}
</style>

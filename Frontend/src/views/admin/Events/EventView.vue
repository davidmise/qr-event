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
                Created at <span class="text-primary">{{ eventInfo.start_date }}</span>
              </p>
              <button class="btn btn-outline-primary rounded rounded-5">Valid/Expired</button>
            </div>
            <!-- <hr> -->
            <EventsNav :eventId="eventId" />
          </main>
        </div>
      </main>
    </div>
  </div>
</template>

<script>
import Sidebar from '@/components/Bars/Sidebar/SideBar.vue'
import { sidebarWidth } from '@/components/Bars/Sidebar/state'
import TopBar from '@/components/Bars/TopBar/TopBar.vue'
import EventsNav from '@/components/Events/EventsNav.vue'
import axios from 'axios'
import Swal from 'sweetalert2'

// import { ref, onMounted, watch } from 'vue';
// import { useRoute } from 'vue-router';
import { mapState } from 'pinia'
import useGeneralStore from '@/stores/general'
import useUserStore from '@/stores/users'

// const route = useRoute();
export default {
  components: {
    Sidebar,
    TopBar,
    EventsNav
  },

  data() {
    return {
      sidebarWidth,
      eventInfo: null,
      eventId: null,
      message: null,
    }
  },

  computed: {
    ...mapState(useGeneralStore, ['API_URL']),
    ...mapState(useUserStore, ['token'])
  },

  created() {
    this.eventId = this.$route.params.eventId
    this.getEventInfo()
  },
  methods: {
    getEventInfo() {
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
          this.isLoading = false // Set loading state to false after failed fetch
        this.message = error.response.statusText

        this.handelErrorToast()
        })
    },
    handelErrorToast() {
      Swal.fire({
        icon: 'error',
        title: 'An error has occurred',
        text: this.message
      })
    },
  }
}
</script>

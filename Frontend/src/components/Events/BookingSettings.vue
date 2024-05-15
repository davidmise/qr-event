<template>
  <div>
    <!-- <router-link to="/register-guest" target="_blank"> Invite guest </router-link> -->
    <router-link
      class="decoration-none"
      target="_blank"
      :to="{ name: 'register-guest', params: { eventId: eventId } }"
    >
      Invite guest
    </router-link>
  </div>
</template>
<script>
import axios from 'axios'
import useEventStore from '@/stores/eventinfo'
import useGeneralStore from '@/stores/general'
import useUserStore from '@/stores/users'
import { mapState, mapActions } from 'pinia'
export default {
  props: ['eventId'],
  data() {
    return {
      eventInfo: null,
      event_id: null
    }
  },

  created() {
    const eventId = this.$route.params.eventId
    this.pullEventInfo(eventId)
  },
  computed: {
    ...mapState(useGeneralStore, ['API_URL']),
    ...mapState(useUserStore, ['token']),
    ...mapState(useEventStore, ['event'])
  },

  methods: {
    ...mapActions(useEventStore, ['storeEvent']),

    async pullEventInfo(eventId) {
      try {
        const response = await axios.get(`${this.API_URL}pull-event-info${eventId}`, {
          headers: {
            Authorization: `Bearer ${this.token}`
          }
        })
        this.eventInfo = response.data.event
        console.log('eventInfo', this.eventInfo)
        this.event_id = response.data.event.id
        console.log('eventInfoID', this.event_id)
      } catch (error) {
        console.error('Error fetching event info:', error)
        // Optionally, display an error message to the user
      }
    }
  }
}
</script>

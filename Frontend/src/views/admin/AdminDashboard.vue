<template>
  <div>
    <Sidebar />
    <div :style="{ marginLeft: sidebarWidth, transition: 'margin 0.8s' }">
      <TopBar />
      <!-- Main -->
      <main class="py-6 bg-surface-secondary">
        <div class="container-fluid">
          <!-- Card stats -->
          <h2>Admin Dashboard</h2>
          <div class="row g-6 mb-6">
            <div class="col-xl-3 col-sm-6 col-12">
              <div class="card shadow border-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <span class="h6 font-semibold text-muted text-sm d-block mb-2">Events</span>
                      <span class="h3 font-bold mb-0">{{ totalEvents }} </span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-tertiary text-white text-lg rounded-circle">
                        <i class="bi bi-credit-card"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12">
              <div class="card shadow border-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <span class="h6 font-semibold text-muted text-sm d-block mb-2">Users</span>
                      <span class="h3 font-bold mb-0">{{ totalUsers }}</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-primary text-white text-lg rounded-circle">
                        <i class="bi bi-people"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12">
              <div class="card shadow border-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <span class="h6 font-semibold text-muted text-sm d-block mb-2">Clients</span>
                      <span class="h3 font-bold mb-0">{{ totalClients }}</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-info text-white text-lg rounded-circle">
                        <i class="bi bi-clock-history"></i>
                      </div>
                    </div>
                  </div>
                  <!-- <div class="mt-2 mb-0 text-sm">
                                <span class="badge badge-pill bg-soft-danger text-danger me-2">
                                    <i class="bi bi-arrow-down me-1"></i>-5%
                                </span>
                                <span class="text-nowrap text-xs text-muted">Since last month</span>
                            </div> -->
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12">
              <div class="card shadow border-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <span class="h6 font-semibold text-muted text-sm d-block mb-2">Guests</span>
                      <span class="h3 font-bold mb-0">{{ totalGuests }}</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-warning text-white text-lg rounded-circle">
                        <i class="bi bi-minecart-loaded"></i>
                      </div>
                    </div>
                  </div>
                  <!-- <div class="mt-2 mb-0 text-sm">
                                <span class="badge badge-pill bg-soft-success text-success me-2">
                                    <i class="bi bi-arrow-up me-1"></i>10%
                                </span>
                                <span class="text-nowrap text-xs text-muted">Since last month</span>
                            </div> -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
</template>
<script>
import Sidebar from '@/components/Bars/Sidebar/SideBar.vue'
import { sidebarWidth } from '@/components/Bars/Sidebar/state'
import TopBar from '@/components/Bars/TopBar/TopBar.vue'
import useUserStore from '@/stores/users' // Ensure this path is correct
import useEventStore from '@/stores/eventinfo' // Ensure this path is correct
import useClientStore from '@/stores/clients' // Ensure this path is correct
import useGuestStore from '@/stores/guests' // Ensure this path is correct
import { mapActions, mapState } from 'pinia'

export default {
  data() {
    return {}
  },
  setup() {
    const userStore = useUserStore()
    userStore.fetchUsers() // Fetch total users when the component is setup

    const eventStore = useEventStore()
    eventStore.fetchEvents() // Fetch total users when the component is setup

    const clientStore = useClientStore()
    clientStore.fetchClients() // Fetch total users when the component is setup

    const guestStore = useGuestStore()
    guestStore.fetchGuests() // Fetch total users when the component is setup

    return {
      sidebarWidth
    }
  },
  computed: {
    ...mapState(useUserStore, ['totalUsers']),
    ...mapState(useEventStore, ['totalEvents']),
    ...mapState(useClientStore, ['totalClients']),
    ...mapState(useGuestStore, ['totalGuests'])
  },
  components: {
    Sidebar,
    TopBar
  },
  methods: {
    ...mapActions(useUserStore, ['fetchUsers']),
    ...mapActions(useEventStore, ['fetchEvents']),
    ...mapActions(useClientStore, ['fetchClients']),
    ...mapActions(useGuestStore, ['totalGuests'])
  }
}
</script>

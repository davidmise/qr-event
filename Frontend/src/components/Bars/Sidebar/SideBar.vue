<template>
  <div class="sidebar background-radial-gradient" :style="{ width: sidebarWidth }">
    <!-- Admin -->
    <div class="container" v-if="isAdmin">
      <h1>
        <span v-if="collapsed">
          <div>Q</div>
          <div>R</div>
        </span>
        <span v-else>Admin Dashboard</span>
      </h1>
    </div>

    <!-- host -->
    <div class="container" v-if="isHost">
      <h1>
        <span v-if="collapsed">
          <div>H</div>
          <div>D</div>
        </span>
        <span v-else>Host Dashboard</span>
      </h1>
    </div>

    <!-- Router - links -->
    <!-- Dashboard -->
    <div class="collapse-container">
      <a
        class="btn text-uppercase"
        data-bs-toggle="collapse"
        href="#Dashboard"
        role="button"
        aria-expanded="false"
        aria-controls="Dashboard"
      >
        <i class="material-icons icon">home</i>
        <span v-if="!collapsed" class="ms-3">Home</span>
      </a>
      <div class="collapse" id="Dashboard">
        <SideBarLink to="/" :text="collapsed ? '' : 'Dashboard'" />
      </div>
    </div>

    <!-- Admin Router-->
    <div v-if="isAdmin" class="collapse-container">
      <a
        class="btn text-uppercase"
        data-bs-toggle="collapse"
        href="#events"
        role="button"
        aria-expanded="false"
        aria-controls="Recieved"
      >
        <i class="material-icons icon">event</i>
        <span v-if="!collapsed" class="ms-3">Events</span>
      </a>
      <!-- <div class="collapse" id="events">
        <SideBarLink to="/admin/events/view" :text="collapsed ? '' : 'Events'" />
      </div> -->
      <div class="collapse" id="events">
        <SideBarLink to="/admin/events/new" :text="collapsed ? '' : 'Create New Event'" />
      </div>
      <div class="collapse" id="events">
        <SideBarLink to="/admin/events/events/all" :text="collapsed ? '' : 'All Events'" />
      </div>
      <!-- User  -->
      <a
        class="btn text-uppercase"
        data-bs-toggle="collapse"
        href="#users"
        role="button"
        aria-expanded="false"
        aria-controls="Recieved"
      >
        <i class="material-icons icon">person</i>
        <span v-if="!collapsed" class="ms-3">Users</span>
      </a>
      <div class="collapse" id="users">
        <SideBarLink to="/admin/users/new" :text="collapsed ? '' : 'Create New User'" />
      </div>
      <div class="collapse" id="users">
        <SideBarLink to="/admin/users/all" :text="collapsed ? '' : 'All Users'" />
      </div>
    </div>

    <!-- Host Router -->
    <div v-if="isHost" class="collapse-container">
      <a
        class="btn text-uppercase"
        data-bs-toggle="collapse"
        href="#events"
        role="button"
        aria-expanded="false"
        aria-controls="Recieved"
      >
        <i class="material-icons icon">event</i>
        <span v-if="!collapsed" class="ms-3">Events</span>
      </a>
      <!-- <div class="collapse" id="events">
    <SideBarLink to="/events/view" :text="collapsed ? '' : 'Events'" />
  </div> -->
      <div class="collapse" id="events">
        <SideBarLink to="/host/events/new" :text="collapsed ? '' : 'New Event'" />
      </div>
      <div class="collapse" id="events">
        <SideBarLink to="/host/events/all" :text="collapsed ? '' : 'All Events'" />
      </div>
      <a
        class="btn text-uppercase"
        data-bs-toggle="collapse"
        href="#clients"
        role="button"
        aria-expanded="false"
        aria-controls="Recieved"
      >
        <i class="material-icons icon">event</i>
        <span v-if="!collapsed" class="ms-3">Clients</span>
      </a>
      <div class="collapse" id="clients">
        <SideBarLink :to="{ name: 'hostClientsNew' }" :text="collapsed ? '' : 'New Client'" />
      </div>
      <div class="collapse" id="clients">
        <SideBarLink :to="{ name: 'hostClientsAll' }" :text="collapsed ? '' : 'All Clients'" />
      </div>
    </div>
    <!-- Contacts -->
    <div v-if="isDoorman" class="collapse-container">
      <a
        class="btn text-uppercase"
        data-bs-toggle="collapse"
        href="#Contacts"
        role="button"
        aria-expanded="false"
        aria-controls="Expenses"
      >
        <i class="material-icons icon">person</i>
        <span v-if="!collapsed" class="ms-3">person</span>
      </a>
      <div class="collapse" id="Contacts">
        <SideBarLink to="/contacts" :text="collapsed ? '' : 'Doorman'" />
      </div>
      <div class="collapse" id="Contacts">
        <SideBarLink to="/contacts" :text="collapsed ? '' : 'Doorman'" />
      </div>
    </div>
    <!-- Sidebar Collapse Icon -->
    <span class="collapse-icon" :class="{ 'rotate-180': collapsed }" @click="toggleSidebar">
      <i class="bi bi-chevron-double-left"></i>
    </span>
  </div>
</template>

<script>
import SideBarLink from './SideBarLink.vue'
import { collapsed, toggleSidebar, sidebarWidth } from './state'
import useUserStore from '@/stores/users' // Adjust the path as necessary
import { computed } from 'vue'

export default {
  components: { SideBarLink },
  setup() {
    const userStore = useUserStore()
    const isHost = computed(() => ['host'].includes(userStore.getUserRole))
    const isDoorman = computed(() => ['doorman'].includes(userStore.getUserRole))
    const isAdmin = computed(() => ['admin'].includes(userStore.getUserRole))

    return {
      collapsed,
      toggleSidebar,
      sidebarWidth,
      isHost,
      isDoorman,
      isAdmin
    }
  }
}
</script>

<style scoped>
:root {
  --sidebar-bg-color: #2f855a;
  --sidebar-item-hover: hsl(218, 41%, 15%);
  --sidebar-item-active: #f4faf8;
}

.btn {
  color: aliceblue;
}

.sidebar {
  color: rgb(125, 122, 122);
  float: left;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  bottom: 0;
  padding: 0.5em;
  transition: width 0.7s ease;
  display: flex;
  flex-direction: column;
}

.background-radial-gradient {
  background-color: hsl(218, 41%, 15%);
  background-image: radial-gradient(
      650px circle at 0% 0%,
      hsl(218, 41%, 35%) 15%,
      hsl(218, 41%, 30%) 35%,
      hsl(218, 41%, 20%) 75%,
      hsl(218, 41%, 19%) 80%,
      transparent 100%
    ),
    radial-gradient(
      1250px circle at 100% 100%,
      hsl(218, 41%, 45%) 15%,
      hsl(218, 41%, 30%) 35%,
      hsl(218, 41%, 20%) 75%,
      hsl(218, 41%, 19%) 80%,
      transparent 100%
    );
}

.collapse-icon {
  position: absolute;
  bottom: 0;
  padding: 0.9em;
  color: white;
  transition: 0.3s linear;
}

.rotate-180 {
  transform: rotate(180deg);
  transition: 0.2s linear;
}

.icon {
  font-size: 2rem; /* Adjust the icon size as needed */
}
</style>

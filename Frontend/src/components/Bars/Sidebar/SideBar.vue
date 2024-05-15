<template>
  <div class="sidebar background-radial-gradient" :style="{ width: sidebarWidth }">
    <h1>
      <span v-if="collapsed">
        <div>Q</div>
        <div>R</div>
      </span>
      <span v-else>Events</span>
    </h1>

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
        <SideBarLink to="/" :text="collapsed ? '' : 'Home'" />
      </div>
    </div>

    <!-- Events -->
    <div class="collapse-container">
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
      <div class="collapse" id="events">
        <SideBarLink to="/events/view" :text="collapsed ? '' : 'Events'" />
      </div>

      <div class="collapse" id="events">
        <SideBarLink to="/events/new" :text="collapsed ? '' : 'Create New Event'" />
      </div>

      <div class="collapse" id="events">
        <SideBarLink to="/events/all" :text="collapsed ? '' : 'All Events'" />
      </div>
    </div>

    <!-- Contacts -->
    <div class="collapse-container">
      <a
        class="btn text-uppercase"
        data-bs-toggle="collapse"
        href="#Contacts"
        role="button"
        aria-expanded="false"
        aria-controls="Expenses"
      >
        <i class="material-icons icon">contacts</i>
        <span v-if="!collapsed" class="ms-3">Contacts</span>
      </a>
      <div class="collapse" id="Contacts">
        <SideBarLink to="/contacts" :text="collapsed ? '' : 'Contacts'" />
      </div>
    </div>

    <!-- Report -->
    <!-- <div class="collapse-container">
        <a class="btn text-uppercase" data-bs-toggle="collapse" href="#report" role="button" aria-expanded="false" aria-controls="report">
          <i class="material-icons icon">assignment</i>
          <span v-if="!collapsed" class="ms-3">Report</span>
        </a>
        <div class="collapse" id="report">
          <SideBarLink to="/report"   :text="collapsed ? '' : 'Report'"  />
        </div>
      </div> -->

    <!-- Products
      <div class="collapse-container">
        <a class="btn text-uppercase" data-bs-toggle="collapse" href="#products" role="button" aria-expanded="false" aria-controls="products">
          <i class="material-icons icon">store</i>
          <span v-if="!collapsed" class="ms-3">Products</span>
        </a>
        <div class="collapse" id="products">
          <SideBarLink to="/products"  :text="collapsed ? '' : 'Products'" />
        </div>
      </div>
   -->
    <!-- Auth
      <div class="collapse-container"> 
        <a class="btn text-uppercase" data-bs-toggle="collapse" href="#auth" role="button" aria-expanded="false" aria-controls="auth">
          <i class="material-icons icon">person</i>
          <span v-if="!collapsed" class="ms-3">Auth</span>
        </a>
        <div class="collapse" id="auth">
          <SideBarLink to="/auth/Register"  :text="collapsed ? '' : 'Register'" />
          <SideBarLink to="/auth/login"  :text="collapsed ? '' : 'Login'" />
        </div>
      </div> -->

    <!-- Sidebar Collapse Icon -->
    <span class="collapse-icon" :class="{ 'rotate-180': collapsed }" @click="toggleSidebar">
      <i class="bi bi-chevron-double-left"></i>
    </span>
  </div>
</template>

<script>
import SideBarLink from './SideBarLink.vue'
import { collapsed, toggleSidebar, sidebarWidth } from './state'

export default {
  components: { SideBarLink },
  setup() {
    return {
      collapsed,
      toggleSidebar,
      sidebarWidth
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

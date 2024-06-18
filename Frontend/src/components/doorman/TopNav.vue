<template>
    <div class="container">
      <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
          <router-link class="navbar-brand" :to="{ name: 'doormanHome' }" >Events</router-link>
          <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="offcanvas"
            data-bs-target="#offcanvasRight"
            aria-controls="offcanvasRight"
          >
            <span class="navbar-toggler-icon"></span>
          </button>
        </div>
  
        <div
          class="offcanvas offcanvas-end"
          tabindex="-1"
          id="offcanvasRight"
          aria-labelledby="offcanvasRightLabel"
        >
          <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasRightLabel">Offcanvas right</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="offcanvas"
              aria-label="Close"
            ></button>
          </div>
          <div class="offcanvas-body">
            <!-- Off-canvas content goes here -->
            <nav class="nav flex-column">
                <router-link :to="{ name: 'doormanHome' }" class="dropdown-item" aria-current="page" >
                  <i class="material-icons">home</i> home </router-link> 
                  <br>
                <routerLink class="dropdown-item" :to="{ name: 'doormanProfile' }">
                  <i class="material-icons">person</i> Profile</routerLink>

                  <br>
                  <p @click="loggingOut === false && handleLogout()" class="dropdown-item">
                    <i class="material-icons">exit_to_app</i>
                    logout
                  </p>
              </nav>
          </div>
        </div>
      </nav>
    </div>
  </template>

  <script>
  import Swal from 'sweetalert2'
  // import Avatar from '@/components/AvatarImage.vue'
  import axios from 'axios'
  // import LogoutButton from '@/components/Buttons/LogoutButton.vue';
  import useUserStore  from '@/stores/users'
  import useGeneralStore from '@/stores/general'
  import { mapActions, mapState } from 'pinia'
  import { computed } from 'vue'
  export default {
    setup() {
      const userIsLoggedIn = computed(() => !!useUserStore.storedUser)
      // const API_URL = computed(() => useGeneralStore.API_URL);
      const userStore = useUserStore()
      const isHost = computed(() => ['host'].includes(userStore.getUserRole))
      const isDoorman = computed(() => ['doorman'].includes(userStore.getUserRole))
      const isAdmin = computed(() => ['admin'].includes(userStore.getUserRole))
  
      return {
        userAvatarUrl: 'src/assets/Images/Avatar/man.png',
        userIsLoggedIn,
        isHost,
        isDoorman,
        isAdmin,
        loggingOut: false
      }
    },
    methods: {
      ...mapActions(useUserStore, ['logoutUser']),
      logout() {
        axios
          .post(
            `${this.API_URL}logout`,
            {},
            {
              headers: {
                Authorization: `Bearer ${this.token}`
              }
            }
          )
          .then((response) => {
            console.log(response.data)
          })
          .catch((error) => {
            console.log(error.message)
          })
      },
      handleLogout() {
        Swal.fire({
          title: 'Are you sure?',
          text: 'You are about to log out',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, Log out!'
        }).then((result) => {
          if (result.isConfirmed) {
            Swal.fire({
              title: 'Session Expired!',
              text: 'You have been Logged out.',
              icon: 'success'
            })
            // localStorage.removeItem('user');
            this.logout()
            this.logoutUser()
            this.$emit('logged-out')
          }
        })
      }
    },
    computed: {
      ...mapState(useUserStore, ['storedUser', 'token'])
    },
    ...mapState(useGeneralStore, ['API_URL'])
  }
  </script>
  
  <style scoped>
  /* Add any scoped styles here */
  </style>
  
<template>
 <nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarScroll">
      <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
        <!-- <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li> -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <Avatar :avatarUrl="userAvatarUrl" altText="Avatar"/>
          </a>
          <ul class="dropdown-menu">
            <li>
                <RouterLink class="dropdown-item" to="/profile"> <i class="material-icons">person</i> Profile</RouterLink>
            </li>
            <!-- <li><a class="dropdown-item" href="#">Another action</a></li> -->
            <li><hr class="dropdown-divider"></li>
            <li>
              
              <p  @click="handleLogout" class="dropdown-item">
              <i class="material-icons">exit_to_app</i> 
              logout
              </p>
              <!-- <LogoutButton />  -->
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link " aria-disabled="true"> <i class="material-icons">notifications</i></a>
        </li>
      </ul>
    </div>
  </div>
</nav>


</template>

<script >
  import Swal from 'sweetalert2'
  import Avatar from '@/components/AvatarImage.vue';
  // import LogoutButton from '@/components/Buttons/LogoutButton.vue';
  import useUserStore from "@/stores/users";
import { mapActions, mapState} from "pinia";
import { computed } from 'vue';
  export default {
      components:{
          Avatar     
      },
      setup() {
    const userIsLoggedIn = computed(() => !!useUserStore.storedUser);

        return{ 
          userAvatarUrl:'src/assets/Images/Avatar/man.png',
          userIsLoggedIn
        }
      },
      methods: {
        ...mapActions(useUserStore, ['logoutUser']),

    handleLogout() {
      Swal.fire({
        title: "Are you sure?",
        text: "You are about to log out",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Log out!"
      }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire({
            title: "Session Expired!",
            text: "You have been Logged out.",
            icon: "success"
          });
          localStorage.removeItem('user');
          this.logoutUser();
          this.$emit('logged-out');
        }
      });
    },
      },
      computed: {
    ...mapState(useUserStore, ['storedUser'])
  }
  }
</script>

<style>
</style>
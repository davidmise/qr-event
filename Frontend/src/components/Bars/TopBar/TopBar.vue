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
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
              
              <RouterLink @click="handleLogout" class="dropdown-item" to="/auth/login">
              <i class="material-icons">exit_to_app</i> 
              log out</RouterLink></li>
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
  
   
  export default {
      components:{
          Avatar,      
      },
      data(){
        return{
          userAvatarUrl:'src/assets/Images/Avatar/man.png'
        }
      },
      methods: {
        logout() {
          // Perform logout logic here, e.g., clear user data, tokens, etc.
          // You can also remove the user_id from local storage here
          localStorage.removeItem('user_id');
          

          console.log('User id is:', localStorage.getItem('user_id'));

          this.$router.push({ name: 'login' });
          // Emit an event to notify the parent component that the user has logged out
          this.$emit('logged-out');
          
        },

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
                this.logout();
              }
            });
          },
      },
  }
</script>

<style>
</style>
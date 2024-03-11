<template>
    <button @click="handleLogout">Logout</button>
  </template>
  
  <script>
  import Swal from 'sweetalert2'
  export default {
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
  };
  </script>
  
<template>
  <button  @click="handleLogout">Logout</button>
</template>

<script>
import Swal from 'sweetalert2'
import useUserStore from "@/stores/users";
import { mapActions, mapState} from "pinia";
import { computed } from 'vue';

export default {
  setup() {
    const userIsLoggedIn = computed(() => !!useUserStore.storedUser);

    return {
      userIsLoggedIn
    };
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
};
</script>

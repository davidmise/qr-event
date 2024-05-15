<template>
  <div>
    <h1>SweetAlert2 Dialog Box Example</h1>
    <button @click="handleAlertClick">Alert Daialog</button>
  </div>
</template>

<script>
import Swal from 'sweetalert2'
export default {
  methods: {
    handleAlertClick() {
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire('Deleted!', 'Your file has been deleted.', 'success')
        }
      })
    }
  }
}
</script>

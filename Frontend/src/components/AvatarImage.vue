<template>
  <div class="avatar">
    <img :src="avatarUrl" :alt="altText">
  </div>
</template>

<script>
export default {
  props: {
    avatarUrl: {
      type: String,
      required: true
    },
    altText: {
      type: String,
      default: 'Avatar'
    }
  }
}
</script>

<style scoped>
.avatar {
  width: 25px; /* Adjust size as needed */
  height: 25px; /* Adjust size as needed */
  border-radius: 100%; /* Ensures the image is circular */
  overflow: hidden; /* Clips the image to the shape of the border */
}

.avatar img {
  width: 100%;
  height: 100%;
  object-fit: cover; /* Ensures the image fills the circular container */
}
</style>

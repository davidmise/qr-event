<script>
import { RouterView } from 'vue-router'
export default {
  data() {
    return {
      RouterView,
      isMobile: false
    }
  },
  mounted() {
    const userAgent = navigator.userAgent
    this.isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(userAgent)
  }
}
</script>
<template>
  <div v-if="isMobile">
    <!-- This is a mobile device! -->
    <RouterView />
  </div>
  <div v-else>
    <RouterView />
    <!-- This is not a mobile device. -->
  </div>
</template>

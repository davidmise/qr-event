<template>
  <div class="container mt-5">
    <div class="row">
      <div class="col">
        <div class="position-relative" v-if="imageSrc">
          <img :src="imageSrc" alt="Template Image" class="img-fluid" />
          <div
            v-for="(text, index) in texts"
            :key="index"
            class="position-absolute"
            :style="getTextStyle(text)"
          >
            {{ guestName }}
          </div>
        </div>
        <input
          type="text"
          v-model="guestName"
          class="form-control mt-3"
          placeholder="Enter your name"
        />
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  data() {
    return {
      imageSrc: null,
      texts: [],
      guestName: '',
      identifier: 'unique-template-id' // Change this as needed
    }
  },
  created() {
    this.fetchTemplateAndOverlays()
  },
  methods: {
    fetchTemplateAndOverlays() {
      axios
        .get(`http://127.0.0.1:8000/api/overlays/${this.identifier}`)
        .then((response) => {
          const overlays = response.data
          if (overlays.length > 0) {
            this.imageSrc = `/storage/${overlays[0].template}`
            this.texts = overlays.map((overlay) => ({
              x: overlay.x,
              y: overlay.y,
              fontSize: overlay.font_size,
              fontFamily: overlay.font_family,
              fontColor: overlay.font_color
            }))
          }
        })
        .catch((error) => {
          console.error('There was an error fetching the template and overlays!', error)
        })
    },
    getTextStyle(text) {
      return {
        top: `${text.y}px`,
        left: `${text.x}px`,
        color: text.fontColor,
        fontSize: `${text.fontSize}px`,
        fontFamily: text.fontFamily,
        fontWeight: 'bold'
      }
    }
  }
}
</script>

<style scoped>
.position-absolute {
  pointer-events: none;
}
</style>

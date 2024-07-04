<script setup>
import ListCardTemplates from '@/components/Cardtemplates/ListTemplate.vue'
</script>

<template>
  <div class="container mt-5">
    <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link :to="{ name: 'hostviewEvent' }">home</router-link>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Add Overlay</li>
      </ol>
    </nav>
    <p><span class="h2">Uploaded Template</span></p>
    <ListCardTemplates />
    <p><span class="h2">Set Overlays</span></p>
    <div class="row">
      <div class="col">
        <input type="file" @change="onFileChange" class="form-control" />
      </div>
    </div>
    <div class="row mt-3" v-if="imageSrc">
      <div class="col">
        <div class="position-relative">
          <img :src="imageSrc" alt="Uploaded Image" class="img-fluid" />
          <div
            v-for="(text, index) in texts"
            :key="index"
            class="position-absolute"
            :style="getTextStyle(text)"
          >
            {{ text.content }}
          </div>
        </div>
      </div>
    </div>
    <div class="row mt-3" v-if="imageSrc">
      <div class="col">
        <div v-for="(text, index) in texts" :key="index" class="mb-3">
          <input type="text" v-model="text.content" class="form-control" placeholder="Enter text" />
          <input
            type="number"
            v-model="text.x"
            class="form-control mt-2"
            placeholder="X Position"
          />
          <input
            type="number"
            v-model="text.y"
            class="form-control mt-2"
            placeholder="Y Position"
          />
          <input
            type="number"
            v-model="text.fontSize"
            class="form-control mt-2"
            placeholder="Font Size"
          />
          <input
            type="text"
            v-model="text.fontFamily"
            class="form-control mt-2"
            placeholder="Font Family"
          />
          <input
            type="color"
            v-model="text.fontColor"
            class="form-control mt-2"
            placeholder="Font Color"
          />
        </div>
        <button class="btn btn-primary" @click="addText">Add Text</button>
        <button class="btn btn-success mt-3" @click="saveOverlays">Save Overlays</button>
        <button class="btn btn-success mt-3" @click="downloadImage">Download Image</button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import { mapState } from 'pinia'
import useGeneralStore from '@/stores/general'

export default {
  props: ['eventId'],
  data() {
    return {
      imageSrc: null,
      texts: [],
      identifier: 'unique-image-id' // Change this as needed
    }
  },
  created() {
    this.stringToInt()
  },
  computed: {
    ...mapState(useGeneralStore, ['API_URL'])
  },
  methods: {
    onFileChange(e) {
      const file = e.target.files[0]
      if (file) {
        const reader = new FileReader()
        reader.onload = (e) => {
          this.imageSrc = e.target.result
        }
        reader.readAsDataURL(file)
      }
    },
    stringToInt() {
      const eventId = parseInt(this.$route.params.eventId)
      console.log(eventId)
      return eventId
    },
    addText() {
      this.texts.push({
        content: 'Guest Name',
        x: 0,
        y: 0,
        fontSize: 20,
        fontFamily: 'Arial',
        fontColor: '#ff0000' // Default color is red
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
    },

    saveOverlays() {
      const eventId = this.stringToInt()
      const overlays = this.texts.map((text) => ({
        x: text.x,
        y: text.y,
        font_size: text.fontSize,
        font_family: text.fontFamily,
        font_color: text.fontColor
      }))

      axios
        .post(`${this.API_URL}overlays`, {
          identifier: this.identifier,
          event_info_id: eventId,
          overlays
        })
        .then((response) => {
          alert('Overlays saved successfully')
          console.log(response.data)
          console.log(eventId)
        })
        .catch((error) => {
          console.error('There was an error saving the overlays!', error)
          //   console.log(eventId)
        })
    },
    downloadImage() {
      const canvas = document.createElement('canvas')
      const context = canvas.getContext('2d')
      const img = new Image()
      img.src = this.imageSrc

      img.onload = () => {
        canvas.width = img.width
        canvas.height = img.height
        context.drawImage(img, 0, 0)

        this.texts.forEach((text) => {
          context.font = `${text.fontSize}px ${text.fontFamily}`
          context.fillStyle = text.fontColor
          context.fillText(text.content, text.x, text.y)
        })

        const link = document.createElement('a')
        link.href = canvas.toDataURL('image/png')
        link.download = 'modified-image.png'
        link.click()
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

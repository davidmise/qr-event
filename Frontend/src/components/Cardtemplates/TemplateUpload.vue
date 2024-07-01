<template>
  <div>
    <nav style="--bs-breadcrumb-divider: '>'" aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <router-link :to="{ name: 'hostviewEvent' }">home</router-link>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Upload Template</li>
      </ol>
    </nav>
    <p><span class="h2">Upload Image</span></p>
    <form @submit.prevent="uploadImage">
      <input class="form" type="file" @change="onFileChange" />
      <input type="text" v-model="name" placeholder="Enter image name" />
      <button class="btn btn-secondary" type="submit">Upload</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  props: ['eventId'],
  data() {
    return {
      image: null,
      name: ''
    }
  },
  created(){
    this.stringToInt();
},

  methods: {
    stringToInt() {
      const eventId = parseInt(this.$route.params.eventId)
      console.log(eventId)
      return eventId
    },
    onFileChange(event) {
      this.image = event.target.files[0]
    },
    async uploadImage() {
        const eventId = this.stringToInt();
        console.log(eventId)
      const formData = new FormData()
      formData.append('image', this.image)
      formData.append('name', this.name)
      formData.append('event_info_id', eventId)

      try {
        const response = await axios.post('http://localhost:8000/api/upload', formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        })
        alert('Image uploaded successfully')
        console.log(response.data)
      } catch (error) {
        if (error.response && error.response.data.errors) {
          console.error('Validation errors:', error.response.data.errors)
          alert('Failed to upload image: ' + JSON.stringify(error.response.data.errors))
        } else {
          console.error('Error uploading image:', error)
          alert('Failed to upload image')
        }
      }
    }
  }
}
</script>

<style scoped>
/* Add your styles here */
</style>

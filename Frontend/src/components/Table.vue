<!-- eslint-disable vue/multi-word-component-names -->
<template>

    <div class="card shadow border-0 mb-7">
      <div class="card-header">
           <h5 class="mb-0">Applications</h5>
      </div>
      <div class="table-responsive">
        <table class="table table-hover table-nowrap">
          <thead class="thead-light">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Event Info</th>
              <th scope="col">Start Date</th>
              <th scope="col">Pricing</th>
              <th scope="col">Poster</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item, index) in displayedItems" :key="index">
              <td class="text-heading font-semibold" >{{ index + 1 }}</td>
              <td>{{ item.info }}</td>
              <td>{{ item.startDate}}</td>
              <td>${{ item.price }}</td>
              <td><img :src="item.poster" alt="Item Image" ></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div> 
  </template>
  
  <script>
  export default {
    props: {
      displayedItems: {
        type: Array,
        required: true
      }
      // You can add more props as needed
    }
  }
  </script>
  
  <!-- <style>
  @import '@/assets/main.css';
  /* Add your styles here */
  
  </style> -->
  
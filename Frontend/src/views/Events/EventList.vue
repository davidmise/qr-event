<template>
  <div>
    <Sidebar/>
    <div :style="{ marginLeft: sidebarWidth, transition: 'margin 0.8s' }">
      <TopBar/>
      <main class="py-6 bg-surface-secondary">
          <div class="container-fluid">
            <p>Events List</p>
            <main class="py-6 bg-surface-secondary">
              <div class="container-fluid">
                <!-- Table -->
                <h2 class="mb-5">All Events</h2>
                <Tabled :displayedItems="displayedItems" />
              </div>
            </main>    
          </div>
          <div class="row">
            <div class="container col-6 mt-5 px-5">
              <label for="itemCount">Number of Items: </label>
              <input type="number" v-model="itemCount" id="itemCount">
              <label for="itemsPerPage">Items Per Page:</label>
              <select v-model="itemsPerPage" @change="handleItemsPerPageChange">
                <option v-for="option in itemsPerPageOptions" :key="option" :value="option">{{ option }}</option>
              </select>
            </div>
            <div class="pagination-container container mt-5  col-6">
              <Pagination :totalItems="totalItems" :itemsPerPage="itemsPerPage" @page-changed="handlePageChange" />
            </div>
          </div>
          
      </main>
      <RouterView />
    </div>
  </div>
  <!-- <FooterVue/> -->
</template>

<script>
  // import FooterVue from '@/components/Footer.vue';
  import Sidebar from '@/components/Bars/Sidebar/SideBar.vue'
  import { sidebarWidth } from '@/components/Bars/Sidebar/state';
  import TopBar from '@/components/Bars/TopBar/TopBar.vue';
  import Pagination from '@/components/Pagination.vue'
  import Tabled from '@/components/Table.vue' // Import the Table component

  export default {
    components: {
      Sidebar,
      TopBar,
      Pagination,
      Tabled, // Add the Table component to your components,
      // FooterVue
  },
    data() {
      return {
        itemCount: 20,
        items: [],
        displayedItems: [],
        sidebarWidth,
        
        currentPage: 1,
        totalItems: 0,
        itemsPerPage: 10,
        itemsPerPageOptions: [5, 10, 20, 50]
      }
    },
    watch: {
      itemCount() {
        this.totalItems = this.itemCount;
        this.generateItems();
      },
      itemsPerPage() {
        this.generateItems();
      }
    },
    methods: {
      generateItems() {
        this.items = [];
        for (let i = 0; i < this.itemCount; i++) {
          this.items.push({
            info: `Description for item ${i + 1}`,
            startDate: `Start Date ${i + 1}`,
            image: `https://via.placeholder.com/150?text=Item${i + 1}`
          });
        }

        const startIndex = (this.currentPage - 1) * this.itemsPerPage;
        const endIndex = startIndex + this.itemsPerPage;
        this.displayedItems = this.items.slice(startIndex, endIndex);
      },
      handlePageChange() {
        this.generateItems();
      },
      handleItemsPerPageChange() {
        this.currentPage = 1;
        this.generateItems();
      }
    },
    mounted() {
      this.totalItems = this.itemCount;
      this.generateItems();
    }
  };
</script>

<style>
  .pagination-container {
    display: flex;
    justify-content: center;
  }
</style>

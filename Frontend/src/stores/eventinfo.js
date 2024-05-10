import { defineStore } from "pinia";
import axios from "axios";
const useEventStore = defineStore('event',{
    state: () => ({
        totalEvents: 0,
        pricePerEvents: 5000,

        data:{},
        events:[],
        event:null,

        itemCount: 20,
        currentPage: 1,
        itemsPerPage: 5,
        totalPages:null,
        totalItems: 0,
        lastPage:null,
        nextPageUrl: null, 
    }),

    getters: {
        totalEventsPrices: (state) => {
            return state.totalEvents * state.pricePerEvents;
        }
    },  
    
    actions: {
        addEvent(){
            this.totalEvents++;
        },

        async fetchEventInfo(index) {
            this.currentPage = index;
            try {
              const response = await axios.get('http://127.0.0.1:8000/api/all-events?page='+this.currentPage
                // , {
                //   params: {
                //     per_page: this.itemsPerPage,
                //     page: this.currentPage
                //   }
                // }
              );
              this.data = response.data;
              this.events = this.data.data;
              console.log('this events',this.events)
              this.totalPages = response.data.total;
              this.lastPage = response.data.last_page;
              console.log('lastnpage',response.data.current_page);
              
            } catch (error) {
              console.error('Error fetching Event Info:', error);
            }
          },
          
       handlePageChange(page) {
         this.currentPage = page;
         if (this.nextPageUrl) {
           // Use next page URL from backend if available for better performance
           this.fetchEventInfo(this.nextPage);
         } else {
           // Fallback to traditional method if next page URL is not provided
           this.fetchEventInfo();
         }
       },
     
       handlePreviousPage() {
               if(this.currentPage > 1 ){
                   this.currentPage--;
                   this.fetchEventInfo(this.currentPage);
               }
               
           
       },
       handleNextPage() {
         if (this.currentPage < this.data.last_page) {
           this.currentPage++;
           this.fetchEventInfo(this.currentPage); // Assuming previous page URL is not provided
        //    console.log("nexr Page is", this.currentPage);
         }
       },

    }
   
});

export default useEventStore;
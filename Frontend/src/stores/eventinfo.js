import { defineStore } from "pinia";
// import axios from "axios";
const useEventStore = defineStore('event',{
    state: () => ({
      storedEvent: (localStorage.getItem('event')) || null
    }),

    getters: {
       UserIsStoredL: state =>state.storedEvent !== null
    },  
    
    actions: {
       
      storeEvent(event) {
        const _this = this;
        localStorage.setItem('event', JSON.stringify(event));
        _this.storedEvent = event;
        // router.push({name: 'home'})
        console.log(event)

        // Save the event to the Store State

        _this.storeEvent = event;
      }
      

    }
   
});

export default useEventStore;
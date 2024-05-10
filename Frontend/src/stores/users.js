import { defineStore } from 'pinia';
import router from '../router';

const useUserStore = defineStore('user', {
    state: () => ({
        storedUser: (localStorage.getItem('user')) || null
    }),
    getters: {
        userIsLoggedIn: state => state.storedUser !== null
    },
    actions: {
        storeLoggedInUser(user) {
            const _this = this;

            // Save the user to localStorage
            localStorage.setItem('user', JSON.stringify(user));

            // Save the user to the store state
            _this.storedUser = user;

            router.push({name: 'home'})

        },
        // Add other actions like logout
        logoutUser() {
            localStorage.removeItem('user');
            
            this.storedUser = null;
            router.push({name: 'login'})
        }
    }
});

export default useUserStore;

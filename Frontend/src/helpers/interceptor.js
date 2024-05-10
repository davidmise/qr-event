
import axios from "axios"
// import LogoutButton from '@/components/Buttons/LogoutButton.vue';
import useUserStore from "@/stores/users";
// Add this code after the import statements
const userStore = useUserStore();

// Add a request interceptor
axios.interceptors.request.use(
  (config) => {
    // Get the token from the user store
    const token = userStore.token;
    // If the token exists, add it to the request headers
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  (error) => {
    // Do something with request error
    return Promise.reject(error);
  }
);


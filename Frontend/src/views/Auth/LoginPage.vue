<template>
    <div class="d-lg-flex half">
      <div class="bg order-1 order-md-2" style="background-image: url('images/bg_1.jpg');"></div>
      <div class="contents order-2 order-md-1">
        <div class="container">
          <div class="row align-items-center justify-content-center">
            <div class="col-md-7">
              <h3>Login to <strong>Colorlib</strong></h3>
              <p class="mb-4">Lorem ipsum dolor sit amet elit. Sapiente sit aut eos consectetur adipisicing.</p>
              <form @submit.prevent="submit">
                <div class="form-group first">
                  <label for="username">Username</label>
                  <input type="text" class="form-control" placeholder="your-email@gmail.com" id="username" v-model="LoginData.email">
                </div>
                <div class="form-group last mb-3">
                  <label for="password">Password</label>
                  <input type="password" class="form-control" placeholder="Your Password" id="password" v-model="LoginData.password">
                </div>
                <div class="d-flex mb-5 align-items-center">
                  <label class="control control--checkbox mb-0">
                    <span class="caption">Remember me</span>
                    <input type="checkbox" />
                    <div class="control__indicator"></div>
                  </label>
                  <span class="ml-auto"><a href="#" class="forgot-pass">Forgot Password</a></span> 
                </div>
                <input type="submit" value="Log In" class="btn btn-block btn-outline-secondary ">
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import axios from "axios";
  import Swal from 'sweetalert2';
  
  export default {
    data() {
      return {
        LoginData: {
          email: "",
          password: ""
        },
        errors: {
          email: "",
          password: ""
        }
      };
    },
    methods: {
      async submit() {
        try {
          const response = await axios.post("http://localhost:8003/api/login", this.LoginData);
          const user_id = response.data.data.id;
          localStorage.setItem("user_id", user_id);
          this.$router.push({name:'home'});
          this.handelSuccessToast();
          this.resetForm();
        } catch (error) {
          console.log('incorrect Email or password');
          this.handelErrorToast();
          if (error.response.status && error.response.status === 401) {
            this.errors.password = error.response.data.message;
            console.log(this.errors.password);
            this.handelErrorToast();
          }
        }
      },
      resetForm() {
        this.LoginData.email = "";
        this.LoginData.password = "";
      },
      handelErrorToast() {
        Swal.fire({
          icon: "error",
          title: "Authentication failed!",
          text: "incorrect Email or password"
        });
      },
      handelSuccessToast() {
        Swal.fire({
          icon: "success",
          title: "Logged in Successfully!"
        });
      }
    }
  };
  </script>
  
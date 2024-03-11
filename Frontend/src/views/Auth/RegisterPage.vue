<template>
   
  <div class="d-lg-flex half">
    <div class="bg order-1 order-md-2" style="background-image: url('images/bg_1.jpg');"></div>
    <div class="contents order-2 order-md-1">

      <div class="container">
        <div class="row align-items-center justify-content-center">
          <div class="col-md-7">
            <h3>Register to <strong>Eventer</strong></h3>
            <p class="mb-4">Lorem ipsum dolor sit amet elit. Sapiente sit aut eos consectetur adipisicing.</p>
            <form  @submit.prevent="submitForm">
              <div class="form-group first">
                <label for="name">Name</label>
                <input type="text" class="form-control" placeholder="your-email@gmail.com" id="username" v-model="FormData.name" >
              </div>

              <div class="form-group first">
                <label for="username">Username</label>
                <input type="text" class="form-control" placeholder="your-email@gmail.com" id="username" v-model="FormData.username">
              </div>

              <div class="form-group first">
                <label for="email">email</label>
                <input type="text" class="form-control" placeholder="your-email@gmail.com" id="email" v-model="FormData.email">
              </div>
              
              <div class="form-group last mb-3">
                <label for="password">Password</label>
                <input type="password" class="form-control" placeholder="Your Password" id="password" v-model="FormData.password">
              </div>
              
              <div class="d-flex mb-5 align-items-center">
                <label class="control control--checkbox mb-0"><span class="caption">Remember me</span>
                  <input type="checkbox" />
                  <div class="control__indicator"></div>
                </label>
                <span class="ml-auto"><a href="#" class="forgot-pass">Forgot Password</a></span> 
              </div>

              <button type="submit"  class="btn btn-block btn-primary">submit</button>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
  import axios from "axios"
  // import validator from "@/helpers/validator.js"
  import Swal from 'sweetalert2'
  export default {

    data() {
      return {
        // api response
        apiResponse: {
          name: '',
          username: '',
          email: '',
          password: '',
        },
        //  short message
        errorMessage:'',
        passwordStrengthMessage: '',
        // form Data
        FormData:{
          name: '',
          username:'',
          email:'',
          password:'',
          confirmPassword: ''
          // password_confirmation:''  
        },
        // form data error message
        FormErrors:{
        name:'',
        username:'',
        email:'',
        password:'',
        confirmPassword: ''
        }
      };
      
    },
    methods:{
      resetFormData(){
        this.FormData.name ='',
        this.FormData.username='',
        this.FormData.email='',
        this.FormData.password='',
        this.FormData.confirmPassword=''
        // password_confirmation:''
      },
      clearFormDataErrors(){
        this.FormErrors.name='',
        this.FormErrors.username='',
        this.FormErrors.email='',
        this.FormErrors.password='',
        this.FormErrors.confirmPassword= ''
      },

      // password strength check
      // validatePasswordStrength() {
      //    const password = this.FormData.password;
      //    // Define password strength criteria using regular expressions
      //     const uppercaseRegex = /[A-Z]/;
      //     const lowercaseRegex = /[a-z]/;
      //     const digitRegex = /[0-9]/;
      //     const specialCharRegex = /[!@#$%^&*()_+[\]{};':"\\|,.<>/?]+/;

      //     // Check if the password meets the criteria
      //     const isStrongPassword =
      //       uppercaseRegex.test(password) &&
      //       lowercaseRegex.test(password) &&
      //       digitRegex.test(password) &&
      //       specialCharRegex.test(password) &&
      //       password.length >= 8;

      //       if (password.length === 0) {
      //         this.passwordStrengthMessage = '';
      //     } else if (isStrongPassword) {
      //         this.passwordStrengthMessage = '';
      //     } else {
      //         this.passwordStrengthMessage = 'Password Must include atleast 8 characters [Lowercase, Uppercase, numbers and symbols]';
      //     }
      //     return isStrongPassword;
          
      //   },

        // Password confirmation check
        ConfirmPassword(){
          var validate = true;
            // confirm password validation
            if(this.FormData.confirmPassword ==''){
              this.FormErrors.confirmPassword = "please Confrim your password";
            validate = false;
          }
          else if(this.FormData.password !== this.FormData.confirmPassword ){
              this.FormErrors.confirmPassword ="Passwords do not match!";
              console.log(this.FormErrors.confirmPassword);
              this.errorMessage = this.FormErrors.confirmPassword;
              this.handelErrorToast();
              validate = false;
            }
          else{
              this.FormErrors.confirmPassword =''; // clear password
              
            return validate;
          }
          
        },

        // Form Valdation
        // validation(){
        //   var validate = true;
        //   this.FormErrors.name = validator(this.FormData.name, 'required');
        //   this.FormErrors.email = validator(this.FormData.email, 'email');
        //   this.FormErrors.password = validator(this.FormData.password, 'required');
        //   this.FormErrors.confirmPassword = validator(this.FormData.confirmPassword, 'required');

        //   // password validation, Password musbe atleast 8 chars
        //   if(this.FormData.password.length < 8 && this.FormData.password !== this.FormData.confirmPassword ) 
        //   {
        //     this.FormErrors.password = 'Password must be atleast 8 charachters long.'; 
        //     validate =false;
        //   }
        //   else if(this.FormData.password == ''){
        //     this.FormErrors.password = 'this password is required';
        //     validate =false;
        //   }
        //   else{
        //     this.FormErrors.password = ''; // clear password error
        //     validate =true;
        //   }
          
      

        //   if(this.FormErrors.name !== "" || 
        //     this.FormErrors.email !=="" || 
        //     this.FormErrors.password !=="" || 
        //     this.FormErrors.address !=="" || 
        //     this.FormErrors.ConfirmPassword !==""
        //    )

        //   {
            
        //     validate = false;
        //   }
        //   return validate;
        // },

      async submitForm(){
        console.log('clicked');
        this.clearFormDataErrors();

        // if(!this.ConfirmPassword()){
        //     return;
        //   }
        
        try {
            const response = await axios.post("http://127.0.0.1:8000/api/register", this.FormData);
            console.log(response.data);
            this.handelSuccessToast();
            if (response.data.status == true) {
              this.$router.push('/auth/login');

              this.apiResponse = response.data;
                  this.apiResponse.email= response.data.email;
                  this.apiResponse.name = response.data.name;
                  this.apiResponse.username = response.data.username;
                  this.apiResponse.password = response.data.password;
                  this.error.ConfirmPassword = ''; // Clear the ConfirmPassword error message
                  //message came from api down here
                  console.log(response.data.name); 
                  this.resetForm()
                  
            }
          } catch (error) {
            console.error('Error submitting form:', error);
            console.log(error.response.data.errors.email[0]);
            this.errorMessage = error.response.data.errors.email[0];
            this.EmailErrorToast();
          }
          
      },

      handelSuccessToast(){
        console.log("toast");
        Swal.fire({
          icon: "success",
          title: "Registerd  Successfully!",
          // text: "You clicked the button!",
          // footer: '<a href="#">Why do I have this issue?</a>'
        });
      },
      handelErrorToast(){
        console.log("toast");
        Swal.fire({
          icon: "error",
          title: "Registration failed!",
          text: this.errorMessage,
          // footer: '<a href="#">Why do I have this issue?</a>'
        });
        
      },

      EmailErrorToast(){
        console.log("toast");
        Swal.fire({
          icon: "error",
          title: "Registration failed!",
          text: this.errorMessage,
          // footer: '<a href="#">Why do I have this issue?</a>'
        });
        
      },

    }
    
  }
</script>
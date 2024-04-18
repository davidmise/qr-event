<template>
    <section class="vh-100" style="background-color: #f4f5f7;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-lg-6 mb-4 mb-lg-0">
                    <div class="card border-0 mb-3" style="border-radius: .5rem;">
                        <div class="row g-0">
                            <div class="col-md-4 gradient-custom text-center text-white"
                                style="border-top-left-radius: .5rem; border-bottom-left-radius: .5rem;">
                                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp"
                                    alt="Avatar" class="img-fluid my-5" style="width: 80px;" />
                                <h5>Organizer</h5>
                                <p>Web Designer</p>
                                <i class="far fa-edit mb-5"></i>
                                <div class="car">
                                    <img :src="qrCode" alt="QR Code" width="100px">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body p-4">
                                    <h6>Information</h6>
                                    <hr class="mt-0 mb-4">
                                    <!-- pull evnet info -->
                                    <div class="row pt-2">

                                    </div>
                                    <div class="row pt-1">
                                        <div class="row gy-3 overflow-hidden">
                                            <form @submit.prevent="fetchQrCodeData">
                                                <div class="col-12">
                                                    <div class="form-floating mb-3">
                                                        <input type="text"
                                                            class="form-control border-0 border-bottom rounded-0"
                                                            name="name" id="name" placeholder="Degratus"
                                                            v-model="qrData.Guest.name" required>
                                                        <label for="name" class="form-label">Name</label>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-floating mb-3">
                                                        <input type="email"
                                                            class="form-control border-0 border-bottom rounded-0"
                                                            name="email" id="email" placeholder="name@example.com"
                                                            v-model="qrData.Guest.email" required>
                                                        <label for="email" class="form-label">Email</label>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-floating mb-3">
                                                        <input type="number"
                                                            class="form-control border-0 border-bottom rounded-0"
                                                            name="number" id="number" value="" placeholder="0754323421"
                                                            v-model="qrData.Guest.phone_number" required>
                                                        <label for="number" class="form-label">Pone Number:</label>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="d-grid">
                                                        <button type="submit"
                                                            class="btn btn-primary btn-lg">Register</button>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-start mt-3">
                                        <a href="#!"><i class="bi bi-facebook fa-lg me-3"></i></a>
                                        <a href="#!"><i class="bi bi-twitter fa-lg me-3"></i></a>
                                        <a href="#!"><i class="bi bi-instagram fa-lg"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import axios from "axios"
export default {
    data() {
        return {
            qrCode: '',
            qrData: {
                Guest: {
                    name: '',
                    email: '',
                    phone_number: ''
                }
            }
        }
    },
    methods: {
        async fetchQrCodeData() {
            console.log('cliked');
            // this.$store.dispatch('fetchQrCodeData', this.qrData.value)
            try {
                const response = await axios.post('http://127.0.0.1:8000/api/generate-qrcode', this.qrData.Guest);
                this.qrCode = 'data:image/svg+xml;base64,' + btoa(response.data.qr_code);
                console.log(this.qrCode);
            } catch (error) {
                console.error('Error fetching QR code:', error);
            }
        },
        async pullEventInfo(){
            try {
                const response = await axios.get('http://127.0.0.1:8000/api/pull-event-info{}');
                console.log(response.data);
            } catch (error) {
                console.error('Error fetching QR code:', error);
            }
        }

    }
}
</script>

<style scoped>
.gradient-custom {
    /* fallback for old browsers */
    background: #f6d365;

    /* Chrome 10-25, Safari 5.1-6 */
    background: -webkit-linear-gradient(to right bottom, rgba(246, 211, 101, 1), rgba(253, 160, 133, 1));

    /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
    background: linear-gradient(to right bottom, rgba(246, 211, 101, 1), rgba(253, 160, 133, 1))
}
</style>
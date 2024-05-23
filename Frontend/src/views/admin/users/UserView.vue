<script setup>
import Sidebar from '@/components/Bars/Sidebar/SideBar.vue'
import { sidebarWidth } from '@/components/Bars/Sidebar/state.js'
import TopBar from '@/components/Bars/TopBar/TopBar.vue'
import axios from 'axios'
import { mapState } from 'pinia'
import useGeneralStore from '@/stores/general'
import useUserStore from '@/stores/users'
import EdditUserModal from '@/components/admin/user/modal/EdditUserModal.vue'
</script>
<template>
  <div>
    <Sidebar />
    <div :style="{ marginLeft: sidebarWidth, transition: 'margin 0.8s' }">
      <TopBar />
      <main class="py-6 bg-surface-secondary">
        <div class="container-fluid p-0">
          <section>
            <div class="container py-5">
              <h1 class="h3 mb-3"><strong>User </strong> Profile</h1>
              <div class="row">
                <div class="col-lg-4">
                  <div class="card mb-4">
                    <div class="card-body text-center">
                      <img
                        src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp"
                        alt="avatar"
                        class="rounded-circle img-fluid"
                        style="width: 150px"
                      />
                      <h5 class="my-3">{{ userInfo.name }}</h5>
                      <div class="d-flex justify-content-center mb-2">
                              <!-- Button trigger modal -->
                        <button
                          type="button"
                          data-mdb-button-init
                          data-mdb-ripple-init
                          class="btn btn-outline-success"
                          data-bs-toggle="modal"
                           data-bs-target="#exampleModal"
                        >
                          Edit
                        </button>
                        <!-- Modal -->
                      <EdditUserModal/>
                        <button
                          type="button"
                          data-mdb-button-init
                          data-mdb-ripple-init
                          class="btn btn-outline-danger ms-1"
                        >
                          Delete
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-8">
                  <div class="card mb-4">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-sm-3">
                          <p class="mb-0">Full Name</p>
                        </div>
                        <div class="col-sm-9">
                          <p class="text-muted mb-0">{{ userInfo.name }}</p>
                        </div>
                      </div>
                      <hr />
                      <div class="row">
                        <div class="col-sm-3">
                          <p class="mb-0">Email</p>
                        </div>
                        <div class="col-sm-9">
                          <p class="text-muted mb-0">{{ userInfo.email }}</p>
                        </div>
                      </div>
                      <hr />
                      <div class="row">
                        <div class="col-sm-3">
                          <p class="mb-0">Username</p>
                        </div>
                        <div class="col-sm-9">
                          <p class="text-muted mb-0">{{ userInfo.username }}</p>
                        </div>
                      </div>
                      <!-- <hr /> -->
                      <div class="row">
                        <!-- <div class="col-sm-3">
                          <p class="mb-0">Phone</p>
                        </div> -->
                        <div class="col-sm-9">
                          <p class="text-muted mb-0">{{ userInfo.phone }}</p>
                        </div>
                      </div>
                      <hr />
                      <div class="row">
                        <div class="col-sm-3">
                          <p class="mb-0">Role</p>
                        </div>
                        <div class="col-sm-9">
                          <p class="text-muted mb-0">{{ userInfo.role }}</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
      



          </section>
        </div>
      </main>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      userInfo: null,
      userId: null
    }
  },
  computed: {
    ...mapState(useGeneralStore, ['API_URL']),
    ...mapState(useUserStore, ['token', 'user'])
  },
  created() {
    this.userId = this.$route.params.userId
    this.getUserInfo()
  },
  methods: {
    getUserInfo() {
      axios
        .get(`${this.API_URL}user${this.userId}`, {
          headers: {
            Authorization: `Bearer ${this.token}`
          }
        })
        .then((response) => {
          this.userInfo = response.data.user
          console.log(this.userInfo)
        })
        .catch((error) => {
          console.log(error)
        })
    }
  }
}
</script>

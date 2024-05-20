<script setup>
import Sidebar from '@/components/Bars/Sidebar/SideBar.vue'
import { sidebarWidth } from '@/components/Bars/Sidebar/state'
import TopBar from '@/components/Bars/TopBar/TopBar.vue'
</script>

<template>
  <div>
    <Sidebar />
    <div :style="{ marginLeft: sidebarWidth, transition: 'margin 0.8s' }">
      <TopBar />
      <main class="py-6 bg-surface-secondary">
        <div class="container-fluid">
          <main class="py-6 bg-surface-secondary ms-4">
            <h2 class="mb-3">Doorman</h2>
            <!-- media table -->
            <div class="container mb-4">
              <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12">
                  <div class="card shadow border-0 py-3 px-4">
                    <label for="formFileLg" class="form-label">Upload Logo</label>
                    <input class="form-control form-control-md" id="formFileLg" type="file" />
                  </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                  <div class="card shadow border-0 py-3 px-4">
                    <label for="formFileLg" class="form-label">Upload Poster</label>
                    <input class="form-control form-control-md" id="formFileLg" type="file" />
                  </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                  <div class="card shadow border-0 py-3 px-4">
                    <label for="formFileLg" class="form-label">Upload Banner</label>
                    <input class="form-control form-control-md" id="formFileLg" type="file" />
                  </div>
                </div>
              </div>
            </div>
            <div class="container mb-5">
              <!-- first row  -->
              <div class="row mb-2">
                <!-- Event info Table column -->
                <div class="col-lg-5 col-md-6 col-sm-12">
                  <div class="card border-0 shadow form-group py-3 px-4">
                    <h5 class="text-secondary fw-bold">Event info</h5>
                    <!-- <label for="name">Name</label> -->
                    <!-- event name -->
                    <div class="form-floating mb-3">
                      <input
                        type="text"
                        class="form-control"
                        id="floatingInput"
                        placeholder="name@example.com"
                      />
                      <label for="floatingInput">Event Name</label>
                    </div>
                    <!-- event subtitle -->
                    <div class="form-floating mb-3">
                      <input
                        type="text"
                        class="form-control"
                        id="floatingInput"
                        placeholder="name@example.com"
                      />
                      <label for="floatingInput">Event Subtitle</label>
                    </div>
                    <!-- event duration (date) -->
                    <div class="row">
                      <div class="form-floating mb-3 col-lg-6 col-sm-12">
                        <input
                          type="date"
                          class="form-control"
                          id="floatingInput"
                          placeholder="name@example.com"
                        />
                        <label for="floatingInput" class="ms-3">Starting Date </label>
                      </div>
                      <!-- event end date -->
                      <div class="form-floating mb-3 col-lg-6 col-sm-12">
                        <input
                          type="date"
                          class="form-control"
                          id="floatingInput"
                          placeholder="name@example.com"
                        />
                        <label for="floatingInput" class="ms-3">Ending Date </label>
                      </div>
                    </div>
                    <!-- event duration (time) -->
                    <div class="row">
                      <div class="form-floating mb-3 col-lg-6 col-sm-12">
                        <input
                          type="time"
                          class="form-control"
                          id="floatingInput"
                          placeholder="name@example.com"
                        />
                        <label for="floatingInput" class="ms-3">Starting time </label>
                      </div>
                      <!-- event end time -->
                      <div class="form-floating mb-3 col-lg-6 col-sm-12">
                        <input
                          type="time"
                          class="form-control"
                          id="floatingInput"
                          placeholder="name@example.com"
                        />
                        <label for="floatingInput" class="ms-3">Ending time</label>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Ticket table -->
                <div class="col-lg-5 col-md-6 col-sm-12">
                  <div class="card border-0 shadow form-group py-3 px-4">
                    <h5 class="text-secondary fw-bold">Ticketing</h5>
                    <!-- <label for="name">Name</label> -->
                    <div class="form-floating mb-3">
                      <input
                        type="text"
                        class="form-control"
                        id="floatingInput"
                        placeholder="name@example.com"
                      />
                      <label for="floatingInput">Ticket Type</label>
                    </div>
                    <div class="form-floating mb-3">
                      <input
                        type="number"
                        class="form-control"
                        id="floatingInput"
                        placeholder="name@example.com"
                      />
                      <label for="floatingInput">Event Capacity</label>
                    </div>
                    <div class="form-floating mb-3">
                      <input
                        type="number"
                        class="form-control"
                        id="floatingInput"
                        placeholder="name@example.com"
                      />
                      <label for="floatingInput">Ticket Price</label>
                    </div>
                  </div>
                </div>
              </div>
              <!-- second row -->
              <div class="row mt-5">
                <!--Location Table-->
                <div class="col-lg-5 col-md-6 col-sm-12">
                  <div class="card border-0 shadow form-group py-3 px-4">
                    <h5 class="text-secondary fw-bold">Event Location</h5>
                    <!-- <label for="name">Name</label> -->
                    <!-- event name -->
                    <div class="form-floating mb-3">
                      <input
                        type="text"
                        class="form-control"
                        id="floatingInput"
                        placeholder="name@example.com"
                      />
                      <label for="floatingInput">Street Address</label>
                    </div>
                    <!-- event duration (date) -->
                    <div class="row">
                      <div class="form-floating mb-3 col-lg-6 col-sm-12">
                        <input
                          type="text"
                          class="form-control"
                          id="floatingInput"
                          placeholder="name@example.com"
                        />
                        <label for="floatingInput" class="ms-3">City </label>
                      </div>
                      <!-- event end date -->
                      <div class="form-floating mb-3 col-lg-6 col-sm-12">
                        <input
                          type="text"
                          class="form-control"
                          id="floatingInput"
                          placeholder="name@example.com"
                        />
                        <label for="floatingInput" class="ms-3">State </label>
                      </div>
                    </div>
                    <!-- event duration (time) -->
                    <div class="row">
                      <div class="form-floating mb-3 col-lg-6 col-sm-12">
                        <input
                          type="text"
                          class="form-control"
                          id="floatingInput"
                          placeholder="name@example.com"
                        />
                        <label for="floatingInput" class="ms-3">Country </label>
                      </div>
                      <!-- event end time -->
                      <div class="form-floating mb-3 col-lg-6 col-sm-12">
                        <input
                          type="text"
                          class="form-control"
                          id="floatingInput"
                          placeholder="name@example.com"
                        />
                        <label for="floatingInput" class="ms-3">Postal Code</label>
                      </div>
                    </div>
                    <!-- event subtitle -->
                    <div class="form-floating mb-3">
                      <input
                        type="text"
                        class="form-control"
                        id="floatingInput"
                        placeholder="name@example.com"
                      />
                      <label for="floatingInput">Google Map Url</label>
                    </div>
                  </div>
                </div>
                <!--  Social Links Table -->
                <div class="col-lg-5 col-md-6 col-sm-12">
                  <div class="card border-0 shadow form-group py-3 px-4">
                    <h5 class="text-secondary fw-bold">Social Links</h5>
                    <!-- <label for="name">Name</label> -->
                    <div class="input-group mb-3">
                      <span class="input-group-text"><i class="bi bi-instagram"></i></span>
                      <div class="form-floating">
                        <input
                          type="text"
                          class="form-control"
                          id="floatingInputGroup1"
                          placeholder="Username"
                        />
                        <label for="floatingInputGroup1">URL (Optional)</label>
                      </div>
                    </div>
                    <div class="input-group mb-3">
                      <span class="input-group-text"><i class="bi bi-twitter-x"></i></span>
                      <div class="form-floating">
                        <input
                          type="text"
                          class="form-control"
                          id="floatingInputGroup1"
                          placeholder="Username"
                        />
                        <label for="floatingInputGroup1">URL (Optional)</label>
                      </div>
                    </div>
                    <div class="input-group mb-3">
                      <span class="input-group-text"><i class="bi bi-facebook"></i></span>
                      <div class="form-floating">
                        <input
                          type="text"
                          class="form-control"
                          id="floatingInputGroup1"
                          placeholder="Username"
                        />
                        <label for="floatingInputGroup1">URL (Optional)</label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- third row -->
              <div class="row mt-5">
                <!-- Organizer Table -->
                <div class="col-lg-5 col-md-6 col-sm-12">
                  <div class="card border-0 shadow form-group py-3 px-4">
                    <h5 class="text-secondary fw-bold">Organizer Info</h5>
                    <!-- <label for="name">Name</label> -->
                    <!-- event name -->
                    <div class="form-floating mb-3">
                      <input
                        type="text"
                        class="form-control"
                        id="floatingInput"
                        placeholder="name@example.com"
                      />
                      <label for="floatingInput">Organizer Name</label>
                    </div>

                    <div class="form-floating mb-3">
                      <input
                        type="text"
                        class="form-control"
                        id="floatingInput"
                        placeholder="name@example.com"
                      />
                      <label for="floatingInput">Organizer Email</label>
                    </div>

                    <!-- event subtitle -->
                    <div class="form-floating mb-3">
                      <input
                        type="text"
                        class="form-control"
                        id="floatingInput"
                        placeholder="name@example.com"
                      />
                      <label for="floatingInput">Organizer Phone</label>
                    </div>
                  </div>
                  <!-- submit BUTTON -->
                  <div class="btn-container d-grid mt-5">
                    <button type="submit" class="btn btn-secondary btn-lg rounded">
                      Create Event
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </main>
        </div>
      </main>
    </div>
  </div>
</template>

<template>
  <div>
    <div class="row">
      <!--  TemplateUpload  -->
      <div class="col-xl-3 col-sm-6 col-12">
        <div class="card shadow border-0" @click="toTemplateUpload()">
          <div class="card-body">
            <div class="row">
              <div class="col">
                <span class="h6 font-semibold text-muted text-sm d-block mb-2">Clients</span>
                <span class="h3 font-bold mb-0">Template Upload</span>
              </div>
              <div class="col-auto">
                <div class="icon icon-shape bg-info text-white text-lg rounded-circle">
                  <i class="bi bi-clock-history"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--  OverlayUpload -->
      <div class="col-xl-3 col-sm-6 col-12">
        <div class="card shadow border-0" @click="toOverlayUpload()">
          <div class="card-body">
            <div class="row">
              <div class="col">
                <span class="h6 font-semibold text-muted text-sm d-block mb-2">Clients</span>
                <span class="h3 font-bold mb-0">Overlay Upload</span>
              </div>
              <div class="col-auto">
                <div class="icon icon-shape bg-info text-white text-lg rounded-circle">
                  <i class="bi bi-clock-history"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
// import TemplateUpload from '@/components/Cardtemplates/TemplateUpload.vue';
// import OverlayUpload from '@/components/Cardtemplates/OverlayUpload.vue';
</script>

<script>
export default {
  methods: {
    toTemplateUpload(eventId) {
      this.$router.push({
        name: 'UploadTemplate',
        params: { eventId: eventId }
      })
    },

    toOverlayUpload(eventId) {
      this.$router.push({
        name: 'UploadOverlay',
        params: { eventId: eventId }
      })
    }
  }
}
</script>

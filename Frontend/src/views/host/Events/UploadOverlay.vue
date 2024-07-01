<template>
  <div>
    <Sidebar />
    <div :style="{ marginLeft: sidebarWidth, transition: 'margin 0.8s' }">
      <TopBar />
      <main class="py-6 bg-surface-secondary">
        <div class="container-fluid">
          <OverlayUpload />
        </div>
      </main>
    </div>
  </div>
</template>
<script setup>
//    import TemplateUpload from '@/components/Cardtemplates/TemplateUpload.vue';
import OverlayUpload from '@/components/Cardtemplates/OverlayUpload.vue'
</script>

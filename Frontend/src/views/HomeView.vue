<script setup>
import Sidebar from '@/components/Bars/Sidebar/SideBar.vue';
import { sidebarWidth } from '@/components/Bars/Sidebar/state';
import TopBar from '@/components/Bars/TopBar/TopBar.vue';
</script>

<template>
  <div>
    <Sidebar/>
    <div :style="{ marginLeft: sidebarWidth, transition: 'margin 0.8s' }">
      <TopBar/>
      <main class="py-6 bg-surface-secondary">
        <div class="container-fluid">
            <main class="py-6 bg-surface-secondary">
                home
            </main>
          </div>
        </main>
    </div>
  </div>

    
    

</template>

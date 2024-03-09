<template>
    <router-link v-if="!collapsed" :to="to" class="link text-uppercase dropdown-item fw-bold" :class="{ active: isActive }">
      <i class="material-icons">{{ icon }}</i>
      <transition name="fade">
        <span v-if="!collapsed">
          <slot v-if="!collapsed">{{ text }}</slot>
        </span>
      </transition>
    </router-link>
    <div v-else class="link text-uppercase" @click="handleClick">
      <i class="material-icons">{{ icon }}</i>
    </div>
  </template>
  
  <script>
  import { computed } from 'vue';
  import { useRoute } from 'vue-router';
  import { collapsed } from './state';
  
  export default {
    props: {
      to: { type: String, required: true },
      icon: { type: String, required: true },
      text: { type: String, default: '' }, // New prop to pass text to the parent link
    },
    setup(props) {
      const route = useRoute();
      const isActive = computed(() => route.path === props.to);
      const handleClick = () => {
        if (!collapsed.value) {
          // eslint-disable-next-line no-undef
          router.push(props.to);
        }
      };
      return {
        isActive,
        collapsed,
        handleClick,
      };
    },
  };
  </script>
  
  <style scoped>
  .fade-enter-active,
  .fade-leave-active {
    transition: opacity 0.1s; /* Fix the typo here */
  }
  
  .fade-enter-active,
  .fade-leave-to {
    opacity: 0;
  }
  
  .link {
    display: flex;
    align-items: center;
    cursor: pointer;
    position: relative;
    font-weight: 400;
    user-select: none;
    margin: 0.1em 0;
    padding: 0.4em;
    border-radius: 0.25em;
    height: 1.5em;
    margin-top: 30px;
    color: white;
    text-decoration: none;
  }
  
  .link:hover {
    background-color: var(--sidebar-item-hover);
  }
  
  .link:active {
    background-color: var(--sidebar-item-active);
  }
  
  .link .material-icons {
    flex-shrink: 0;
    width: 25px;
    margin-right: 10px;
  }
  </style>
  
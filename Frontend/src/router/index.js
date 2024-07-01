// src/router/index.js
import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import NotFound from '@/views/NotFound.vue'
import useUserStore from '@/stores/users'
// import { isMobile } from '@/utils/isMobile';
import { mobileGuard } from '@/utils/mobileGuard'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    // ... your existing routes
    {
      path: '/auth/login',
      name: 'login',
      component: () => import('../views/Auth/LoginPage.vue')
    },
    {
      path: '/auth/register',
      name: 'register',
      component: () => import('../views/Auth/RegisterPage.vue')
    },
    {
      path: '/auth/forgotPassword',
      name: 'forgotPassword',
      component: () => import('../views/Auth/ForgotPassword.vue')
    },
    {
      path: '/auth/ResetPassword',
      name: 'ResetPassword',
      component: () => import('../views/Auth/ResetPassword.vue')
    },
    {
      path: '/',
      name: 'home',
      component: HomeView,
      meta: { requiresAuth: true }
    },
    {
      path: '/scanner',
      name: 'scanner',
      component: () => import('../views/ScanEvent.vue'),
      meta: { requiresAuth: true }
    },
    {
      path: '/host/events/view:eventId',
      name: 'hostviewEvent',
      meta: { requiresAuth: true, role: 'host' }, // Added role meta
      component: () => import('../views/host/Events/EventView.vue')
    },

    {
      path: '/host/events/preview:eventId',
      name: 'hostPreviewEvent',
      meta: { requiresAuth: true, role: 'host' }, // Added role meta
      component: () => import('../views/host/Events/dummyTicket.vue')
    },

    {
      path: '/host/events/template-upload:eventId',
      name: 'UploadTemplate',
      meta: { requiresAuth: true, role: 'host' }, // Added role meta
      component: () => import('../views/host/Events/UploadTemplate.vue')
    },

    {
      path: '/host/events/overlay-upload:eventId',
      name: 'UploadOverlay',
      meta: { requiresAuth: true, role: 'host' }, // Added role meta
      component: () => import('../views/host/Events/UploadOverlay.vue')
    },

    {
      path: '/host/events/all',
      name: 'hostAllEvents',
      meta: { requiresAuth: true, role: 'host' }, // Added role meta
      component: () => import('../views/host/Events/EventList.vue')
    },
    {
      path: '/host/events/new',
      name: 'hostNewEvents',
      meta: { requiresAuth: true, role: 'host' }, // Added role meta
      component: () => import('../views/host/Events/NewEvent.vue')
    },
    {
      path: '/host/profile',
      name: 'hostProfile',
      meta: { requiresAuth: true, role: 'host' }, // Added role meta
      component: () => import('../views/host/ProfilePage.vue')
    },
    {
      path: '/host/clients/all',
      name: 'hostClientsAll',
      meta: { requiresAuth: true, role: 'host' }, // Added role meta
      component: () => import('../views/host/clients/AllClients.vue')
    },
    {
      path: '/host/clients/new',
      name: 'hostClientsNew',
      meta: { requiresAuth: true, role: 'host' }, // Added role meta
      component: () => import('../views/host/clients/NewClient.vue')
    },
    {
      path: '/host/guests/all',
      name: 'hostGuestsAll',
      meta: { requiresAuth: true, role: 'host' }, // Added role meta
      component: () => import('../views/host/guests/AllGuests.vue')
    },
    {
      path: '/contacts',
      name: 'contacts',
      meta: { requiresAuth: true },
      component: () => import('../views/ContactsView.vue')
    },
    {
      path: '/register-guest/:eventId',
      name: 'register-guest',
      // meta: { requiresAuth: true },
      props: true,
      component: () => import('../views/RegisterGuest.vue')
    },
    {
      path: '/admin/admin-dashboard',
      name: 'adminDashboard',
      meta: { requiresAuth: true, role: 'admin' }, // Added role meta
      component: () => import('../views/admin/AdminDashboard.vue')
    },
    {
      path: '/admin/events/events/all',
      name: 'adminEventsAll',
      meta: { requiresAuth: true, role: 'admin' }, // Added role meta
      component: () => import('../views/admin/Events/EventList.vue')
    },
    {
      path: '/admin/events/view:eventId',
      name: 'adminViewEvent',
      meta: { requiresAuth: true, role: 'admin' }, // Added role meta
      component: () => import('../views/admin/Events/EventView.vue')
    },
    {
      path: '/admin/events/new',
      name: 'adminNewEvent',
      meta: { requiresAuth: true, role: 'admin' }, // Added role meta
      component: () => import('../views/admin/Events/NewEvent.vue')
    },
    {
      path: '/admin/users/all',
      name: 'adminUsersAll',
      meta: { requiresAuth: true, role: 'admin' }, // Added role meta
      component: () => import('../views/admin/users/ListUsers.vue')
    },
    {
      path: '/admin/users/new',
      name: 'adminNewUser',
      meta: { requiresAuth: true, role: 'admin' }, // Added role meta
      component: () => import('../views/admin/users/NewUser.vue')
    },
    {
      path: '/admin/user/view:userId',
      name: 'adminViewUser',
      meta: { requiresAuth: true, role: 'admin' }, // Added role meta
      component: () => import('../views/admin/users/UserView.vue')
    },
    {
      path: '/admin/clients/all',
      name: 'adminClientsAll',
      meta: { requiresAuth: true, role: 'admin' }, // Added role meta
      component: () => import('../views/admin/clients/AllClients.vue')
    },
    {
      path: '/admin/clients/new',
      name: 'adminClientsNew',
      meta: { requiresAuth: true, role: 'admin' }, // Added role meta
      component: () => import('../views/admin/clients/NewClient.vue')
    },
    {
      path: '/admin/guests/all',
      name: 'adminGuestAll',
      meta: { requiresAuth: true, role: 'admin' }, // Added role meta
      component: () => import('../views/admin/guests/AllGuests.vue')
    },
    {
      path: '/admin/profile',
      name: 'adminViewProfile',
      meta: { requiresAuth: true, role: 'admin' }, // Added role meta
      component: () => import('../views/admin/ProfilePage.vue')
    },
    {
      path: '/doorman/home',
      name: 'doormanHome',
      meta: { requiresAuth: true, role: 'doorman' }, // Added role meta
      component: () => import('../views/doorman/DoormanView.vue'),
      beforeEnter: mobileGuard
    },
    {
      path: '/doorman/event/view:eventId',
      name: 'doormanEventView',
      meta: { requiresAuth: true, role: 'doorman' }, // Added role meta
      component: () => import('../views/doorman/EventGuests.vue'),
      beforeEnter: mobileGuard
    },
    {
      path: '/doorman/profile',
      name: 'doormanProfile',
      meta: { requiresAuth: true, role: 'doorman' }, // Added role meta
      component: () => import('../views/doorman/ProfilePage.vue'),
      beforeEnter: mobileGuard
    },
    {
      path: '/host/host-dashboard',
      name: 'hostDashboard',
      meta: { requiresAuth: true, role: 'host' }, // Added role meta
      component: () => import('../views/host/HostDashboard.vue')
    },
    {
      path: '/:catchAll(.*)',
      component: NotFound
    }
  ]
})

router.beforeEach((to, from, next) => {
  const userStore = useUserStore()
  const isAuthenticated = userStore.userIsLoggedIn
  const userRole = userStore.getUserRole

  if (to.meta.requiresAuth) {
    if (!isAuthenticated) {
      // Redirect to login if not authenticated
      next({ name: 'login' })
    } else if (to.meta.role && to.meta.role !== userRole) {
      // Redirect to home if the role doesn't match
      next({ name: 'home' })
    } else {
      // Allow navigation if authenticated and roles match
      next()
    }
  } else if ((to.name === 'login' || to.name === 'register') && isAuthenticated) {
    // Redirect to home if trying to access login or register while authenticated
    next({ name: 'home' })
  } else {
    // Allow navigation for other routes
    next()
  }
})

export default router

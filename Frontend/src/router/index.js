import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import NotFound from '@/views/NotFound.vue' // Import the NotFound component
import useUserStore from '@/stores/users'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/auth/login',
      name: 'login',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/Auth/LoginPage.vue')
    },

    {
      path: '/auth/Register',
      name: 'Register',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/Auth/RegisterPage.vue')
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
      meta: { requiresAuth: true },
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/host/Events/EventView.vue')
    },
    {
      path: '/host/events/all',
      name: 'hostAllEvents',
      meta: { requiresAuth: true },
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/host/Events/EventList.vue')
    },
    {
      path: '/host/events/new',
      name: 'hostNewEvents',
      meta: { requiresAuth: true },
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/host/Events/NewEvent.vue')
    },

    {
      path: '/contacts',
      name: 'contacts',
      meta: { requiresAuth: true },
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/ContactsView.vue')
    },

    {
      path: '/register-guest/:eventId',
      name: 'register-guest',
      meta: { requiresAuth: true },
      props: true,
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/RegisterGuest.vue')
    },

    {
      path: '/admin/admin-dashboard',
      name: 'admin-dashboard',
      meta: { requiresAuth: true },
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/admin/AdminDashboard.vue')
    },
    // admin/events
    {
      path: '/admin/events/events/all',
      name: 'adminEventsAll',
      meta: { requiresAuth: true },
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/admin/Events/EventList.vue')
    },
    {
      path: '/admin/events/view:eventId',
      name: 'adminViewEvent',
      meta: { requiresAuth: true },
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/admin/Events/EventView.vue')
    },

    {
      path: '/admin/events/new',
      name: 'adminNewEvent',
      meta: { requiresAuth: true },
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/admin/Events/NewEvent.vue')
    },

    {
      path: '/admin/users/all',
      name: 'adminUsersAll',
      meta: { requiresAuth: true },
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/admin/users/ListUsers.vue')
    },

    {
      path: '/admin/users/new',
      name: 'adminNewUser',
      meta: { requiresAuth: true },
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/admin/users/NewUser.vue')
    },
    {
      path: '/admin/user/view:userId',
      name: 'adminViewUser',
      meta: { requiresAuth: true },
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/admin/users/UserView.vue')
    },

    {
      path: '/doorman/doorman',
      name: 'doorman',
      meta: { requiresAuth: true },
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/doorman/DoormanView.vue')
    },
    {
      path: '/host/host-dashboard',
      name: 'host-dashboard',
      meta: { requiresAuth: true },
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/host/HostDashboard.vue')
    },

    // Catch-all route for 404 Not Found
    {
      path: '/:catchAll(.*)', // Match all paths
      component: NotFound // Render the NotFound component
    }
  ]
})

// Authentication Logic
router.beforeEach((to, from, next) => {
  // Get the current state of the user store
  const isAuthenticated = useUserStore().storedUser !== null

  if (to.meta.requiresAuth) {
    // This route requires authentication
    if (!isAuthenticated) {
      // User is not logged in, redirect to login
      next({ name: 'login' })
    } else {
      // User is logged in, allow navigation
      next()
    }
  } else if ((to.name === 'login' || to.name === 'Register') && isAuthenticated) {
    // If user is logged in and tries to access login or register page, redirect to home
    next({ name: 'home' })
  } else {
    // For other routes, simply allow the navigation
    next()
  }
})
export default router

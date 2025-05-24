import { createRouter, createWebHashHistory } from "vue-router";
import { useSessionStore } from '@/stores/session';

const routes = [
  {
    path: '/',
    redirect: '/home',
  },
  {
    path: '/home',
    name: 'home',
    component: () => import('@/views/HomeView.vue'),
    meta: { requiresAuth: true, pageTitle: 'Home' },
  },
  {
    path: '/about',
    name: 'about',
    component: () => import('@/views/AboutView.vue'),
    meta: { requiresAuth: true, pageTitle: 'About' },
  },
  {
    path: '/login',
    name: 'login',
    component: () => import('@/views/LoginView.vue'),
    meta: { guest: true, pageTitle: 'Login' },
  },
  {
    path: '/register',
    name: 'register',
    component: () => import('@/views/RegisterView.vue'),
    meta: { guest: true, pageTitle: 'Register' },
  },
  {
    path: '/:pathMatch(.*)*',
    name: 'not-found',
    component: () => import('@/views/NotFoundView.vue'),
    meta: { pageTitle: 'Not Found' },
  },
];

const router = createRouter({
  history: createWebHashHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  const sessionStore = useSessionStore();
  const isLoggedIn = sessionStore.isAuthenticated;

  if (to.meta.pageTitle) {
    document.title = `${to.meta.pageTitle} - ${import.meta.env.VITE_NAME}`;
  }

  if (to.meta.guest && isLoggedIn) {
    return next({ name: 'home' });
  }

  if (to.meta.requiresAuth && !isLoggedIn) {
    return next({ name: 'login' });
  }

  next();
});

export default router;

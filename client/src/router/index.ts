import { createRouter, createWebHistory } from "vue-router";
import { authService } from "../services/authService";

// Import pages
import LoginPage from "@/views/LoginPage.vue";
import DashboardPage from "@/views/DashboardPage.vue";
import NewsOverviewPage from "@/views/NewsOverviewPage.vue";
import NewsDetailPage from "@/views/NewsDetailPage.vue";

const routes = [
  {
    path: "/login",
    name: "Login",
    component: LoginPage,
    meta: {
      layout: "AuthLayout",
      requiresGuest: true, // Only accessible when not authenticated
    },
  },
  {
    path: "/dashboard",
    name: "Dashboard",
    component: DashboardPage,
    meta: {
      layout: "DefaultLayout",
      requiresAuth: true, // Only accessible when authenticated
    },
  },
  {
    path: "/news",
    name: "News",
    component: NewsOverviewPage,
    meta: {
      layout: "DefaultLayout",
      requiresAuth: true, // Only accessible when authenticated
    },
  },
  {
    path: "/news/:id",
    name: "NewsDetail",
    component: NewsDetailPage,
    meta: {
      layout: "DefaultLayout",
      requiresAuth: true, // Only accessible when authenticated
    },
  },
  {
    path: "/",
    redirect: () => {
      // Redirect to dashboard if authenticated, otherwise to login
      return authService.isAuthenticated() ? "/dashboard" : "/login";
    },
  },
  {
    path: "/:pathMatch(.*)*",
    redirect: () => {
      // Redirect to dashboard if authenticated, otherwise to login
      return authService.isAuthenticated() ? "/dashboard" : "/login";
    },
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

// Navigation guards
router.beforeEach(async (to, from, next) => {
  const isAuthenticated = authService.isAuthenticated();

  // Check if route requires authentication
  if (to.meta.requiresAuth && !isAuthenticated) {
    next("/login");
    return;
  }

  // Check if route is only for guests (like login page)
  if (to.meta.requiresGuest && isAuthenticated) {
    next("/dashboard");
    return;
  }

  // If authenticated, verify token is still valid
  if (isAuthenticated && to.meta.requiresAuth) {
    try {
      await authService.getUser();
      next();
    } catch (error) {
      // Token is invalid, logout and redirect to login
      authService.logout();
      next("/login");
    }
  } else {
    next();
  }
});

export default router;

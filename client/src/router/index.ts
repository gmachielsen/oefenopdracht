import { createRouter, createWebHistory } from "vue-router";
import { authService } from "../services/authService";

// Import route modules
import { authRoutes, newsRoutes, profileRoutes, coreRoutes } from "./routes";

const routes = [...authRoutes, ...newsRoutes, ...profileRoutes, ...coreRoutes];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

// Navigation guards
router.beforeEach(async (to, from, next) => {
  const isAuthenticated = authService.isAuthenticated();

  // Check if route requires authentication
  if (to.meta.requiresAuth && !isAuthenticated) {
    if (to.path !== "/login") {
      next("/login");
    } else {
      next();
    }
    return;
  }

  // Check if route is only for guests (like login page)
  if (to.meta.requiresGuest && isAuthenticated) {
    if (to.path !== "/profile") {
      next("/profile");
    } else {
      next();
    }
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

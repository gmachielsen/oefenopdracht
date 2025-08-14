import type { RouteRecordRaw } from "vue-router";
import { authService } from "../../services/authService";

export const coreRoutes: RouteRecordRaw[] = [
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

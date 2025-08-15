import type { RouteRecordRaw } from "vue-router";
import { authService } from "../../services/authService";

export const coreRoutes: RouteRecordRaw[] = [
  {
    path: "/",
    redirect: () => {
      // Redirect to profile if authenticated, otherwise to login
      return authService.isAuthenticated() ? "/profile" : "/login";
    },
  },
  {
    path: "/:pathMatch(.*)*",
    redirect: () => {
      // Redirect to profile if authenticated, otherwise to login
      return authService.isAuthenticated() ? "/profile" : "/login";
    },
  },
];

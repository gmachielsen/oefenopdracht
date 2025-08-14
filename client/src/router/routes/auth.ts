import type { RouteRecordRaw } from "vue-router";
import { LoginPage } from "@/views";

export const authRoutes: RouteRecordRaw[] = [
  {
    path: "/login",
    name: "Login",
    component: LoginPage,
    meta: {
      layout: "AuthLayout",
      requiresGuest: true, // Only accessible when not authenticated
    },
  },
];

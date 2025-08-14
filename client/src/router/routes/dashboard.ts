import type { RouteRecordRaw } from "vue-router";
import { DashboardPage } from "@/views";

export const dashboardRoutes: RouteRecordRaw[] = [
  {
    path: "/dashboard",
    name: "Dashboard",
    component: DashboardPage,
    meta: {
      layout: "DefaultLayout",
      requiresAuth: true, // Only accessible when authenticated
    },
  },
];

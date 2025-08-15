import type { RouteRecordRaw } from "vue-router";
import ProfilePage from "@/views/profile/ProfilePage.vue";

export const profileRoutes: RouteRecordRaw[] = [
  {
    path: "/profile",
    name: "Profile",
    component: ProfilePage,
    meta: {
      layout: "DefaultLayout",
      requiresAuth: true, // Only accessible when authenticated
    },
  },
];

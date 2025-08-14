import type { RouteRecordRaw } from "vue-router";
import { NewsOverviewPage, NewsDetailPage } from "@/views";

export const newsRoutes: RouteRecordRaw[] = [
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
];

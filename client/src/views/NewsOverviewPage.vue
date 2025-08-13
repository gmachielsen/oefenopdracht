<template>
  <div class="news-overview-page">
    <NewsOverview @logout="handleLogout" />
  </div>
</template>

<script setup lang="ts">
import { useRouter } from "vue-router";
import NewsOverview from "../components/NewsOverview.vue";

const router = useRouter();

const handleLogout = () => {
  // Navigate to login after logout
  router.push("/login");
};
</script>

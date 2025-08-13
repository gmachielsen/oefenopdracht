<template>
  <div class="news-detail-page">
    <NewsDetail @logout="handleLogout" />
  </div>
</template>

<script setup lang="ts">
import { useRouter } from "vue-router";
import NewsDetail from "../components/NewsDetail.vue";

const router = useRouter();

const handleLogout = () => {
  // Navigate to login after logout
  router.push("/login");
};
</script>

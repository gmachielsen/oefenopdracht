<template>
  <div class="dashboard-page">
    <Dashboard @logout="handleLogout" />
  </div>
</template>

<script setup lang="ts">
import { useRouter } from "vue-router";
import Dashboard from "../components/Dashboard.vue";

const router = useRouter();

const handleLogout = () => {
  // Navigate to login after logout
  router.push("/login");
};
</script>

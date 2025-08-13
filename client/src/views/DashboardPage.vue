<template>
  <div class="dashboard-page">
    <ProfileForm @logout="handleLogout" />
  </div>
</template>

<script setup lang="ts">
import { useRouter } from "vue-router";
import ProfileForm from "../components/ProfileForm.vue";

const router = useRouter();

const handleLogout = () => {
  // Navigate to login after logout
  router.push("/login");
};
</script>

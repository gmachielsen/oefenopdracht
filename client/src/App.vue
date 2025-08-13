<script setup lang="ts">
import { ref, onMounted } from "vue";
import LoginForm from "./components/LoginForm.vue";
import Dashboard from "./components/Dashboard.vue";
import { authService } from "./services/authService";

const isAuthenticated = ref(false);

const handleLoginSuccess = () => {
  isAuthenticated.value = true;
};

const handleLogout = () => {
  isAuthenticated.value = false;
};

const checkAuthStatus = async () => {
  try {
    // Check if we have a valid token by trying to get user data
    await authService.getUser();
    isAuthenticated.value = true;
  } catch (error) {
    // Token is invalid or expired
    isAuthenticated.value = false;
    authService.logout(); // Clean up any invalid tokens
  }
};

onMounted(() => {
  // Check authentication status on app load
  if (authService.isAuthenticated()) {
    checkAuthStatus();
  }
});
</script>

<template>
  <div id="app">
    <!-- Show login form if not authenticated -->
    <LoginForm v-if="!isAuthenticated" @login-success="handleLoginSuccess" />

    <!-- Show dashboard if authenticated -->
    <Dashboard v-else @logout="handleLogout" />
  </div>
</template>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}
</style>

<style scoped>
/* Custom styles can be added here if needed */
</style>

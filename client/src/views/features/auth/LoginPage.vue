<template>
  <div class="login-page">
    <LoginForm @login-success="handleLoginSuccess" />
  </div>
</template>

<script setup lang="ts">
import { useRouter } from "vue-router";
import LoginForm from "../../../components/features/auth/LoginForm.vue";

const router = useRouter();

const handleLoginSuccess = () => {
  // Navigate to dashboard after successful login
  router.push("/dashboard");
};
</script>

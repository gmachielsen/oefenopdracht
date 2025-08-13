<template>
  <div class="min-h-screen bg-gray-50 flex">
    <!-- Sidebar -->
    <div class="w-64 bg-white shadow-sm border-r border-gray-200">
      <!-- Logo/Header -->
      <div class="p-6 border-b border-gray-200">
        <div class="flex items-center space-x-3">
          <div
            class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center"
          >
            <svg
              class="w-6 h-6 text-white"
              fill="currentColor"
              viewBox="0 0 20 20"
            >
              <path
                d="M10 2L3 7v11a1 1 0 001 1h3v-7h6v7h3a1 1 0 001-1V7l-7-5z"
              />
            </svg>
          </div>
          <div class="text-sm font-medium text-gray-900">Golfclub</div>
        </div>
      </div>

      <!-- Navigation Menu -->
      <nav class="mt-6 px-3">
        <div class="space-y-1">
          <!-- Nieuws -->
          <router-link
            to="/news"
            class="group flex items-center px-3 py-2 text-sm font-medium rounded-md"
            :class="
              $route.path.startsWith('/news')
                ? 'bg-gray-100 text-gray-900'
                : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900'
            "
          >
            <svg
              class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"
              />
            </svg>
            Nieuws
          </router-link>

          <!-- Profiel -->
          <router-link
            to="/profile"
            class="group flex items-center px-3 py-2 text-sm font-medium rounded-md"
            :class="
              $route.path === '/profile'
                ? 'bg-gray-100 text-gray-900'
                : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900'
            "
          >
            <svg
              class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
              />
            </svg>
            Profiel
          </router-link>
        </div>
      </nav>
    </div>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col">
      <!-- Top Header -->
      <header class="bg-white shadow-sm border-b border-gray-200">
        <div class="px-6 py-4 flex items-center justify-between">
          <h1 class="text-xl font-semibold text-gray-900">{{ pageTitle }}</h1>
          <div class="flex items-center space-x-4">
            <span class="text-sm text-gray-700"
              >Welkom {{ fullName || user?.email }}</span
            >
            <div class="relative">
              <button
                @click="handleLogout"
                class="flex items-center space-x-2 text-sm font-medium text-white bg-purple-600 px-3 py-2 rounded-md hover:bg-purple-700"
              >
                <span>{{ fullName || user?.email || "Gebruiker" }}</span>
                <svg
                  class="h-4 w-4"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M19 9l-7 7-7-7"
                  />
                </svg>
              </button>
            </div>
          </div>
        </div>
      </header>

      <!-- Main Content -->
      <main class="flex-1 bg-gray-50 p-6">
        <slot />
      </main>
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed, ref, onMounted } from "vue";
import { useRoute, useRouter } from "vue-router";
import { authService, type User } from "../../services/authService";

const route = useRoute();
const router = useRouter();

const user = ref<User | null>(null);

const fullName = computed(() => {
  if (user.value?.first_name && user.value?.last_name) {
    return `${user.value.first_name} ${user.value.last_name}`;
  } else if (user.value?.first_name) {
    return user.value.first_name;
  } else if (user.value?.last_name) {
    return user.value.last_name;
  }
  return "";
});

onMounted(async () => {
  try {
    user.value = await authService.getUser();
  } catch (error) {
    console.error("Failed to load user:", error);
  }
});

const pageTitle = computed(() => {
  switch (route.path) {
    case "/profile":
      return "Profiel";
    case "/news":
      return "Nieuws";
    default:
      if (route.path.startsWith("/news/")) {
        return "Nieuws Detail";
      }
      return "Dashboard";
  }
});

const handleLogout = () => {
  authService.logout();
  router.push("/login");
};
</script>

<style scoped>
/* Custom styles if needed */
</style>

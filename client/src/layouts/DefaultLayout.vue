<template>
  <div class="min-h-screen bg-gray-50 flex">
    <!-- Sidebar for desktop -->
    <div class="hidden md:block w-64 bg-white shadow-sm">
      <!-- Logo/Header -->
      <div class="p-6">
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
                : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900'
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
            to="/dashboard"
            class="group flex items-center px-3 py-2 text-sm font-medium rounded-md"
            :class="
              $route.path === '/dashboard'
                ? 'bg-gray-100 text-gray-900'
                : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900'
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

    <!-- Mobile sidebar overlay -->
    <div
      v-if="showMobileMenu"
      class="fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden"
      @click="toggleMobileMenu"
    ></div>

    <!-- Mobile sidebar -->
    <div
      :class="[
        'fixed inset-y-0 left-0 w-full bg-white shadow-lg transform transition-transform duration-300 ease-in-out z-50 md:hidden',
        showMobileMenu ? 'translate-x-0' : '-translate-x-full',
      ]"
      data-mobile-menu
    >
      <!-- Mobile Logo/Header -->
      <div class="p-6">
        <div class="flex items-center justify-between">
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
          <button
            @click="toggleMobileMenu"
            class="p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100"
          >
            <svg
              class="w-6 h-6"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M6 18L18 6M6 6l12 12"
              />
            </svg>
          </button>
        </div>
      </div>

      <!-- Mobile Navigation Menu -->
      <nav class="mt-6 px-3">
        <div class="space-y-1">
          <!-- Nieuws -->
          <router-link
            to="/news"
            @click="toggleMobileMenu"
            class="group flex items-center px-3 py-2 text-sm font-medium rounded-md"
            :class="
              $route.path.startsWith('/news')
                ? 'bg-gray-100 text-gray-900'
                : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900'
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
            @click="toggleMobileMenu"
            class="group flex items-center px-3 py-2 text-sm font-medium rounded-md"
            :class="
              $route.path === '/profile'
                ? 'bg-gray-100 text-gray-900'
                : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900'
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
      <header class="bg-gray-50">
        <div class="px-6 py-4 flex items-center justify-between">
          <!-- Mobile: Title left, Profile + Hamburger right -->
          <div class="flex items-center md:hidden">
            <h1 class="text-xl font-semibold text-gray-900">{{ pageTitle }}</h1>
          </div>

          <div class="flex items-center space-x-4 md:hidden">
            <div class="relative">
              <button @click="toggleDropdown" class="relative">
                <img
                  :src="user?.profile_photo || '/default-avatar.svg'"
                  :alt="fullName || 'Gebruiker'"
                  class="h-8 w-8 rounded-full border-2 border-gray-300 hover:border-gray-400 cursor-pointer transition-colors"
                  @error="handleImageError"
                />
              </button>

              <!-- Mobile Profile Dropdown Menu -->
              <div
                v-if="showDropdown"
                class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-200"
                @click.stop
              >
                <div class="px-4 py-2 border-b border-gray-100">
                  <p class="text-sm font-medium text-gray-900">
                    {{ fullName || user?.email }}
                  </p>
                  <p class="text-xs text-gray-500">{{ user?.email }}</p>
                </div>
                <button
                  @click="handleLogout"
                  class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center"
                >
                  <svg
                    class="w-4 h-4 mr-2"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                    />
                  </svg>
                  Uitloggen
                </button>
              </div>
            </div>

            <button
              @click="toggleMobileMenu"
              class="p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100"
              data-mobile-menu
            >
              <svg
                class="w-7 h-7"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16"
                />
              </svg>
            </button>
          </div>

          <!-- Desktop: Title -->
          <h1 class="hidden md:block text-xl font-semibold text-gray-900">
            {{ pageTitle }}
          </h1>

          <!-- Desktop: Welcome + Profile -->
          <div class="hidden md:flex items-center space-x-4">
            <div class="flex items-center space-x-3">
              <span class="text-sm text-gray-700"
                >Welkom {{ fullName || user?.email }}</span
              >
              <div class="relative">
                <button @click="toggleDropdown" class="relative">
                  <img
                    :src="user?.profile_photo || '/default-avatar.svg'"
                    :alt="fullName || 'Gebruiker'"
                    class="h-8 w-8 rounded-full border-2 border-gray-300 hover:border-gray-400 cursor-pointer transition-colors"
                    @error="handleImageError"
                  />
                </button>

                <!-- Desktop Profile Dropdown Menu -->
                <div
                  v-if="showDropdown"
                  class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-200"
                  @click.stop
                >
                  <div class="px-4 py-2 border-b border-gray-100">
                    <p class="text-sm font-medium text-gray-900">
                      {{ fullName || user?.email }}
                    </p>
                    <p class="text-xs text-gray-500">{{ user?.email }}</p>
                  </div>
                  <button
                    @click="handleLogout"
                    class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center"
                  >
                    <svg
                      class="w-4 h-4 mr-2"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                      />
                    </svg>
                    Uitloggen
                  </button>
                </div>
              </div>
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
import { authService, type User } from "../services/authService";

const route = useRoute();
const router = useRouter();

const user = ref<User | null>(null);
const showDropdown = ref(false);
const showMobileMenu = ref(false);

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

const handleImageError = (event: Event) => {
  const target = event.target as HTMLImageElement;
  target.src = "/default-avatar.svg";
};

const toggleDropdown = () => {
  showDropdown.value = !showDropdown.value;
};

const toggleMobileMenu = () => {
  showMobileMenu.value = !showMobileMenu.value;
};

// Close dropdown when clicking outside
onMounted(async () => {
  try {
    user.value = await authService.getUser();
  } catch (error) {
    console.error("Failed to load user:", error);
  }

  // Add click outside listener
  document.addEventListener("click", (event) => {
    const target = event.target as Element;
    if (!target.closest(".relative")) {
      showDropdown.value = false;
    }
    // Close mobile menu when clicking outside
    if (!target.closest("[data-mobile-menu]")) {
      showMobileMenu.value = false;
    }
  });
});
</script>

<style scoped>
/* Custom styles if needed */
</style>

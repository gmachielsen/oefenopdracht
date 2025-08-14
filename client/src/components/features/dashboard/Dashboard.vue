<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex items-center space-x-8">
            <h1 class="text-xl font-semibold text-gray-900">Dashboard</h1>
            <div class="hidden md:flex space-x-4">
              <router-link
                to="/news"
                class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium"
              >
                Nieuws
              </router-link>
            </div>
          </div>
          <div class="flex items-center space-x-4">
            <span class="text-sm text-gray-700"
              >Welcome, {{ fullName || user?.email }}</span
            >
            <button
              @click="handleLogout"
              class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-md text-sm font-medium"
            >
              Logout
            </button>
          </div>
        </div>
      </div>
    </nav>

    <!-- Main content -->
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
      <div class="px-4 py-6 sm:px-0">
        <div class="border-4 border-dashed border-gray-200 rounded-lg p-8">
          <div class="text-center">
            <div
              class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100"
            >
              <svg
                class="h-6 w-6 text-green-600"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M5 13l4 4L19 7"
                ></path>
              </svg>
            </div>
            <h3 class="mt-2 text-sm font-medium text-gray-900">
              Login Successful!
            </h3>
            <p class="mt-1 text-sm text-gray-500">
              You are now authenticated and can access protected features.
            </p>
          </div>

          <!-- User info card -->
          <div class="mt-8 bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
              <h3 class="text-lg leading-6 font-medium text-gray-900">
                User Information
              </h3>
              <div class="mt-5 border-t border-gray-200">
                <dl class="sm:divide-y sm:divide-gray-200">
                  <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-medium text-gray-500">Name</dt>
                    <dd
                      class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"
                    >
                      {{ fullName || "Not provided" }}
                    </dd>
                  </div>
                  <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-medium text-gray-500">
                      Email address
                    </dt>
                    <dd
                      class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"
                    >
                      {{ user?.email }}
                    </dd>
                  </div>
                  <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-medium text-gray-500">User ID</dt>
                    <dd
                      class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"
                    >
                      {{ user?.id }}
                    </dd>
                  </div>
                  <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-medium text-gray-500">
                      Email verified
                    </dt>
                    <dd
                      class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"
                    >
                      <span
                        :class="
                          user?.email_verified_at
                            ? 'text-green-600'
                            : 'text-red-600'
                        "
                      >
                        {{ user?.email_verified_at ? "Yes" : "No" }}
                      </span>
                    </dd>
                  </div>
                </dl>
              </div>
            </div>
          </div>

          <!-- Test API calls -->
          <div class="mt-8 bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
              <h3 class="text-lg leading-6 font-medium text-gray-900">
                Test API Access
              </h3>
              <p class="mt-1 max-w-2xl text-sm text-gray-500">
                Test your authenticated API access with these buttons.
              </p>
              <div class="mt-5 flex space-x-3">
                <button
                  @click="testProtectedRoute"
                  :disabled="isTestingAPI"
                  class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50"
                >
                  <svg
                    v-if="isTestingAPI"
                    class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                  >
                    <circle
                      class="opacity-25"
                      cx="12"
                      cy="12"
                      r="10"
                      stroke="currentColor"
                      stroke-width="4"
                    ></circle>
                    <path
                      class="opacity-75"
                      fill="currentColor"
                      d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                    ></path>
                  </svg>
                  Test User Profile API
                </button>
                <button
                  @click="refreshToken"
                  :disabled="isRefreshing"
                  class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50"
                >
                  <svg
                    v-if="isRefreshing"
                    class="animate-spin -ml-1 mr-3 h-5 w-5 text-gray-500"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                  >
                    <circle
                      class="opacity-25"
                      cx="12"
                      cy="12"
                      r="10"
                      stroke="currentColor"
                      stroke-width="4"
                    ></circle>
                    <path
                      class="opacity-75"
                      fill="currentColor"
                      d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                    ></path>
                  </svg>
                  Refresh Token
                </button>
              </div>
              <div
                v-if="apiTestResult"
                class="mt-4 p-4 rounded-md"
                :class="
                  apiTestResult.success
                    ? 'bg-green-50 text-green-800'
                    : 'bg-red-50 text-red-800'
                "
              >
                <pre class="text-sm">{{ apiTestResult.message }}</pre>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, computed } from "vue";
import { authService, type User } from "../../../services/authService";

const emit = defineEmits<{
  logout: [];
}>();

const user = ref<User | null>(null);
const isTestingAPI = ref(false);
const isRefreshing = ref(false);
const apiTestResult = ref<{ success: boolean; message: string } | null>(null);

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

const handleLogout = async () => {
  await authService.logout();
  emit("logout");
};

const testProtectedRoute = async () => {
  isTestingAPI.value = true;
  apiTestResult.value = null;

  try {
    const userData = await authService.getUser();
    apiTestResult.value = {
      success: true,
      message: `Success! Retrieved user data:\n${JSON.stringify(
        userData,
        null,
        2
      )}`,
    };
  } catch (error: any) {
    apiTestResult.value = {
      success: false,
      message: `Error: ${error.response?.data?.message || error.message}`,
    };
  } finally {
    isTestingAPI.value = false;
  }
};

const refreshToken = async () => {
  isRefreshing.value = true;
  apiTestResult.value = null;

  try {
    await authService.refreshToken();
    apiTestResult.value = {
      success: true,
      message: "Token refreshed successfully!",
    };
  } catch (error: any) {
    apiTestResult.value = {
      success: false,
      message: `Token refresh failed: ${
        error.response?.data?.message || error.message
      }`,
    };
  } finally {
    isRefreshing.value = false;
  }
};

onMounted(async () => {
  try {
    user.value = await authService.getUser();
  } catch (error) {
    console.error("Failed to load user data:", error);
    // If we can't load user data, the token might be invalid
    emit("logout");
  }
});
</script>

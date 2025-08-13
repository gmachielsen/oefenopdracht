<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex items-center">
            <h1 class="text-xl font-semibold text-gray-900">
              {{ $t("news.title") }}
            </h1>
          </div>
          <div class="flex items-center space-x-4">
            <LanguageSwitcher />
            <router-link
              to="/dashboard"
              class="text-indigo-600 hover:text-indigo-500 text-sm font-medium"
            >
              {{ $t("nav.dashboard") }}
            </router-link>
            <button
              @click="handleLogout"
              class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-md text-sm font-medium"
            >
              {{ $t("nav.logout") }}
            </button>
          </div>
        </div>
      </div>
    </nav>

    <!-- Main content -->
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
      <div class="px-4 py-6 sm:px-0">
        <!-- Loading state -->
        <div v-if="isLoading" class="flex justify-center items-center py-12">
          <div
            class="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600"
          ></div>
        </div>

        <!-- Error state -->
        <div
          v-else-if="error"
          class="bg-red-50 border border-red-200 rounded-md p-4"
        >
          <div class="flex">
            <div class="flex-shrink-0">
              <svg
                class="h-5 w-5 text-red-400"
                viewBox="0 0 20 20"
                fill="currentColor"
              >
                <path
                  fill-rule="evenodd"
                  d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                  clip-rule="evenodd"
                />
              </svg>
            </div>
            <div class="ml-3">
              <h3 class="text-sm font-medium text-red-800">
                {{ $t("news.errorTitle") }}
              </h3>
              <p class="text-sm text-red-700 mt-1">
                {{ error }}
              </p>
            </div>
          </div>
        </div>

        <!-- News grid -->
        <div v-else class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
          <article
            v-for="article in news"
            :key="article.id"
            class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 cursor-pointer"
            @click="viewArticle(article.id)"
          >
            <!-- Image -->
            <div class="aspect-w-16 aspect-h-9">
              <img
                v-if="article.image_url"
                :src="article.image_url"
                :alt="article.title"
                class="w-full h-48 object-cover"
                @error="handleImageError($event)"
              />
              <div
                v-else
                class="w-full h-48 bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center"
              >
                <svg
                  class="w-12 h-12 text-white"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"
                  ></path>
                </svg>
              </div>
            </div>

            <!-- Content -->
            <div class="p-6">
              <!-- Date -->
              <div class="flex items-center text-sm text-gray-500 mb-2">
                <svg
                  class="w-4 h-4 mr-1"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                  ></path>
                </svg>
                {{ formatDate(article.published_at || article.created_at) }}
              </div>

              <!-- Title -->
              <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
                {{ article.title }}
              </h3>

              <!-- Description -->
              <p class="text-gray-600 text-sm line-clamp-3 mb-4">
                {{ article.description }}
              </p>

              <!-- Read more link -->
              <div
                class="flex items-center text-indigo-600 hover:text-indigo-500 text-sm font-medium"
              >
                {{ $t("news.readMore") }}
                <svg
                  class="w-4 h-4 ml-1"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M9 5l7 7-7 7"
                  ></path>
                </svg>
              </div>
            </div>
          </article>
        </div>

        <!-- Empty state -->
        <div
          v-if="!isLoading && !error && news.length === 0"
          class="text-center py-12"
        >
          <svg
            class="mx-auto h-12 w-12 text-gray-400"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"
            ></path>
          </svg>
          <h3 class="mt-2 text-sm font-medium text-gray-900">
            {{ $t("news.noNews") }}
          </h3>
          <p class="mt-1 text-sm text-gray-500">
            {{ $t("news.noNewsDescription") }}
          </p>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";
import { newsService, type NewsArticle } from "../services/newsService";
import { authService } from "../services/authService";
import LanguageSwitcher from "./LanguageSwitcher.vue";

const router = useRouter();

const news = ref<NewsArticle[]>([]);
const isLoading = ref(true);
const error = ref<string | null>(null);

const emit = defineEmits<{
  logout: [];
}>();

const handleLogout = async () => {
  await authService.logout();
  emit("logout");
};

const viewArticle = (id: number) => {
  router.push(`/news/${id}`);
};

const formatDate = (dateString: string): string => {
  return newsService.formatDate(dateString);
};

const handleImageError = (event: Event) => {
  const img = event.target as HTMLImageElement;
  img.style.display = "none";
  const parent = img.parentElement;
  if (parent) {
    parent.innerHTML = `
      <div class="w-full h-48 bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
        </svg>
      </div>
    `;
  }
};

onMounted(async () => {
  try {
    isLoading.value = true;
    news.value = await newsService.getNews();
  } catch (err) {
    error.value = "Er is een fout opgetreden bij het laden van het nieuws.";
    console.error("Error loading news:", err);
  } finally {
    isLoading.value = false;
  }
});
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.aspect-w-16 {
  position: relative;
  padding-bottom: 56.25%; /* 16:9 aspect ratio */
}

.aspect-w-16 > * {
  position: absolute;
  height: 100%;
  width: 100%;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
}
</style>

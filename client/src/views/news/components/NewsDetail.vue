<template>
  <div class="bg-white min-h-screen md:min-h-0 md:rounded-lg md:shadow">
    <!-- Header with back button -->
    <div class="px-3 md:px-6 py-3 md:py-4 border-b border-gray-200">
      <button
        @click="goBack"
        class="inline-flex items-center text-indigo-600 hover:text-indigo-500 text-sm font-medium"
      >
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
            d="M15 19l-7-7 7-7"
          ></path>
        </svg>
        {{ $t("news.backToOverview") }}
      </button>
    </div>

    <div class="p-3 md:p-6">
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

      <!-- Article content -->
      <article v-else-if="article" class="overflow-hidden">
        <!-- Hero image -->
        <div
          v-if="article.image_url"
          class="aspect-w-16 aspect-h-9 -mx-3 md:mx-0 md:rounded-lg overflow-hidden"
        >
          <img
            :src="article.image_url"
            :alt="article.title"
            class="w-full h-48 md:h-64 lg:h-96 object-cover"
            @error="handleImageError($event)"
          />
        </div>

        <!-- Article header -->
        <div class="pt-3 md:pt-6 lg:pt-8">
          <!-- Date and metadata -->
          <div
            class="flex items-center text-xs md:text-sm text-gray-500 mb-3 md:mb-4"
          >
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
          <h1
            class="text-xl md:text-3xl lg:text-4xl font-bold text-gray-900 mb-3 md:mb-4 leading-tight"
          >
            {{ article.title }}
          </h1>

          <!-- Description -->
          <p
            class="text-sm md:text-lg text-gray-600 mb-4 md:mb-6 leading-relaxed"
          >
            {{ article.description }}
          </p>

          <!-- Divider -->
          <hr class="my-6 md:my-8 border-gray-200" />

          <!-- Content -->
          <div class="prose prose-sm md:prose max-w-none text-sm md:text-base">
            <div
              class="text-gray-800 leading-relaxed space-y-3 md:space-y-4"
              v-html="formattedContent"
            ></div>
          </div>
        </div>
      </article>

      <!-- Share buttons -->
      <div
        v-if="article"
        class="mt-4 md:mt-8 pt-4 md:pt-6 border-t border-gray-200"
      >
        <h3 class="text-sm md:text-lg font-semibold text-gray-900 mb-3 md:mb-4">
          {{ $t("news.shareArticle") }}
        </h3>
        <div
          class="flex flex-col space-y-2 md:flex-row md:space-y-0 md:space-x-4"
        >
          <button
            @click="shareOnTwitter"
            class="inline-flex items-center justify-center px-3 py-2 border border-gray-300 rounded-md text-xs md:text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 w-full md:w-auto"
          >
            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
              <path
                d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"
              />
            </svg>
            Twitter
          </button>
          <button
            @click="shareOnLinkedIn"
            class="inline-flex items-center justify-center px-3 py-2 border border-gray-300 rounded-md text-xs md:text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 w-full md:w-auto"
          >
            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
              <path
                d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"
              />
            </svg>
            LinkedIn
          </button>
          <button
            @click="copyLink"
            class="inline-flex items-center justify-center px-3 py-2 border border-gray-300 rounded-md text-xs md:text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 w-full md:w-auto"
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
                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"
              ></path>
            </svg>
            {{ $t("news.copyLink") }}
          </button>
        </div>
        <div v-if="showCopySuccess" class="mt-2 text-sm text-green-600">
          {{ $t("news.linkCopied") }}
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, computed } from "vue";
import { useRouter, useRoute } from "vue-router";
import { useI18n } from "vue-i18n";
import { newsService, type NewsArticle } from "../../../services/newsService";

const router = useRouter();
const route = useRoute();
const { t } = useI18n();

const article = ref<NewsArticle | null>(null);
const isLoading = ref(true);
const error = ref<string | null>(null);
const showCopySuccess = ref(false);

const formattedContent = computed(() => {
  if (!article.value?.content) return "";

  // Simple formatting: convert line breaks to paragraphs
  return article.value.content
    .split("\n\n")
    .map((paragraph) => `<p>${paragraph.replace(/\n/g, "<br>")}</p>`)
    .join("");
});

const goBack = () => {
  router.push("/news");
};

const formatDate = (dateString: string): string => {
  return newsService.formatDate(dateString);
};

const handleImageError = (event: Event) => {
  const img = event.target as HTMLImageElement;
  img.style.display = "none";
};

const shareOnTwitter = () => {
  if (!article.value) return;
  const url = encodeURIComponent(window.location.href);
  const text = encodeURIComponent(article.value.title);
  window.open(
    `https://twitter.com/intent/tweet?url=${url}&text=${text}`,
    "_blank"
  );
};

const shareOnLinkedIn = () => {
  if (!article.value) return;
  const url = encodeURIComponent(window.location.href);
  window.open(
    `https://www.linkedin.com/sharing/share-offsite/?url=${url}`,
    "_blank"
  );
};

const copyLink = async () => {
  try {
    await navigator.clipboard.writeText(window.location.href);
    showCopySuccess.value = true;
    setTimeout(() => {
      showCopySuccess.value = false;
    }, 2000);
  } catch (err) {
    console.error("Failed to copy link:", err);
  }
};

onMounted(async () => {
  try {
    isLoading.value = true;
    const articleId = parseInt(route.params.id as string);

    if (isNaN(articleId)) {
      error.value = t("news.invalidId");
      return;
    }

    article.value = await newsService.getNewsById(articleId);
  } catch (err) {
    error.value = t("news.loadArticleError");
    console.error("Error loading article:", err);
  } finally {
    isLoading.value = false;
  }
});
</script>

<style scoped>
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

.prose p {
  margin-bottom: 1rem;
  line-height: 1.7;
}

.prose p:last-child {
  margin-bottom: 0;
}
</style>

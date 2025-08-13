<template>
  <div class="relative inline-block text-left">
    <button
      @click="toggleDropdown"
      class="inline-flex items-center justify-center w-full px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
    >
      <span
        class="inline-flex items-center justify-center w-6 h-4 text-xs font-semibold text-white bg-blue-600 rounded mr-2"
      >
        {{ currentLocale.flag }}
      </span>
      {{ currentLocale.name }}
      <svg
        class="w-4 h-4 ml-2 -mr-1"
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

    <div
      v-if="isOpen"
      class="absolute right-0 z-10 w-48 mt-2 origin-top-right bg-white border border-gray-200 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
    >
      <div class="py-1" role="menu">
        <button
          v-for="locale in availableLocales"
          :key="locale.code"
          @click="selectLocale(locale.code)"
          class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
          :class="{ 'bg-gray-100': locale.code === $i18n.locale }"
        >
          <span
            class="inline-flex items-center justify-center w-6 h-4 text-xs font-semibold text-white bg-blue-600 rounded mr-3"
          >
            {{ locale.flag }}
          </span>
          {{ locale.name }}
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, onUnmounted } from "vue";
import { useI18n } from "vue-i18n";
import { availableLocales, changeLocale } from "../i18n";

const { locale } = useI18n();
const isOpen = ref(false);

const currentLocale = computed(() => {
  return (
    availableLocales.find((l) => l.code === locale.value) || availableLocales[0]
  );
});

const toggleDropdown = () => {
  isOpen.value = !isOpen.value;
};

const selectLocale = (localeCode: string) => {
  changeLocale(localeCode);
  isOpen.value = false;
};

// Sluit dropdown wanneer er buiten geklikt wordt
const closeDropdown = (event: Event) => {
  const target = event.target as HTMLElement;
  if (!target.closest(".relative")) {
    isOpen.value = false;
  }
};

onMounted(() => {
  document.addEventListener("click", closeDropdown);
});

onUnmounted(() => {
  document.removeEventListener("click", closeDropdown);
});
</script>

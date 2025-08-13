<script setup lang="ts">
import { computed } from "vue";
import { useRoute } from "vue-router";
import AuthLayout from "./layouts/AuthLayout.vue";
import DefaultLayout from "./layouts/DefaultLayout.vue";

const route = useRoute();

// Dynamic component mapping for layouts
const layoutComponents = {
  AuthLayout,
  DefaultLayout,
};

// Get the current layout component or default to div
const currentLayout = computed(() => {
  const layoutName = route.meta.layout as keyof typeof layoutComponents;
  return layoutComponents[layoutName] || "div";
});
</script>

<template>
  <main>
    <component :is="currentLayout">
      <router-view v-slot="{ Component }">
        <component :is="Component" />
      </router-view>
    </component>
  </main>
</template>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}
</style>

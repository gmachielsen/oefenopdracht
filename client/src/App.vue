<script setup lang="ts">
import { ref, onMounted } from "vue";
import { exampleService, type Example } from "./services/exampleService";

const examples = ref<Example[]>([]);
const loading = ref(false);
const error = ref<string | null>(null);
const newExample = ref({ name: "", email: "" });

// Test API connection
const testConnection = async () => {
  try {
    loading.value = true;
    const response = await exampleService.testConnection();
    console.log("API Test:", response);
  } catch (err) {
    console.error("API Test failed:", err);
    error.value = "Failed to connect to API";
  } finally {
    loading.value = false;
  }
};

// Load examples
const loadExamples = async () => {
  try {
    loading.value = true;
    const response = await exampleService.getAll();
    examples.value = response.data || [];
  } catch (err) {
    console.error("Failed to load examples:", err);
    error.value = "Failed to load data";
  } finally {
    loading.value = false;
  }
};

// Create new example
const createExample = async () => {
  if (!newExample.value.name || !newExample.value.email) {
    alert("Please fill in all fields");
    return;
  }

  try {
    await exampleService.create(newExample.value);
    newExample.value = { name: "", email: "" };
    await loadExamples();
  } catch (err) {
    console.error("Failed to create example:", err);
    error.value = "Failed to create example";
  }
};

onMounted(() => {
  testConnection();
  loadExamples();
});
</script>

<template>
  <div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
      <h1 class="text-4xl font-bold text-gray-900 text-center mb-8">
        Vue + Laravel App
      </h1>

      <!-- API Test Section -->
      <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">API Test</h2>
        <button
          @click="testConnection"
          :disabled="loading"
          class="bg-blue-500 hover:bg-blue-600 disabled:bg-gray-400 text-white font-medium py-2 px-4 rounded-md transition duration-200"
        >
          {{ loading ? "Testing..." : "Test API Connection" }}
        </button>
      </div>

      <!-- Create New Example Section -->
      <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">
          Create New Example
        </h2>
        <form
          @submit.prevent="createExample"
          class="flex flex-col sm:flex-row gap-4"
        >
          <input
            v-model="newExample.name"
            type="text"
            placeholder="Name"
            required
            class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
          />
          <input
            v-model="newExample.email"
            type="email"
            placeholder="Email"
            required
            class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
          />
          <button
            type="submit"
            :disabled="loading"
            class="bg-blue-500 hover:bg-blue-600 disabled:bg-gray-400 text-white font-medium py-2 px-6 rounded-md transition duration-200 whitespace-nowrap"
          >
            {{ loading ? "Creating..." : "Create Example" }}
          </button>
        </form>
      </div>

      <!-- Examples Section -->
      <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-2xl font-semibold text-gray-800">Examples</h2>
          <button
            @click="loadExamples"
            :disabled="loading"
            class="bg-green-500 hover:bg-green-600 disabled:bg-gray-400 text-white font-medium py-2 px-4 rounded-md transition duration-200"
          >
            {{ loading ? "Loading..." : "Reload Examples" }}
          </button>
        </div>

        <!-- Error Message -->
        <div
          v-if="error"
          class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-md mb-4"
        >
          {{ error }}
        </div>

        <!-- No Examples Message -->
        <div
          v-if="examples.length === 0 && !loading"
          class="bg-gray-50 border border-gray-200 text-gray-600 px-4 py-3 rounded-md text-center"
        >
          No examples found
        </div>

        <!-- Examples List -->
        <div class="space-y-4">
          <div
            v-for="example in examples"
            :key="example.id"
            class="bg-gray-50 border border-gray-200 rounded-md p-4 hover:bg-gray-100 transition duration-200"
          >
            <h3 class="text-lg font-medium text-gray-900">
              {{ example.name }}
            </h3>
            <p class="text-gray-600 mt-1">{{ example.email }}</p>
            <small class="text-gray-500 text-sm">{{
              example.created_at
            }}</small>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
/* Custom styles can be added here if needed */
</style>

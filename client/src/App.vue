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
  <div id="app">
    <h1>Vue + Laravel App</h1>

    <div class="section">
      <h2>API Test</h2>
      <button @click="testConnection" :disabled="loading">
        {{ loading ? "Testing..." : "Test API Connection" }}
      </button>
    </div>

    <div class="section">
      <h2>Create New Example</h2>
      <form @submit.prevent="createExample" class="form">
        <input
          v-model="newExample.name"
          type="text"
          placeholder="Name"
          required
        />
        <input
          v-model="newExample.email"
          type="email"
          placeholder="Email"
          required
        />
        <button type="submit" :disabled="loading">
          {{ loading ? "Creating..." : "Create Example" }}
        </button>
      </form>
    </div>

    <div class="section">
      <h2>Examples</h2>
      <button @click="loadExamples" :disabled="loading">
        {{ loading ? "Loading..." : "Reload Examples" }}
      </button>

      <div v-if="error" class="error">
        {{ error }}
      </div>

      <div v-if="examples.length === 0 && !loading" class="info">
        No examples found
      </div>

      <div v-for="example in examples" :key="example.id" class="example-card">
        <h3>{{ example.name }}</h3>
        <p>{{ example.email }}</p>
        <small>{{ example.created_at }}</small>
      </div>
    </div>
  </div>
</template>

<style scoped>
#app {
  max-width: 800px;
  margin: 0 auto;
  padding: 2rem;
  font-family: Arial, sans-serif;
}

.section {
  margin-bottom: 2rem;
  padding: 1rem;
  border: 1px solid #ddd;
  border-radius: 8px;
}

.form {
  display: flex;
  gap: 1rem;
  margin-bottom: 1rem;
}

.form input {
  padding: 0.5rem;
  border: 1px solid #ddd;
  border-radius: 4px;
  flex: 1;
}

.form button {
  padding: 0.5rem 1rem;
  background: #007bff;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.form button:hover:not(:disabled) {
  background: #0056b3;
}

.form button:disabled {
  background: #ccc;
  cursor: not-allowed;
}

.example-card {
  padding: 1rem;
  border: 1px solid #eee;
  border-radius: 4px;
  margin-bottom: 1rem;
}

.error {
  color: red;
  padding: 1rem;
  background: #fee;
  border: 1px solid #fcc;
  border-radius: 4px;
  margin: 1rem 0;
}

.info {
  color: #666;
  padding: 1rem;
  background: #f9f9f9;
  border-radius: 4px;
}

button {
  padding: 0.5rem 1rem;
  background: #28a745;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  margin-bottom: 1rem;
}

button:hover:not(:disabled) {
  background: #1e7e34;
}

button:disabled {
  background: #ccc;
  cursor: not-allowed;
}
</style>

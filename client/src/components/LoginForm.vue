<template>
  <div
    class="min-h-screen flex items-center justify-center bg-gray-100 py-12 px-4 sm:px-6 lg:px-8"
  >
    <div class="max-w-md w-full space-y-8">
      <!-- Login Card -->
      <div class="bg-white rounded-lg shadow-lg px-8 py-10">
        <!-- Logo and Header -->
        <div class="text-center mb-8">
          <h1 class="text-2xl font-bold text-gray-900 mb-2">
            {{ $t("auth.welcome") }}
          </h1>
          <p class="text-gray-600 text-sm">{{ $t("auth.login") }}</p>
        </div>

        <!-- Login Form -->
        <form @submit.prevent="handleLogin" class="space-y-6">
          <!-- Email Field -->
          <InputField
            id="email"
            v-model="email"
            name="email"
            type="email"
            :label="$t('auth.email')"
            :placeholder="$t('auth.email')"
            autocomplete="email"
            :required="true"
            :error="emailError"
            variant="login"
            label-class="mb-2"
          />

          <!-- Password Field -->
          <InputField
            id="password"
            v-model="password"
            name="password"
            type="password"
            :label="$t('auth.password')"
            :placeholder="$t('auth.password')"
            autocomplete="current-password"
            :required="true"
            :error="passwordError"
            variant="login"
            label-class="mb-2"
          />

          <!-- Remember me and Forgot password -->
          <div class="flex items-center justify-between">
            <div class="flex items-center">
              <input
                id="remember"
                type="checkbox"
                class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded"
              />
              <label for="remember" class="ml-2 text-sm text-gray-600">
                Onthoud mijn gegevens
              </label>
            </div>
            <div>
              <a
                href="#"
                class="text-sm text-gray-500 hover:text-purple-600 transition-colors"
              >
                Wachtwoord vergeten?
              </a>
            </div>
          </div>

          <!-- Error Message -->
          <div
            v-if="errorMessage"
            class="rounded-lg bg-red-50 p-4 border border-red-200"
          >
            <div class="flex">
              <div class="flex-shrink-0">
                <svg
                  class="h-5 w-5 text-red-400"
                  xmlns="http://www.w3.org/2000/svg"
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
                  Inloggen mislukt
                </h3>
                <div class="mt-1 text-sm text-red-700">
                  <p>{{ errorMessage }}</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Login Button -->
          <div>
            <button
              type="submit"
              :disabled="isLoading"
              class="w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-purple-700 hover:bg-purple-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
            >
              <span v-if="isLoading" class="flex items-center">
                <svg
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
                {{ $t("common.loading") }}
              </span>
              <span v-else>{{ $t("auth.login") }}</span>
            </button>
          </div>
        </form>

        <!-- Test credentials hint -->
        <div class="mt-6 text-center">
          <p class="text-xs text-gray-500">
            Test met: test@golfspot.io / wachtwoord123
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from "vue";
import { authService } from "../services/authService";
import InputField from "./ui/InputField.vue";

const emit = defineEmits<{
  loginSuccess: [];
}>();

const email = ref("");
const password = ref("");
const isLoading = ref(false);
const errorMessage = ref("");
const emailError = ref("");
const passwordError = ref("");

const clearErrors = () => {
  errorMessage.value = "";
  emailError.value = "";
  passwordError.value = "";
};

const validateForm = () => {
  clearErrors();
  let isValid = true;

  if (!email.value) {
    emailError.value = "Email is required";
    isValid = false;
  } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
    emailError.value = "Please enter a valid email address";
    isValid = false;
  }

  if (!password.value) {
    passwordError.value = "Password is required";
    isValid = false;
  } else if (password.value.length < 6) {
    passwordError.value = "Password must be at least 6 characters";
    isValid = false;
  }

  return isValid;
};

const handleLogin = async () => {
  if (!validateForm()) {
    return;
  }

  isLoading.value = true;
  clearErrors();

  try {
    await authService.login({ email: email.value, password: password.value });
    emit("loginSuccess");
  } catch (error: any) {
    console.error("Login error:", error);

    if (error.response?.status === 401) {
      errorMessage.value = "Invalid email or password";
    } else if (error.response?.data?.message) {
      errorMessage.value = error.response.data.message;
    } else {
      errorMessage.value = "An error occurred. Please try again.";
    }
  } finally {
    isLoading.value = false;
  }
};
</script>

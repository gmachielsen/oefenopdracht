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
                class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded"
              />
              <label for="remember" class="ml-2 text-sm text-gray-600">
                {{ $t("auth.rememberMe") }}
              </label>
            </div>
            <div>
              <a
                href="#"
                class="text-sm text-gray-500 hover:text-primary-600 transition-colors"
              >
                {{ $t("auth.forgotPassword") }}
              </a>
            </div>
          </div>

          <!-- Error Message -->
          <Alert
            v-if="errorMessage"
            type="error"
            :message="errorMessage"
            dismissible
            v-model="showErrorAlert"
            @dismiss="clearErrorMessage"
          />

          <!-- Login Button -->
          <div>
            <Button
              type="submit"
              variant="primary"
              size="lg"
              :loading="isLoading"
              :loading-text="$t('common.loading')"
              full-width
            >
              {{ $t("auth.login") }}
            </Button>
          </div>
        </form>

        <!-- Test credentials hint -->
        <div class="mt-6 text-center">
          <p class="text-xs text-gray-500">
            {{ testCredentialsText }}
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from "vue";
import { useI18n } from "vue-i18n";
import { authService } from "../../../../services/authService";
import InputField from "../../../../components/ui/InputField.vue";
import { Alert, Button } from "../../../../components/ui";

const { t } = useI18n();

const emit = defineEmits<{
  loginSuccess: [];
}>();

const email = ref("");
const password = ref("");
const isLoading = ref(false);
const errorMessage = ref("");
const showErrorAlert = ref(false);
const emailError = ref("");
const passwordError = ref("");

const testCredentialsText = "Test met: test@golfspot.io / wachtwoord123";

const clearErrors = () => {
  errorMessage.value = "";
  emailError.value = "";
  passwordError.value = "";
  showErrorAlert.value = false;
};

const clearErrorMessage = () => {
  errorMessage.value = "";
  showErrorAlert.value = false;
};

const validateForm = () => {
  clearErrors();
  let isValid = true;

  if (!email.value) {
    emailError.value = t("auth.validation.emailRequired");
    isValid = false;
  } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
    emailError.value = t("auth.validation.emailInvalid");
    isValid = false;
  }

  if (!password.value) {
    passwordError.value = t("auth.validation.passwordRequired");
    isValid = false;
  } else if (password.value.length < 6) {
    passwordError.value = t("auth.validation.passwordMinLength");
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

    if (error.response?.status === 500) {
      const serverError = error.response?.data?.message || "";
      if (
        serverError.includes("Connection refused") ||
        serverError.includes("SQLSTATE")
      ) {
        errorMessage.value = t("auth.errors.databaseConnection");
      } else {
        errorMessage.value = t("auth.errors.serverError");
      }
    } else if (error.response?.status === 401) {
      errorMessage.value = t("auth.errors.invalidCredentials");
    } else if (error.response?.data?.message) {
      errorMessage.value = error.response.data.message;
    } else if (error.code === "ERR_NETWORK") {
      errorMessage.value = t("auth.errors.networkError");
    } else {
      errorMessage.value = t("auth.errors.genericError");
    }
    showErrorAlert.value = true;
  } finally {
    isLoading.value = false;
  }
};
</script>

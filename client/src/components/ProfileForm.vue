<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex items-center">
            <h1 class="text-xl font-semibold text-gray-900">Profiel</h1>
          </div>
          <div class="flex items-center space-x-4">
            <span class="text-sm text-gray-700">{{ user?.email }}</span>
            <button
              @click="handleLogout"
              class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-md text-sm font-medium"
            >
              Uitloggen
            </button>
          </div>
        </div>
      </div>
    </nav>

    <!-- Main content -->
    <main class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
      <div class="px-4 py-6 sm:px-0">
        <!-- Profile Form -->
        <div class="bg-white shadow rounded-lg">
          <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-6">
              Profiel Gegevens
            </h3>

            <!-- Success/Error Messages -->
            <div v-if="successMessage" class="mb-4 rounded-md bg-green-50 p-4">
              <div class="flex">
                <div class="flex-shrink-0">
                  <svg
                    class="h-5 w-5 text-green-400"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"
                    />
                  </svg>
                </div>
                <div class="ml-3">
                  <p class="text-sm font-medium text-green-800">
                    {{ successMessage }}
                  </p>
                </div>
              </div>
            </div>

            <div v-if="errorMessage" class="mb-4 rounded-md bg-red-50 p-4">
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
                  <p class="text-sm font-medium text-red-800">
                    {{ errorMessage }}
                  </p>
                </div>
              </div>
            </div>

            <form @submit.prevent="handleSubmit" class="space-y-6">
              <!-- Profile Photo -->
              <div class="flex items-center space-x-6">
                <div class="shrink-0">
                  <img
                    :src="formData.profile_photo || '/default-avatar.svg'"
                    :alt="fullName"
                    class="h-16 w-16 object-cover rounded-full border-2 border-gray-300"
                    @error="handleImageError"
                  />
                </div>
                <div class="flex-1">
                  <label
                    for="profile_photo"
                    class="block text-sm font-medium text-gray-700"
                  >
                    Profielfoto (URL)
                  </label>
                  <input
                    id="profile_photo"
                    v-model="formData.profile_photo"
                    type="url"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    placeholder="https://example.com/foto.jpg"
                  />
                </div>
              </div>

              <!-- Name Fields -->
              <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                  <label
                    for="first_name"
                    class="block text-sm font-medium text-gray-700"
                  >
                    Voornaam
                  </label>
                  <input
                    id="first_name"
                    v-model="formData.first_name"
                    type="text"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    placeholder="Voornaam"
                  />
                </div>

                <div>
                  <label
                    for="last_name"
                    class="block text-sm font-medium text-gray-700"
                  >
                    Achternaam
                  </label>
                  <input
                    id="last_name"
                    v-model="formData.last_name"
                    type="text"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    placeholder="Achternaam"
                  />
                </div>
              </div>

              <!-- Email -->
              <div>
                <label
                  for="email"
                  class="block text-sm font-medium text-gray-700"
                >
                  E-mailadres
                </label>
                <input
                  id="email"
                  v-model="formData.email"
                  type="email"
                  required
                  class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                  placeholder="email@voorbeeld.nl"
                />
              </div>

              <!-- Birth Date -->
              <div>
                <label
                  for="birth_date"
                  class="block text-sm font-medium text-gray-700"
                >
                  Geboortedatum
                </label>
                <input
                  id="birth_date"
                  v-model="formData.birth_date"
                  type="date"
                  class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                />
              </div>

              <!-- Submit Button -->
              <div class="flex justify-end space-x-3">
                <button
                  type="button"
                  @click="resetForm"
                  class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                  Reset
                </button>
                <button
                  type="submit"
                  :disabled="isLoading"
                  class="bg-indigo-600 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed"
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
                    Opslaan...
                  </span>
                  <span v-else>Profiel Opslaan</span>
                </button>
              </div>
            </form>
          </div>
        </div>

        <!-- Current Profile Info -->
        <div class="mt-8 bg-white shadow rounded-lg">
          <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
              Huidige Profiel Informatie
            </h3>
            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
              <div>
                <dt class="text-sm font-medium text-gray-500">
                  Volledige naam
                </dt>
                <dd class="mt-1 text-sm text-gray-900">
                  {{ fullName || "Niet ingevuld" }}
                </dd>
              </div>
              <div>
                <dt class="text-sm font-medium text-gray-500">E-mail</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ user?.email }}</dd>
              </div>
              <div>
                <dt class="text-sm font-medium text-gray-500">Geboortedatum</dt>
                <dd class="mt-1 text-sm text-gray-900">
                  {{ formattedBirthDate || "Niet ingevuld" }}
                </dd>
              </div>
              <div>
                <dt class="text-sm font-medium text-gray-500">Account ID</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ user?.id }}</dd>
              </div>
            </dl>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from "vue";
import {
  authService,
  type User,
  type UpdateProfileData,
} from "../services/authService";

const emit = defineEmits<{
  logout: [];
}>();

const user = ref<User | null>(null);
const isLoading = ref(false);
const successMessage = ref("");
const errorMessage = ref("");

const formData = ref<UpdateProfileData>({
  first_name: "",
  last_name: "",
  email: "",
  birth_date: "",
  profile_photo: "",
});

const fullName = computed(() => {
  if (user.value?.first_name && user.value?.last_name) {
    return `${user.value.first_name} ${user.value.last_name}`;
  } else if (user.value?.first_name) {
    return user.value.first_name;
  } else if (user.value?.last_name) {
    return user.value.last_name;
  }
  return user.value?.name || "";
});

const formattedBirthDate = computed(() => {
  if (user.value?.birth_date) {
    return new Date(user.value.birth_date).toLocaleDateString("nl-NL");
  }
  return null;
});

const handleLogout = async () => {
  await authService.logout();
  emit("logout");
};

const handleImageError = (event: Event) => {
  const target = event.target as HTMLImageElement;
  target.src = "/default_avatar.svg";
};

const clearMessages = () => {
  successMessage.value = "";
  errorMessage.value = "";
};

const resetForm = () => {
  if (user.value) {
    formData.value = {
      first_name: user.value.first_name || "",
      last_name: user.value.last_name || "",
      email: user.value.email,
      birth_date: user.value.birth_date
        ? formatDateForInput(user.value.birth_date)
        : "",
      profile_photo: user.value.profile_photo || "",
    };
  }
  clearMessages();
};

// Helper function to format date for HTML input
const formatDateForInput = (dateString: string): string => {
  if (!dateString) return "";

  // Create date object and format as YYYY-MM-DD
  const date = new Date(dateString);
  if (isNaN(date.getTime())) return "";

  return date.toISOString().split("T")[0];
};

const handleSubmit = async () => {
  if (!user.value) return;

  isLoading.value = true;
  clearMessages();

  try {
    // Only send changed fields
    const updateData: UpdateProfileData = {};

    if (formData.value.first_name !== (user.value.first_name || "")) {
      updateData.first_name = formData.value.first_name;
    }
    if (formData.value.last_name !== (user.value.last_name || "")) {
      updateData.last_name = formData.value.last_name;
    }
    if (formData.value.email !== user.value.email) {
      updateData.email = formData.value.email;
    }
    if (
      formData.value.birth_date !==
      (user.value.birth_date ? formatDateForInput(user.value.birth_date) : "")
    ) {
      updateData.birth_date = formData.value.birth_date;
    }
    if (formData.value.profile_photo !== (user.value.profile_photo || "")) {
      updateData.profile_photo = formData.value.profile_photo;
    }

    if (Object.keys(updateData).length === 0) {
      errorMessage.value = "Geen wijzigingen gedetecteerd";
      return;
    }

    const updatedUser = await authService.updateProfile(updateData);
    user.value = updatedUser;
    successMessage.value = "Profiel succesvol bijgewerkt!";

    // Auto-hide success message after 3 seconds
    setTimeout(() => {
      successMessage.value = "";
    }, 3000);
  } catch (error: any) {
    console.error("Profile update error:", error);

    if (error.response?.data?.errors) {
      const errors = error.response.data.errors;
      const errorMessages = Object.values(errors).flat().join(", ");
      errorMessage.value = errorMessages;
    } else if (error.response?.data?.message) {
      errorMessage.value = error.response.data.message;
    } else {
      errorMessage.value =
        "Er is een fout opgetreden bij het bijwerken van je profiel";
    }
  } finally {
    isLoading.value = false;
  }
};

onMounted(async () => {
  try {
    user.value = await authService.getUser();
    resetForm();
  } catch (error) {
    console.error("Failed to load user data:", error);
    emit("logout");
  }
});
</script>

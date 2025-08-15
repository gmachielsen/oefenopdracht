<template>
  <div class="bg-white shadow rounded-lg">
    <div class="px-4 py-5 sm:p-6">
      <h3 class="text-lg leading-6 font-medium text-gray-900 mb-6">
        {{ $t("profile.title") }}
      </h3>

      <!-- Success/Error Messages -->
      <Alert
        v-if="successMessage"
        type="success"
        :message="successMessage"
        :auto-hide="true"
        :auto-hide-delay="3000"
        v-model="showSuccessAlert"
      />

      <Alert
        v-if="errorMessage"
        type="error"
        :message="errorMessage"
        dismissible
        v-model="showErrorAlert"
        @dismiss="clearErrorMessage"
      />

      <form @submit.prevent="handleSubmit" class="space-y-6">
        <!-- Profile Photo -->
        <div class="flex items-center space-x-6">
          <div class="shrink-0 relative">
            <!-- When there is a profile photo -->
            <div
              v-if="profileImageSrc"
              class="h-20 w-20 rounded-full border-2 border-gray-300 cursor-pointer hover:border-indigo-500 transition-colors overflow-hidden relative group"
              @click="triggerFileUpload"
            >
              <img
                :src="profileImageSrc"
                :alt="fullName"
                class="h-full w-full object-cover"
                loading="eager"
                @error="handleImageError"
              />
              <div
                class="absolute inset-0 rounded-full bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer flex items-center justify-center"
              >
                <svg
                  class="h-6 w-6 text-white"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"
                  />
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"
                  />
                </svg>
              </div>
            </div>
            <!-- When there is no profile photo (fallback) -->
            <div
              v-else
              class="h-20 w-20 rounded-full border-2 border-gray-300 cursor-pointer hover:border-indigo-500 transition-colors bg-gray-200 flex items-center justify-center relative group"
              @click="triggerFileUpload"
            >
              <svg
                class="h-12 w-12 text-gray-400"
                fill="currentColor"
                viewBox="0 0 20 20"
              >
                <path
                  fill-rule="evenodd"
                  d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                  clip-rule="evenodd"
                />
              </svg>
              <div
                class="absolute inset-0 rounded-full bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer flex items-center justify-center"
              >
                <svg
                  class="h-6 w-6 text-white"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"
                  />
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"
                  />
                </svg>
              </div>
            </div>
            <input
              ref="fileInput"
              type="file"
              accept="image/*"
              class="hidden"
              @change="handleFileUpload"
            />
          </div>
          <div class="flex-1">
            <h4 class="text-sm font-medium text-gray-700 mb-2">
              {{ $t("profile.photo.label") }}
            </h4>
            <p class="text-sm text-gray-500 mb-2">
              {{ $t("profile.photo.clickToUpload") }}
            </p>
            <div v-if="uploadedFile" class="text-sm text-green-600">
              {{ uploadedFile.name }} ({{ formatFileSize(uploadedFile.size) }})
            </div>
            <div v-if="isUploading" class="flex items-center space-x-2">
              <svg
                class="animate-spin h-4 w-4 text-indigo-500"
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
              <span class="text-sm text-gray-600">{{
                $t("profile.messages.uploading")
              }}</span>
            </div>
          </div>
        </div>

        <!-- Name Fields -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
          <InputField
            id="first_name"
            v-model="formData.first_name"
            type="text"
            :label="$t('profile.fields.firstName')"
            :placeholder="$t('profile.placeholders.firstName')"
          />

          <InputField
            id="last_name"
            v-model="formData.last_name"
            type="text"
            :label="$t('profile.fields.lastName')"
            :placeholder="$t('profile.placeholders.lastName')"
          />
        </div>

        <!-- Email -->
        <InputField
          id="email"
          v-model="formData.email"
          type="email"
          :label="$t('profile.fields.email')"
          :placeholder="$t('profile.placeholders.email')"
          :required="true"
        />

        <!-- Birth Date -->
        <InputField
          id="birth_date"
          v-model="formData.birth_date"
          type="date"
          :label="$t('profile.fields.birthDate')"
        />

        <!-- Submit Button -->
        <div class="flex justify-end space-x-3">
          <Button type="button" variant="secondary" @click="resetForm">
            {{ $t("profile.buttons.reset") }}
          </Button>
          <Button
            type="submit"
            variant="primary"
            :loading="isLoading"
            :loading-text="$t('profile.buttons.saving')"
          >
            {{ $t("profile.buttons.save") }}
          </Button>
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
          <dt class="text-sm font-medium text-gray-500">Volledige naam</dt>
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
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from "vue";
import {
  authService,
  type User,
  type UpdateProfileData,
} from "../../../services/authService";
import InputField from "../../../components/ui/InputField.vue";
import { Alert, Button } from "../../../components/ui";

const user = ref<User | null>(null);
const isLoading = ref(false);
const isUploading = ref(false);
const successMessage = ref("");
const errorMessage = ref("");
const showSuccessAlert = ref(false);
const showErrorAlert = ref(false);
const uploadedFile = ref<File | null>(null);
const fileInput = ref<HTMLInputElement | null>(null);

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
  return "";
});

const profileImageSrc = computed(() => {
  if (uploadedFile.value) {
    return URL.createObjectURL(uploadedFile.value);
  }
  // Check if profile_photo exists and is not empty/whitespace
  if (formData.value.profile_photo && formData.value.profile_photo.trim()) {
    return formData.value.profile_photo;
  }
  return null; // Return null so we can show the SVG fallback instead
});

const formattedBirthDate = computed(() => {
  if (user.value?.birth_date) {
    return new Date(user.value.birth_date).toLocaleDateString("nl-NL");
  }
  return null;
});

const handleImageError = (event: Event) => {
  const target = event.target as HTMLImageElement;
  // Hide the image container by setting the profile photo to empty
  formData.value.profile_photo = "";
};

const triggerFileUpload = () => {
  fileInput.value?.click();
};

const formatFileSize = (bytes: number): string => {
  if (bytes === 0) return "0 Bytes";
  const k = 1024;
  const sizes = ["Bytes", "KB", "MB", "GB"];
  const i = Math.floor(Math.log(bytes) / Math.log(k));
  return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + " " + sizes[i];
};

const handleFileUpload = async (event: Event) => {
  const target = event.target as HTMLInputElement;
  const file = target.files?.[0];

  if (!file) return;

  // Validate file type
  if (!file.type.startsWith("image/")) {
    errorMessage.value = "Alleen afbeeldingsbestanden zijn toegestaan";
    showErrorAlert.value = true;
    return;
  }

  // Validate file size (max 5MB)
  if (file.size > 5 * 1024 * 1024) {
    errorMessage.value = "Bestand is te groot. Maximum grootte is 5MB";
    showErrorAlert.value = true;
    return;
  }

  uploadedFile.value = file;
  clearMessages();
};

const clearMessages = () => {
  successMessage.value = "";
  errorMessage.value = "";
  showSuccessAlert.value = false;
  showErrorAlert.value = false;
};

const clearErrorMessage = () => {
  errorMessage.value = "";
  showErrorAlert.value = false;
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
  uploadedFile.value = null;
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
    // Handle file upload first if there's a new file
    if (uploadedFile.value) {
      isUploading.value = true;
      try {
        const base64Data = await authService.uploadProfilePhoto(
          uploadedFile.value
        );
        formData.value.profile_photo = base64Data;
        uploadedFile.value = null; // Clear the uploaded file
      } catch (uploadError) {
        console.error("File upload error:", uploadError);
        errorMessage.value = "Fout bij het converteren van de foto";
        showErrorAlert.value = true;
        return;
      } finally {
        isUploading.value = false;
      }
    }

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

    if (Object.keys(updateData).length === 0 && !uploadedFile.value) {
      errorMessage.value = "Geen wijzigingen gedetecteerd";
      showErrorAlert.value = true;
      return;
    }

    if (Object.keys(updateData).length > 0) {
      const updatedUser = await authService.updateProfile(updateData);
      user.value = updatedUser;

      // Emit custom event to notify other components
      window.dispatchEvent(new CustomEvent("profile-updated"));
    }

    successMessage.value = "Profiel succesvol bijgewerkt!";
    showSuccessAlert.value = true;
    // Auto-hide success message after 3 seconds
    setTimeout(() => {
      successMessage.value = "";
      showSuccessAlert.value = false;
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
    showErrorAlert.value = true;
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
    // Redirect will be handled by the layout
  }
});
</script>

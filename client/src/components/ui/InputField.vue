<template>
  <div :class="containerClass">
    <label
      v-if="label"
      :for="id"
      class="block text-sm font-medium text-gray-700"
      :class="labelClass"
    >
      {{ label }}
    </label>
    <input
      :id="id"
      :type="type"
      :name="name"
      :placeholder="placeholder"
      :required="required"
      :disabled="disabled"
      :autocomplete="autocomplete"
      :value="modelValue || ''"
      @input="
        $emit('update:modelValue', ($event.target as HTMLInputElement).value)
      "
      :class="inputClasses"
    />
    <p v-if="error" class="mt-1 text-sm text-red-600">
      {{ error }}
    </p>
  </div>
</template>

<script setup lang="ts">
import { computed } from "vue";

interface Props {
  modelValue: string | undefined;
  id: string;
  label?: string;
  type?: string;
  name?: string;
  placeholder?: string;
  required?: boolean;
  disabled?: boolean;
  autocomplete?: string;
  error?: string;
  variant?: "default" | "login";
  containerClass?: string;
  labelClass?: string;
  inputClass?: string;
}

const props = withDefaults(defineProps<Props>(), {
  type: "text",
  required: false,
  disabled: false,
  variant: "default",
});

defineEmits<{
  "update:modelValue": [value: string];
}>();

const inputClasses = computed(() => {
  const baseClasses =
    "block w-full border placeholder-gray-400 focus:outline-none transition-colors text-gray-900";

  const variantClasses =
    props.variant === "login"
      ? "px-4 py-3 rounded-lg"
      : "mt-1 px-3 py-2 rounded-md shadow-sm sm:text-sm";

  const stateClasses = props.error
    ? "border-red-300 focus:ring-red-500 focus:border-red-500"
    : props.variant === "login"
    ? "border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent"
    : "border-gray-300 focus:ring-primary-500 focus:border-primary-500";

  return `${baseClasses} ${variantClasses} ${stateClasses} ${
    props.inputClass || ""
  }`;
});
</script>

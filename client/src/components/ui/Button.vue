<template>
  <button
    :type="type"
    :disabled="disabled"
    :class="buttonClasses"
    @click="handleClick"
  >
    <slot v-if="!loading" />
    <span v-else class="flex items-center">
      <svg
        class="animate-spin -ml-1 mr-3 h-5 w-5"
        :class="loadingIconClasses"
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
      {{ loadingText }}
    </span>
  </button>
</template>

<script setup lang="ts">
import { computed } from "vue";

export interface ButtonProps {
  type?: "button" | "submit" | "reset";
  variant?: "primary" | "secondary" | "neutral" | "danger" | "ghost";
  size?: "sm" | "md" | "lg";
  loading?: boolean;
  disabled?: boolean;
  loadingText?: string;
  fullWidth?: boolean;
}

const props = withDefaults(defineProps<ButtonProps>(), {
  type: "button",
  variant: "primary",
  size: "md",
  loading: false,
  disabled: false,
  loadingText: "Loading...",
  fullWidth: false,
});

const emit = defineEmits<{
  click: [event: MouseEvent];
}>();

const handleClick = (event: MouseEvent) => {
  if (!props.loading && !props.disabled) {
    emit("click", event);
  }
};

const baseClasses =
  "inline-flex items-center justify-center font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors disabled:opacity-50 disabled:cursor-not-allowed";

const variantClasses = computed(() => {
  const variants = {
    primary:
      "text-white bg-brand-purple-600 hover:bg-brand-purple-700 focus:ring-brand-purple-500",
    secondary:
      "text-white bg-primary-600 hover:bg-primary-700 focus:ring-primary-500",
    neutral:
      "text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 focus:ring-primary-500",
    danger: "text-white bg-red-600 hover:bg-red-700 focus:ring-red-500",
    ghost:
      "text-gray-700 bg-transparent hover:bg-gray-100 focus:ring-primary-500",
  };
  return variants[props.variant];
});

const sizeClasses = computed(() => {
  const sizes = {
    sm: "px-3 py-2 text-sm",
    md: "px-4 py-2 text-sm",
    lg: "px-6 py-3 text-base",
  };
  return sizes[props.size];
});

const widthClasses = computed(() => {
  return props.fullWidth ? "w-full" : "";
});

const buttonClasses = computed(() => {
  return [
    baseClasses,
    variantClasses.value,
    sizeClasses.value,
    widthClasses.value,
  ].join(" ");
});

const loadingIconClasses = computed(() => {
  const iconColors = {
    primary: "text-white",
    secondary: "text-white",
    neutral: "text-gray-700",
    danger: "text-white",
    ghost: "text-gray-700",
  };
  return iconColors[props.variant];
});
</script>

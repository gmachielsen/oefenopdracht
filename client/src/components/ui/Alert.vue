<template>
  <div v-if="show" :class="alertClasses" class="mb-4 rounded-md p-4">
    <div class="flex">
      <div class="flex-shrink-0">
        <component :is="iconComponent" :class="iconClasses" class="h-5 w-5" />
      </div>
      <div class="ml-3">
        <p :class="textClasses" class="text-sm font-medium">
          {{ message }}
        </p>
      </div>
      <div v-if="dismissible" class="ml-auto pl-3">
        <button
          @click="dismiss"
          :class="buttonClasses"
          class="inline-flex rounded-md p-1.5 focus:outline-none focus:ring-2 focus:ring-offset-2"
        >
          <span class="sr-only">Sluiten</span>
          <component :is="XMarkIcon" class="h-5 w-5" />
        </button>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed, ref, watch, h } from "vue";

// Icon render functions (geen template compiler nodig)
const CheckCircleIcon = () =>
  h(
    "svg",
    {
      xmlns: "http://www.w3.org/2000/svg",
      viewBox: "0 0 20 20",
      fill: "currentColor",
    },
    [
      h("path", {
        "fill-rule": "evenodd",
        d: "M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z",
        "clip-rule": "evenodd",
      }),
    ]
  );

const ExclamationCircleIcon = () =>
  h(
    "svg",
    {
      xmlns: "http://www.w3.org/2000/svg",
      viewBox: "0 0 20 20",
      fill: "currentColor",
    },
    [
      h("path", {
        "fill-rule": "evenodd",
        d: "M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z",
        "clip-rule": "evenodd",
      }),
    ]
  );

const XCircleIcon = () =>
  h(
    "svg",
    {
      xmlns: "http://www.w3.org/2000/svg",
      viewBox: "0 0 20 20",
      fill: "currentColor",
    },
    [
      h("path", {
        "fill-rule": "evenodd",
        d: "M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z",
        "clip-rule": "evenodd",
      }),
    ]
  );

const InformationCircleIcon = () =>
  h(
    "svg",
    {
      xmlns: "http://www.w3.org/2000/svg",
      viewBox: "0 0 20 20",
      fill: "currentColor",
    },
    [
      h("path", {
        "fill-rule": "evenodd",
        d: "M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z",
        "clip-rule": "evenodd",
      }),
    ]
  );

const XMarkIcon = () =>
  h(
    "svg",
    {
      xmlns: "http://www.w3.org/2000/svg",
      viewBox: "0 0 20 20",
      fill: "currentColor",
    },
    [
      h("path", {
        d: "M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z",
      }),
    ]
  );

export interface AlertProps {
  type?: "success" | "error" | "warning" | "info";
  message: string;
  dismissible?: boolean;
  autoHide?: boolean;
  autoHideDelay?: number;
  modelValue?: boolean;
}

const props = withDefaults(defineProps<AlertProps>(), {
  type: "info",
  dismissible: false,
  autoHide: false,
  autoHideDelay: 3000,
  modelValue: true,
});

const emit = defineEmits<{
  "update:modelValue": [value: boolean];
  dismiss: [];
}>();

const show = ref(props.modelValue);

// Watch for prop changes
watch(
  () => props.modelValue,
  (newValue) => {
    show.value = newValue;
  }
);

// Auto-hide functionality
watch(
  () => show.value,
  (newValue) => {
    if (newValue && props.autoHide) {
      setTimeout(() => {
        dismiss();
      }, props.autoHideDelay);
    }
  }
);

const dismiss = () => {
  show.value = false;
  emit("update:modelValue", false);
  emit("dismiss");
};

const alertClasses = computed(() => {
  const baseClasses = {
    success: "bg-green-50",
    error: "bg-red-50",
    warning: "bg-yellow-50",
    info: "bg-blue-50",
  };
  return baseClasses[props.type];
});

const iconClasses = computed(() => {
  const baseClasses = {
    success: "text-green-400",
    error: "text-red-400",
    warning: "text-yellow-400",
    info: "text-blue-400",
  };
  return baseClasses[props.type];
});

const textClasses = computed(() => {
  const baseClasses = {
    success: "text-green-800",
    error: "text-red-800",
    warning: "text-yellow-800",
    info: "text-blue-800",
  };
  return baseClasses[props.type];
});

const buttonClasses = computed(() => {
  const baseClasses = {
    success:
      "text-green-500 hover:bg-green-100 focus:ring-green-600 focus:ring-offset-green-50",
    error:
      "text-red-500 hover:bg-red-100 focus:ring-red-600 focus:ring-offset-red-50",
    warning:
      "text-yellow-500 hover:bg-yellow-100 focus:ring-yellow-600 focus:ring-offset-yellow-50",
    info: "text-blue-500 hover:bg-blue-100 focus:ring-blue-600 focus:ring-offset-blue-50",
  };
  return baseClasses[props.type];
});

const iconComponent = computed(() => {
  const icons = {
    success: CheckCircleIcon,
    error: XCircleIcon,
    warning: ExclamationCircleIcon,
    info: InformationCircleIcon,
  };
  return icons[props.type];
});
</script>

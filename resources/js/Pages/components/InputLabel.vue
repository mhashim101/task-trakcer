<!-- InputLabel.vue -->
<script setup>
defineProps({
  value: {
    type: String,
  },
  for: {
    type: String,
  },
  required: {
    type: Boolean,
    default: false,
  },
});
</script>

<template>
  <label :for="for" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
    <span>{{ value || $slots.default() }}</span>
    <span v-if="required" class="text-red-500 ml-1">*</span>
  </label>
</template>
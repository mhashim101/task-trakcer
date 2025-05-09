<!-- Checkbox.vue -->
<script setup>
import { computed } from 'vue';

const props = defineProps({
  checked: {
    type: [Array, Boolean],
    default: false,
  },
  value: {
    type: String,
    default: null,
  },
});

const emit = defineEmits(['update:checked']);

const proxyChecked = computed({
  get() {
    return props.checked;
  },
  set(val) {
    emit('update:checked', val);
  },
});
</script>

<template>
  <input
    v-model="proxyChecked"
    type="checkbox"
    :value="value"
    class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:focus:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600"
  />
</template>
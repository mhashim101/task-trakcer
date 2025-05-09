<!-- TextInput.vue -->
<script setup>
import { onMounted, ref } from 'vue';

defineProps({
  modelValue: {
    type: [String, Number],
    required: true,
  },
  type: {
    type: String,
    default: 'text',
  },
  isFocused: {
    type: Boolean,
    default: false,
  },
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
  if (input.value && props.isFocused) {
    input.value.focus();
  }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
  <input
    ref="input"
    :value="modelValue"
    @input="$emit('update:modelValue', $event.target.value)"
    :type="type"
    class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 dark:focus:border-blue-600 focus:ring-blue-500 dark:focus:ring-blue-600 rounded-md shadow-sm w-full px-3 py-2 transition-colors duration-200"
    :class="{ 
      'pr-10': type === 'password' 
    }"
  />
</template>
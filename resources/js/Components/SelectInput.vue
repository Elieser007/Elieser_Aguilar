<template>
  <div class="relative text-gray-500 focus-within:text-purple-600">
    <select ref="input"
      class="rounded block w-full pr-10 mt-1 text-sm text-gray-700 border-gray-300 bg-white focus:border-purple-400 focus:outline-none focus:shadow-outline-purple form-input"
      :required="required" :value="modelValue" @change="$emit('update:modelValue', $event.target.value)">
      <option v-if="text" value="">{{ text }}</option>
      <option v-for="op in options" :key="op.id" :value="op.id">
        {{ op.country }}
      </option>
    </select>
    <div class="absolute inset-y-0 flex items-center ml-3 pointer-events-none">
      <slot></slot>
    </div>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';

defineProps(['modelValue', 'text', 'options', 'required']);
defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
  if (input.value && input.value.hasAttribute('autofocus')) {
    input.value.focus();
  }
});
</script>

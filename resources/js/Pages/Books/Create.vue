<script setup>
import Form from './Form.vue';
const props = defineProps({
    authors:{type:Object}
});
</script>
<template>
    <Form :authors="authors" />
</template>
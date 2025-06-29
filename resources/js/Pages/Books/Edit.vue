<script setup>
import Form from './Form.vue';
const props = defineProps({
    authors:{type:Object},
    book:{type:Object},
    authorsOfBook:{type:Object},
});
</script>
<template>
    <Form :authors="authors" :book="book" :authorsOfBook="authorsOfBook" />
</template>
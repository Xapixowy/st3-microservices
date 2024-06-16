<template>
<ul class="errors-list">
  <li v-for="error in errors" :key="error">{{ error }}</li>
</ul>
</template>

<script setup lang="ts">
import {ref} from "vue";

const props = defineProps<{
  errors: string[]
}>();

</script>

<style scoped>
.errors-list {
  width: 100%;
  list-style-type: none;
  list-style-position: inside;
  margin: 1rem 0;
  padding: 0;
  color: red;
}
</style>
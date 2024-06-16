
<template>
  <div class="form-container">
    <slot></slot>
  </div>
</template>

<script setup lang="ts">

</script>


<style scoped>
.form-container {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  padding-top: 5rem;
  width: 100dvw;
  height: 100dvh;
}
</style>
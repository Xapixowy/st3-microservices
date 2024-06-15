<template>
  <div class="main-layout">
    <navigation-bar></navigation-bar>
    <div class="main-layout__content">
      <div class="main-layout__header">
        <div class="main-layout__header__title">
          <h1 class="main-layout__title">{{ title }}</h1>
          <p class="main-layout__description">{{ description }}</p>
        </div>
        <button v-if="!!createHandler" class="main-layout__button" @click="createHandler">Create</button>
      </div>
      <slot></slot>
    </div>
  </div>
</template>

<script setup lang="ts">
import NavigationBar from "@/shared/NavigationBar.vue";
defineProps<{
  title: string;
  description: string;
  createHandler?: () => void;
}>();
</script>

<style lang="scss" scoped>
.main-layout {
  display: flex;
  flex-direction: column;
  height: 100vh;

  &__content {
    display: flex;
    flex-direction: column;
    margin: 2rem auto;
    padding: 2rem;
    height: 100%;
    width: 100%;
  }

  &__header {
    display: flex;
    justify-content: space-between;
    width: 100%;

    &__title {
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
    }
  }

  &__title {
    font-size: 2rem;
    font-weight: bold;
  }

  &__description {
    font-size: 0.835rem;
    color: gray;
  }

  &__button {
    height: 3rem;
    padding: 0.5rem 1rem;
    background-color: var(--black);
    color: var(--white);
    border-radius: 0.5rem;
  }
}

</style>
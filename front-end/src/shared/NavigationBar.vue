<template>
<div class="navigation-bar">
  <ul class="navigation">
    <li class="navigation-item">
      <router-link to="/restaurants">Restaurants</router-link>
    </li>
    <li class="navigation-item">
      <router-link to="/hotels">Hotels</router-link>
    </li>
    <li class="navigation-item">
      <router-link to="/reservations">Reservations</router-link>
    </li>
  </ul>
  <button class="navigation-button" @click="logoutHandler">Logout</button>
</div>
</template>

<script setup lang="ts">

import {usUserStore} from "@/storage/UserStorage.ts";
import router from "@/router.ts";

const userStore = usUserStore();

const logoutHandler = async () => {
  await userStore.logout();
  await router.push('/login');
}
</script>

<style lang="scss" scoped>
.navigation-bar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  width: 100%;
  height: 3rem;
  background-color: var(--black);
  color: var(--white);
  padding: 0.5rem 1rem;
}
.navigation{
  display: flex;
  list-style: none;
  margin: 0;
  padding: 0;
  gap: 1rem;

  &-item {
    a {
      text-decoration: none;
      color: var(--white);
      &:hover {
        text-decoration: underline;
      }
    }
  }

  &-button {
    border: solid 1px var(--white);
    padding: 0.2rem 0.5rem;
    border-radius: 0.5rem;

    &:hover {
      background-color: var(--white);
      color: var(--black);
    }
  }
}
</style>
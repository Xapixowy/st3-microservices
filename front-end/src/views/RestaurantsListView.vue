
<template>
  <main-layout title="Restaurants" description="List of restaurants" :createHandler="createHandler">
    <v-table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Website</th>
          <th>Description</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="restaurant in restaurants" :key="restaurant.id">
          <td>{{ restaurant.id }}</td>
          <td>{{ restaurant.name }}</td>
          <td>{{ restaurant.website }}</td>
          <td>{{ restaurant.description }}</td>
          <td class="buttons">
            <v-btn @click="editHandler(restaurant)" color="primary">Edit</v-btn>
            <v-btn @click="deleteHandler(restaurant)" color="error">Delete</v-btn>
          </td>
        </tr>
      </tbody>
    </v-table>
  </main-layout>
</template>

<script setup lang="ts">
import MainLayout from "@/shared/MainLayout.vue";

import {userRestaurantStore} from "@/storage/RestaurantStorage.ts";
import router from "@/router.ts";
import {onMounted, ref} from "vue";
import {Restaurant} from "@/types/Restaurant.ts";

const restaurantStore = userRestaurantStore();

const restaurants = ref<Restaurant[]>([]);

const createHandler = () => {
  router.push('/restaurants/create');
}

const editHandler = (restaurant: Restaurant) => {
  router.push(`/restaurants/${restaurant.id}/edit`);
}

const deleteHandler = (restaurant: Restaurant) => {
  // restaurantStore.delete(restaurant.id);
}

onMounted(async () => {
  restaurants.value = await restaurantStore.getAll();
})
</script>


<style scoped>
.buttons {
  display: flex;
  gap: 1rem;
}
</style>
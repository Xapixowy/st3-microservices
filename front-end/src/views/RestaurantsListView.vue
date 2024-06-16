
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
            <div class="buttons_container">
              <v-btn @click="showRestaurantHandler(restaurant)" >
                Show
              </v-btn>
              <v-btn @click="editHandler(restaurant)" color="primary">Edit</v-btn>
              <v-dialog max-width="500px">
                <template v-slot:activator="{ props: activatorProps }">
                  <v-btn v-bind="activatorProps" color="error">Delete</v-btn>
                </template>
                <template v-slot:default="{ isActive }">
                  <div class="delete-dialog">
                    <h1 class="delete-dialog__title">Delete Restaurant</h1>
                    <p class="delete-dialog__description">Do you want to delete this restaurant?</p>
                    <div class="delete-dialog__actions">
                      <v-btn @click="deleteHandler(restaurant)" color="error">Delete</v-btn>
                      <v-btn @click="isActive.value = false" color="primary">Cancel</v-btn>
                    </div>
                  </div>
                </template>
              </v-dialog>
            </div>
          </td>
        </tr>
      </tbody>
    </v-table>
  </main-layout>
</template>

<script setup lang="ts">
import MainLayout from "@/shared/MainLayout.vue";

import {useRestaurantStore} from "@/storage/RestaurantStorage.ts";
import { IconEdit } from '@tabler/icons-vue';
import router from "@/router.ts";
import {onMounted, ref} from "vue";
import {Restaurant} from "@/types/Restaurant.ts";
import {Hotel} from "@/types/Hotel.ts";
import ToastFactory from "@/services/ToastService.ts";

const restaurantStore = useRestaurantStore();

const restaurants = ref<Restaurant[]>([]);

const createHandler = () => {
  router.push('/restaurants/create');
}

const showRestaurantHandler = (restaurant: Restaurant) => {
  router.push(`/restaurants/${restaurant.id}/tables`);
}

const editHandler = (restaurant: Restaurant) => {
  router.push(`/restaurants/${restaurant.id}/edit`);
}

const deleteHandler = async (restaurant: Restaurant) => {
  if (restaurant.id != null) {
    await restaurantStore.deleteRestaurant(restaurant.id);
  }else {
    ToastFactory.danger("Hotel deletion failed!");
  }
}

onMounted(async () => {
  restaurants.value = await restaurantStore.getAll();
})
</script>


<style scoped>

</style>
<template>
  <main-layout title="Hotels" description="List of hotels" :createHandler="createHandler">
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
      <tr v-for="hotel in hotels" :key="hotel.id">
        <td>{{ hotel.id }}</td>
        <td>{{ hotel.name }}</td>
        <td>{{ hotel.website }}</td>
        <td>{{ hotel.description }}</td>
        <td class="buttons">
          <v-btn @click="editHandler(hotel)" color="primary">Edit</v-btn>
          <v-btn @click="deleteHandler(hotel)" color="error">Delete</v-btn>
        </td>
      </tr>
      </tbody>
    </v-table>
  </main-layout>
</template>

<script setup lang="ts">

import MainLayout from "@/shared/MainLayout.vue";

import router from "@/router.ts";
import {onMounted, ref} from "vue";
import {Hotel} from "@/types/Hotel.ts";
import {userHotelStore} from "@/storage/HotelStorage.ts";

const hotelStore = userHotelStore();

const hotels = ref<Hotel[]>([]);

const createHandler = () => {
  router.push('/hotels/create');
}
const editHandler = (hotel: Hotel) => {
  router.push(`/hotels/${hotel.id}/edit`);
}

const deleteHandler = (restaurant: Hotel) => {
  // restaurantStore.delete(restaurant.id);
}

onMounted(async () => {
  hotels.value = await hotelStore.getAll();
  console.log(hotels.value);
})
</script>


<style scoped>
.buttons {
  display: flex;
  gap: 1rem;
}

</style>
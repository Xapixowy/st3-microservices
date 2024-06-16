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
          <div class="buttons_container">
            <v-btn @click="showHotelHandler(hotel)" >
              Show
            </v-btn>
            <v-btn @click="editHandler(hotel)" color="primary">Edit</v-btn>
            <v-dialog max-width="500px">
              <template v-slot:activator="{ props: activatorProps }">
                <v-btn v-bind="activatorProps" color="error">Delete</v-btn>
              </template>
              <template v-slot:default="{ isActive }">
                <div class="delete-dialog">
                  <h1 class="delete-dialog__title">Delete Hotel</h1>
                  <p class="delete-dialog__description">Do you want to delete this hotel?</p>
                  <div class="delete-dialog__actions">
                    <v-btn @click="deleteHandler(hotel)" color="error">Delete</v-btn>
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

import router from "@/router.ts";
import {onMounted, ref} from "vue";
import {Hotel} from "@/types/Hotel.ts";
import {userHotelStore} from "@/storage/HotelStorage.ts";
import ToastFactory from "@/services/ToastService.ts";

const hotelStore = userHotelStore();

const hotels = ref<Hotel[]>([]);

const createHandler = () => {
  router.push('/hotels/create');
}

const showHotelHandler = (hotel: Hotel) => {
  router.push(`/hotels/${hotel.id}/rooms`);
}

const editHandler = (hotel: Hotel) => {
  router.push(`/hotels/${hotel.id}/edit`);
}

const deleteHandler = async (hotel: Hotel) => {
  if (hotel.id != null) {
    await hotelStore.deleteHotel(hotel.id);
  }else {
    ToastFactory.danger("Hotel deletion failed!");
  }
}

onMounted(async () => {
  hotels.value = await hotelStore.getAll();
})
</script>


<style scoped>
.buttons {
  display: flex;
  gap: 1rem;
}

</style>
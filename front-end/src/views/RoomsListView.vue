
<template>
  <main-layout title="Rooms" description="List of Rooms" :createHandler="createHandler">
    <v-table>
      <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Description</th>
        <th>Capacity</th>
        <th>Price</th>
        <th>Actions</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="room in rooms" :key="room.id">
        <td>{{room.id}}</td>
        <td>{{room.name}}</td>
        <td>{{room.description}}</td>
        <td>{{room.capacity}}</td>
        <td>{{room.price}}</td>
        <td class="buttons">
          <div class="buttons_container">
            <v-btn @click="editHandler(room)" color="primary">Edit</v-btn>
            <v-dialog max-width="500px">
              <template v-slot:activator="{ props: activatorProps }">
                <v-btn v-bind="activatorProps" color="error">Delete</v-btn>
              </template>
              <template v-slot:default="{ isActive }">
                <div class="delete-dialog">
                  <h1 class="delete-dialog__title">Delete Restaurant</h1>
                  <p class="delete-dialog__description">Do you want to delete this restaurant?</p>
                  <div class="delete-dialog__actions">
                    <v-btn @click="deleteHandler(room)" color="error">Delete</v-btn>
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
import ToastFactory from "@/services/ToastService.ts";
import {Hotel} from "@/types/Hotel.ts";
import {useRoomStore} from "@/storage/RoomStorage.ts";
import {userHotelStore} from "@/storage/HotelStorage.ts";
import {Room} from "@/types/Room.ts";

const props = defineProps<{hotelId: string}>();

const roomStore = useRoomStore();
const hotelStore = userHotelStore();

const rooms = ref<Room[]>([]);
const hotels = ref<Hotel[]>([]);

const createHandler = () => {
  router.push(`/hotels/${props.hotelId}/rooms/create`);
}

const editHandler = (room: Room) => {
  router.push(`/hotels/${props.hotelId}/rooms/${room.id}/edit`);
}

const deleteHandler = async (room: Room) => {
  if (room.id != null) {
    await roomStore.deleteRoom(props.hotelId, room.id);
    await window.location.reload();
  }else {
      ToastFactory.danger("Room deletion failed!");
  }
}

onMounted(async () => {
  rooms.value = await roomStore.getAll(props.hotelId);
})
</script>


<style scoped>

</style>
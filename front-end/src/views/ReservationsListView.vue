
<template>
  <main-layout title="Reservations" description="List of reservations" :createHandler="createHandler">
    <v-table>
      <thead>
      <tr>
        <th>Client</th>
        <th>Restaurant</th>
        <th>Table</th>
        <th>Hotel</th>
        <th>Room</th>
        <th>Occupancy</th>
        <th>Actions</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="reservation in reservations" :key="reservation.id">
        <td>{{reservation.client.first_name}}</td>
        <td>{{reservation.restaurant_id ? getRestaurant(reservation.restaurant_id) : ""}}</td>
        <td>{{reservation.table ? reservation.table.name : ""}}</td>
        <td>{{reservation.hotel_id ? getHotel(reservation.hotel_id) : ""}}</td>
        <td>{{reservation.room ? reservation.room.name : ""}}</td>
        <td>{{formatDates(reservation.check_in_date, reservation.check_out_date)}}</td>
        <td class="buttons">
          <div class="buttons_container">
            <v-btn @click="editHandler(reservation)" color="primary">Edit</v-btn>
            <v-dialog max-width="500px">
              <template v-slot:activator="{ props: activatorProps }">
                <v-btn v-bind="activatorProps" color="error">Delete</v-btn>
              </template>
              <template v-slot:default="{ isActive }">
                <div class="delete-dialog">
                  <h1 class="delete-dialog__title">Delete Restaurant</h1>
                  <p class="delete-dialog__description">Do you want to delete this restaurant?</p>
                  <div class="delete-dialog__actions">
                    <v-btn @click="deleteHandler(reservation)" color="error">Delete</v-btn>
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
import {Reservation} from "@/types/Reservation.ts";
import {useReservationStore} from "@/storage/ReservationStorage.ts";
import {userHotelStore} from "@/storage/HotelStorage.ts";
import {Hotel} from "@/types/Hotel.ts";
import {Restaurant} from "@/types/Restaurant.ts";
import {useRestaurantStore} from "@/storage/RestaurantStorage.ts";

const reservationStore = useReservationStore();
const hotelStore = userHotelStore();
const restaurantStore = useRestaurantStore();

const reservations = ref<Reservation[]>([]);
const hotels = ref<Hotel[]>([]);
const restaurants = ref<Restaurant[]>([]);

const createHandler = () => {
  router.push('/reservations/create');
}

const editHandler = (reservation: Reservation) => {
  router.push(`/reservations/${reservation.id}/edit`);
}

const deleteHandler = async (reservation: Reservation) => {
  if (reservation.id != null) {
    await reservationStore.deleteReservation(reservation.id);
  }else {
    ToastFactory.danger("Hotel deletion failed!");
  }
}

const getHotel = (id: string) => {
  const hotel: Hotel = hotels.value.find((hotel: Hotel) => {
    return hotel.id == id;
  });
  if (hotel.name != null) {
    return hotel.name;
  }
}

const getRestaurant = (id: string) => {
  const restaurant: Restaurant = restaurants.value.find((restaurant: Restaurant) => {
    return restaurant.id == id;
  });
  if (restaurant.name != null) {
    return restaurant.name;
  }
}

const formatDates = (checkInDate: string, checkOutDate: string) => {
  const checkInDateObj = new Date(checkInDate);
  const checkOutDateObj = new Date(checkOutDate);
  return `${checkInDateObj.toLocaleDateString()} ${checkInDateObj.toLocaleTimeString()} - ${checkOutDateObj.toLocaleDateString()} ${checkOutDateObj.toLocaleTimeString()}`;
}

onMounted(async () => {
  hotels.value = await hotelStore.getAll();
  restaurants.value = await restaurantStore.getAll();
  reservations.value = await reservationStore.getAll();
})
</script>


<style scoped>

</style>
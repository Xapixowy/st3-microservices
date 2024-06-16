<template>
  <main-layout title="Reservation" description="Create a new reservation">
    <v-tabs
        v-model="tab"
        background-color="transparent"
        color="black"
        class="tabs"
        align-tabs="center"
        slider-color="black"
        show-arrows
    >
      <v-tab value="hotel">Hotel</v-tab>
      <v-tab value="restaurant">Restaurant</v-tab>
    </v-tabs>
    <v-tabs-window v-model="tab">

      <v-tabs-window-item value="hotel">
        <div class="form-container">
          <hotel-reservation-form :reservation="hotelReservation" />
        </div>
      </v-tabs-window-item>

      <v-tabs-window-item value="restaurant">
        <div class="form-container">
          <restaurant-reservation-from :reservation="restaurantReservation" />
        </div>
      </v-tabs-window-item>
    </v-tabs-window>

  </main-layout>
</template>

<script setup lang="ts">
import MainLayout from "@/shared/MainLayout.vue";
import {onMounted, ref, watch} from "vue";
import HotelReservationForm from "@components/HotelReservationForm.vue";
import RestaurantReservationFrom from "@components/RestaurantReservationFrom.vue";
import {useReservationStore} from "@/storage/ReservationStorage.ts";
import {Reservation} from "@/types/Reservation.ts";

const props = defineProps<{
  id: string
}>();


const reservationStore = useReservationStore();

const tab = ref<string[]>([]);
const reservation = ref<Reservation>();
const restaurantReservation = ref<Reservation>();
const hotelReservation = ref<Reservation>();


const checkReservationType = (reservation: Reservation) => {
  if (reservation.hotel_id != null) {
    tab.value = ['hotel'];
    hotelReservation.value = reservation;
  } else if (reservation.restaurant_id != null) {
    tab.value = ['restaurant'];
    restaurantReservation.value = reservation;
  }
}



onMounted(async () => {
  reservation.value = await reservationStore.find(props.id);
  checkReservationType(reservation.value);
})
</script>


<style scoped>

</style>
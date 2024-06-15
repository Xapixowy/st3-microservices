<template>
<v-form>
  <v-select v-model="hotelId" :items="hotels" item-value="id" item-title="name" label="Hotel" :rules="[v => !!v || 'Hotel is required']" />
  <v-select v-if="!!hotelId" v-model="roomId" :items="rooms" item-value="id" item-title="name" label="Room" :rules="[v => !!v || 'Room is required']" />
  <v-date-input
      v-if="!!roomId"
      v-model="dateRange"
      label="Select range"
      multiple="range"
      prepend-icon=""
  ></v-date-input>
<div>
  {{ errors}}
</div>
  <div class="form__actions">
    <v-btn @click="cancel">Cancel</v-btn>
    <v-btn @click="createHotelReservation">Create</v-btn>
  </div>
</v-form>
</template>

<script setup lang="ts">
import { VDateInput } from 'vuetify/labs/VDateInput'

import {computed, onMounted, ref, watch} from "vue";
import {Room} from "@/types/Room.ts";
import {Hotel} from "@/types/Hotel.ts";
import {userHotelStore} from "@/storage/HotelStorage.ts";
import {useReservationStore} from "@/storage/ReservationStorage.ts";
import router from "@/router.ts";

const hotelStore = userHotelStore();
const reservationStore = useReservationStore();

const dateRange = ref<string[]>([]);
const rooms = ref<Room[]>([]);
const hotels = ref<Hotel[]>([]);
const errors = ref<string[]>([]);

const hotelId = ref<string>('');
const roomId = ref<string>('');
const checkInDate = ref<string>('');
const checkOutDate = ref<string>('');

const formData = computed(() => ({
  client_id: 1,
  hotel_id: hotelId.value,
  room_id: roomId.value,
  check_in_date: checkInDate.value,
  check_out_date: checkOutDate.value,
  is_paid: true
}));

watch(hotelId, async () => {
  rooms.value = await hotelStore.getRooms(hotelId.value);
});

watch(dateRange,  () => {
  checkInDate.value = formatDate(dateRange.value[0]);
  checkOutDate.value = formatDate(dateRange.value[dateRange.value.length - 1]);
});

const createHotelReservation = async () => {
  try {
    await reservationStore.store(formData.value);
    await router.push('/reservations');
  } catch (error) {
    errors.value = error.errorObject;
  }
}

const cancel = () => {
  router.push('/restaurants');
}

const formatDate = (date: string) => {
  const dateObj = new Date(date);
  const formattedDateObj = dateObj.toLocaleDateString('en-GB', {
    year: 'numeric',
    month: 'numeric',
    day: 'numeric',
  });

  return `${formattedDateObj.replace(/\//g, '-')} 12:00`;
}


onMounted(async () => {
  hotels.value = await hotelStore.getAll();
})
</script>



<style scoped>

</style>
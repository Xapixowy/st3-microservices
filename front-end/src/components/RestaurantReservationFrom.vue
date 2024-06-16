<template>
  <v-form>
    <form-errors :errors="errors" />
    <v-select v-model="restaurantId" :items="restaurants" item-value="id" item-title="name" label="Restaurant" :rules="[v => !!v || 'Hotel is required']" />
    <v-select v-if="!!restaurantId" v-model="tableId" :items="tables" item-value="id" item-title="name" label="Table" :rules="[v => !!v || 'Room is required']" />
    <v-date-input
        v-if="!!tableId"
        v-model="dateRange"
        label="Select range"
        multiple="range"
        prepend-icon=""
    ></v-date-input>
    <div class="form__actions">
      <v-btn @click="cancel">Cancel</v-btn>
      <v-btn @click="createHotelReservation">Create</v-btn>
    </div>
  </v-form>
</template>

<script setup lang="ts">
import { VDateInput } from 'vuetify/labs/VDateInput'

import {computed, onMounted, ref, watch} from "vue";
import {Hotel} from "@/types/Hotel.ts";
import {useReservationStore} from "@/storage/ReservationStorage.ts";
import router from "@/router.ts";
import FormErrors from "@components/FormErrors.vue";
import {Table} from "@/types/Table.ts";
import {useRestaurantStore} from "@/storage/RestaurantStorage.ts";
import {Reservation} from "@/types/Reservation.ts";

const props = defineProps<{
  reservation?: Reservation
}>();

const restaurantStore = useRestaurantStore();
const reservationStore = useReservationStore();

const dateRange = ref<string[]>([]);
const tables = ref<Table[]>([]);
const restaurants = ref<Hotel[]>([]);
const errors = ref<string[]>([]);

const restaurantId = ref<string>('');
const tableId = ref<string>('');
const checkInDate = ref<string>('');
const checkOutDate = ref<string>('');

const formData = computed(() => ({
  client_id: 1,
  restaurant_id: restaurantId.value,
  table_id: tableId.value,
  check_in_date: checkInDate.value,
  check_out_date: checkOutDate.value,
  is_paid: true
}));

watch(restaurantId, async () => {
  tables.value = await restaurantStore.getTables(restaurantId.value);
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
  router.push('/reservations');
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

const generateRangeArray = (startDate: string, endDate: string) => {
  const startDateObj = new Date(startDate);
  const endDateObj = new Date(endDate);
  const dateRange = [];
  while (startDateObj <= endDateObj) {
    dateRange.push(new Date(startDateObj));
    startDateObj.setDate(startDateObj.getDate() + 1);

  }
  return dateRange;
}


onMounted(async () => {
  restaurants.value = await restaurantStore.getAll();
  if (props.reservation) {
    restaurantId.value = props.reservation.restaurant_id;
    tableId.value = props.reservation.table_id;
    checkInDate.value = props.reservation.check_in_date;
    checkOutDate.value = props.reservation.check_out_date;
    dateRange.value = generateRangeArray(checkInDate.value, checkOutDate.value);
  }
})
</script>



<style scoped>

</style>
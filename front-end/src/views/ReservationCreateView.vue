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
            <hotel-reservation-form />
         </div>
       </v-tabs-window-item>

     <v-tabs-window-item value="restaurant">
       <div class="form-container">
          <restaurant-reservation-from />
       </div>
     </v-tabs-window-item>
   </v-tabs-window>

 </main-layout>
</template>

<script setup lang="ts">
import MainLayout from "@/shared/MainLayout.vue";
import {ref, watch} from "vue";
import HotelReservationForm from "@components/HotelReservationForm.vue";
import RestaurantReservationFrom from "@components/RestaurantReservationFrom.vue";
const tab = ref<string[]>([]);

watch(tab, () => {
  console.log(tab.value);
});
</script>


<style scoped>

</style>
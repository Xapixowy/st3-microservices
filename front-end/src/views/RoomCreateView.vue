<template>
  <main-layout title="Room" description="Create a new room">
    <div class="form-container">
      <v-form>
        <v-text-field v-model="roomName" label="Name" :rules="[v => !!v || 'Name is required']" />
        <p v-if="roomNameError" class="error">{{ roomNameError }}</p>
        <v-text-field v-model="roomDescription" label="Description" :rules="[v => !!v || 'Description is required']" />
        <p v-if="roomDescriptionError" class="error">{{ roomDescriptionError }}</p>
        <v-text-field v-model="roomCapacity" label="Capacity" :rules="[v => !!v || 'Capacity is required']" />
        <p v-if="roomCapacityError" class="error">{{ roomCapacityError }}</p>
        <v-text-field v-model="roomPrice" label="Price" :rules="[v => !!v || 'Price is required']" />
        <p v-if="roomPriceError" class="error">{{ roomPriceError }}</p>
        <div class="form__actions">
          <v-btn @click="cancel">Cancel</v-btn>
          <v-btn @click="createRoom">Create</v-btn>
        </div>
      </v-form>
    </div>
  </main-layout>
</template>

<script setup lang="ts">
import MainLayout from "@/shared/MainLayout.vue";

import {useRoomStore} from "@/storage/RoomStorage.ts";
import {ref, onMounted, computed} from "vue";
import {Room} from "@/types/Room.ts";
import router from "@/router.ts";

const props = defineProps<{hotelId: string}>();

const roomStore = useRoomStore();
const errors = ref<string[]>([]);

const roomName = ref('');
const roomDescription = ref('');
const roomCapacity = ref('');
const roomPrice = ref('');

const formData = computed<Room>(() => {
 return {
   name: roomName.value,
   description: roomDescription.value,
   capacity: roomCapacity.value,
   price: roomPrice.value
 }
});

const roomNameError = computed(() => {
  return !!errors.value.name ? errors.value.name[0] : '';
});
const roomDescriptionError = computed(() => {
  return !!errors.value.description ? errors.value.description[0] : '';
});
const roomCapacityError = computed(() => {
  return !!errors.value.capacity ? errors.value.capacity[0] : '';
});
const roomPriceError = computed(() => {
  return !!errors.value.price ? errors.value.price[0] : '';
});

const createRoom = async () => {
  try {
    await roomStore.store(props.hotelId, formData.value);
    await router.back();
  } catch (error) {
    errors.value = error.errorObject;
  }
}

const cancel = () => {
  router.back();
}

onMounted(async () => {
  room.value = await roomStore.find(props.hotelId, props.roomId);
})
</script>


<style scoped>

</style>
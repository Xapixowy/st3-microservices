<template>
  <main-layout title="Room" description="Edit a room">
    <div class="form-container">
      <v-form>
        <v-text-field v-model="roomName" label="Name" :rules="[v => !!v || 'Name is required']" />
        <p v-if="roomNameError" class="error">{{ roomNameError }}</p>
        <v-text-field v-model="roomDescription" label="Description" :rules="[v => !!v || 'Description is required']" />
        <p v-if="roomDescriptionError" class="error">{{ roomDescriptionError }}</p>
        <v-text-field type="number" v-model="roomCapacity" label="Capacity" :rules="[v => !!v || 'Capacity is required']" />
        <p v-if="roomCapacityError" class="error">{{ roomCapacityError }}</p>
        <v-text-field v-model="roomPrice" label="Price" :rules="[v => !!v || 'Price is required']" />
        <p v-if="roomPriceError" class="error">{{ roomPriceError }}</p>
        <div class="form__actions">
          <v-btn @click="cancel">Cancel</v-btn>
          <v-btn @click="editRoomHandler">Edit</v-btn>
        </div>
      </v-form>
    </div>
  </main-layout>
</template>

<script setup lang="ts">
import MainLayout from "@/shared/MainLayout.vue";

import {useRoomStore} from "@/storage/RoomStorage.ts";
import {ref, onMounted, computed, watch} from "vue";
import {Room} from "@/types/Room.ts";
import router from "@/router.ts";

const props = defineProps<{hotelId: string, roomId: string}>();

const roomStore = useRoomStore();
const errors = ref<string[]>([]);
const room = ref<Room>();

const roomName = ref('');
const roomDescription = ref('');
const roomCapacity = ref('');
const roomPrice = ref('');

const formData = computed<Room>(() => {
  return {
    id: props.roomId,
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
  return !!errors.value.capacity ? errors.value.capacity[0] : '';
});

watch(room, () => {
  roomName.value = room.value.name;
  roomDescription.value = room.value.description;
  roomCapacity.value = room.value.capacity;
})

const editRoomHandler = async () => {
  try {
    await roomStore.update(props.hotelId, formData.value);
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
  console.log(room.value);
})
</script>

<style scoped>

</style>

<template>
  <main-layout title="Table" description="'Edit a table'">
    <div class="form-container">
      <v-form>
        <v-text-field v-model="tableName" label="Name" :rules="[v => !!v || 'Name is required']" />
        <p v-if="tableNameError" class="error">{{ tableNameError }}</p>
        <v-text-field v-model="tableDescription" label="Description" :rules="[v => !!v || 'Description is required']" />
        <p v-if="tableDescriptionError" class="error">{{ tableDescriptionError }}</p>
        <v-text-field type="number" v-model="tableCapacity" label="Capacity" :rules="[v => !!v || 'Capacity is required']" />
        <p v-if="tableCapacityError" class="error">{{ tableCapacityError }}</p>
        <v-text-field v-model="tablePrice" label="Price" :rules="[v => !!v || 'Price is required']" />
        <p v-if="tablePriceError" class="error">{{ tablePriceError }}</p>
        <div class="form__actions">
          <v-btn @click="cancel">Cancel</v-btn>
          <v-btn @click="editTableHandler">Edit</v-btn>
        </div>
      </v-form>
    </div>
  </main-layout>
</template>

<script setup lang="ts">
import MainLayout from "@/shared/MainLayout.vue";

import {useTableStore} from "@/storage/TableStorage.ts";
import {ref, onMounted, computed, watch} from "vue";
import {Table} from "@/types/Table.ts";
import router from "@/router.ts";

const props = defineProps<{restaurantId: string, tableId: string}>();

const tableStore = useTableStore();
const errors = ref<string[]>([]);
const table = ref<Table>();

const tableName = ref('');
const tableDescription = ref('');
const tableCapacity = ref('');
const tablePrice = ref('');

const formData = computed<Table>(() => {
  return {
    id: props.tableId,
    name: tableName.value,
    description: tableDescription.value,
    capacity: tableCapacity.value,
    price: tablePrice.value
  }
});

const tableNameError = computed(() => {
  return !!errors.value.name ? errors.value.name[0] : '';
});
const tableDescriptionError = computed(() => {
  return !!errors.value.description ? errors.value.description[0] : '';
});
const tableCapacityError = computed(() => {
  return !!errors.value.capacity ? errors.value.capacity[0] : '';
});

watch(table, () => {
  tableName.value = table.value.name;
  tableDescription.value = table.value.description;
  tableCapacity.value = table.value.capacity;
})

const editTableHandler = async () => {
  try {
    await tableStore.update(props.restaurantId, formData.value);
    await router.back();
  } catch (error) {
    errors.value = error.errorObject;
  }
}

const cancel = () => {
  router.back();
}

onMounted(async () => {
  table.value = await tableStore.find(props.restaurantId, props.tableId);
})

</script>

<style scoped>

</style>
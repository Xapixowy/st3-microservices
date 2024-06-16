
<template>
  <main-layout title="Tables" description="List of Tables" :createHandler="createHandler">
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
      <tr v-for="table in tables" :key="table.id">
        <td>{{table.id}}</td>
        <td>{{table.name}}</td>
        <td>{{table.description}}</td>
        <td>{{table.capacity}}</td>
        <td>{{table.price}}</td>
        <td class="buttons">
          <div class="buttons_container">
            <v-btn @click="editHandler(table)" color="primary">Edit</v-btn>
            <v-dialog max-width="500px">
              <template v-slot:activator="{ props: activatorProps }">
                <v-btn v-bind="activatorProps" color="error">Delete</v-btn>
              </template>
              <template v-slot:default="{ isActive }">
                <div class="delete-dialog">
                  <h1 class="delete-dialog__title">Delete Restaurant</h1>
                  <p class="delete-dialog__description">Do you want to delete this restaurant?</p>
                  <div class="delete-dialog__actions">
                    <v-btn @click="deleteHandler(table)" color="error">Delete</v-btn>
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
import {Restaurant} from "@/types/Restaurant.ts";
import {useTableStore} from "@/storage/TableStorage.ts";
import {Table} from "@/types/Table.ts";

const props = defineProps<{restaurantId: string}>();

const tableStore = useTableStore();

const tables = ref<Table[]>([]);
const restaurants = ref<Restaurant[]>([]);

const createHandler = () => {
  router.push(`/restaurants/${props.restaurantId}/tables/create`);
}

const editHandler = (table: Table) => {
  router.push(`/restaurants/${props.restaurantId}/tables/${table.id}/edit`);
}

const deleteHandler = async (table: Table) => {
  console.log(table);
  if (table.id != null) {
    await tableStore.deleteTable(props.restaurantId, table.id);
  }else {
    ToastFactory.danger("Hotel deletion failed!");
  }
}


onMounted(async () => {
  tables.value = await tableStore.getAll(props.restaurantId);
})
</script>


<style scoped>

</style>
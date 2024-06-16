import {defineStore} from "pinia";
import RestaurantService from "@/services/RestaurantService.ts";
import {Table} from "@/types/Table.ts";
import ToastFactory from "@/services/ToastService.ts";
import ValidationError from "@/services/ValidationError.ts";


export const useTableStore = defineStore('table', () => {
    const getAll = async (restaurantId: string) => {
        return await RestaurantService.getRestaurantTables(restaurantId);
    }

    const store = async (restaurantId: string ,table: Table) => {
        try {
            await RestaurantService.storeRestaurantTable(restaurantId, table);
            ToastFactory.success("Table created!");
        } catch (error) {
            ToastFactory.danger("Table creation failed!");
            if (error instanceof ValidationError) {
                throw new ValidationError("" ,error.errorObject);
            }
        }   
    }

    const find = async ( restaurantId: string, id: string) => {
        try {
            return await RestaurantService.getRestaurantTable(restaurantId, id);
        } catch (error) {
            ToastFactory.danger("Table retrieval failed!");
        }
    }

    const update = async (restaurantId: string, table: Table) => {
        try {
            await RestaurantService.updateRestaurantTable(restaurantId, table.id, table);
            ToastFactory.success("Table updated!");
        } catch (error) {
            ToastFactory.danger("Table update failed!");
            if (error instanceof ValidationError) {
                throw new ValidationError("", error.errorObject);
            }
        }
    
    }

    const deleteTable = async (restaurantId:string, id: string) => {
        try {
            await RestaurantService.deleteRestaurantTable(restaurantId, id);
            await window.location.reload();
            ToastFactory.success("Table deleted!");
        } catch (error) {
            ToastFactory.danger("Table deletion failed!");
        }
    }

    return {
        getAll,
        store,
        find,
        update,
        deleteTable
    }
});
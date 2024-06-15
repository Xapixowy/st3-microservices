import {defineStore} from "pinia";
import RestaurantService from "@/services/RestaurantService.ts";
import {Restaurant} from "@/types/Restaurant.ts";
import ToastFactory from "@/services/ToastService.ts";
import ValidationError from "@/services/ValidationError.ts";

export const useRestaurantStore = defineStore('restaurant', () => {
    const getAll = async () => {
        return await RestaurantService.getAll();
    }

    const store = async (restaurant: Restaurant) => {
        try {
            await RestaurantService.store(restaurant);
            ToastFactory.success("Restaurant created!");
        } catch (error) {
            ToastFactory.danger("Restaurant creation failed!");
            if (error instanceof ValidationError) {
                throw new ValidationError("" ,error.errorObject);
            }
        }
    }

    const find = async (id: string) => {
        try {
            return await RestaurantService.getById(id);
        } catch (error) {
            ToastFactory.danger("Restaurant retrieval failed!");
        }
    }

    const update = async (restaurant: Restaurant) => {
        try {
            await RestaurantService.update(restaurant);
            ToastFactory.success("Restaurant updated!");
        } catch (error) {
            ToastFactory.danger("Restaurant update failed!");
            if (error instanceof ValidationError) {
                throw new ValidationError("", error.errorObject);
            }
        }

    }

    const deleteRestaurant = async (id: string) => {
        try {
            await RestaurantService.delete(id);
            await window.location.reload();
            ToastFactory.success("Restaurant deleted!");
        } catch (error) {
            ToastFactory.danger("Restaurant deletion failed!");
        }
    }

    return {
        getAll,
        store,
        find,
        update,
        deleteRestaurant
    }
});
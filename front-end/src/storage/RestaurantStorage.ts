import {defineStore} from "pinia";
import RestaurantService from "@/services/RestaurantService.ts";
import {Restaurant} from "@/types/Restaurant.ts";
import ToastFactory from "@/services/ToastService.ts";
import ValidationError from "@/services/ValidationError.ts";

export const userRestaurantStore = defineStore('restaurant', () => {
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

    return {
        getAll,
        store
    }
});
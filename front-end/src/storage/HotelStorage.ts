import {defineStore} from "pinia";
import ValidationError from "@/services/ValidationError.ts";
import HotelService from "@/services/HotelService.ts";
import {Hotel} from "@/types/Hotel.ts";
import ToastFactory from "@/services/ToastService.ts";

export const userHotelStore = defineStore('hotel', () => {
    const getAll = async () => {
        return await HotelService.getAll();
    }

    const store = async (hotel: Hotel) => {
        try {
            await HotelService.store(hotel);
            ToastFactory.success("Hotel created!");
        } catch (error) {
            ToastFactory.danger("Hotel creation failed!");
            if (error instanceof ValidationError) {
                throw new ValidationError("", error.errorObject);
            }
        }
    }

    const find = async (id: string) => {
        return await HotelService.getById(id);
    }

    const update = async (hotel: Hotel) => {
        try {
            console.log(hotel, "HOTEL STORAGE");
            await HotelService.update(hotel);
            ToastFactory.success("Hotel updated!");
        } catch (error) {
            ToastFactory.danger("Hotel update failed!");
            if (error instanceof ValidationError) {
                throw new ValidationError("", error.errorObject);
            }
        }
    }

    const deleteHotel = async (id: string) => {
        try {
            await HotelService.delete(id);
            await window.location.reload();
            await ToastFactory.success("Hotel deleted!");
        } catch (error) {
            ToastFactory.danger("Hotel deletion failed!");
        }
    }

    const getRooms = async (id: string) => {
        return await HotelService.getHotelRooms(id);
    }


    return {
        getAll,
        store,
        find,
        update,
        deleteHotel,
        getRooms
    }
});
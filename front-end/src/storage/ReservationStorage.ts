import {defineStore} from "pinia";
import ReservationService from "@/services/ReservationService.ts";
import {Reservation} from "@/types/Reservation.ts";
import ToastFactory from "@/services/ToastService.ts";
import ValidationError from "@/services/ValidationError.ts";


export const useReservationStore = defineStore('reservation', () => {
    const getAll = async () => {
        return await ReservationService.getAll();
    }

    const store = async (reservation: Reservation) => {
        try {
            await ReservationService.store(reservation);
            ToastFactory.success("Reservation created!");
        } catch (error) {
            ToastFactory.danger("Reservation creation failed!");
            if (error instanceof ValidationError) {
                throw new ValidationError("" ,error.errorObject);
            }
        }
    }

    const find = async (id: string) => {
        try {
            return await ReservationService.getById(id);
        } catch (error) {
            ToastFactory.danger("Reservation retrieval failed!");
        }
    }

    const update = async (reservation: Reservation) => {
        try {
            await ReservationService.update(reservation);
            ToastFactory.success("Reservation updated!");
        } catch (error) {
            ToastFactory.danger("Reservation update failed!");
            if (error instanceof ValidationError) {
                throw new ValidationError("", error.errorObject);
            }
        }

    }

    const deleteReservation = async (id: string) => {
        try {
            await ReservationService.delete(id);
            await window.location.reload();
            ToastFactory.success("Reservation deleted!");
        } catch (error) {
            ToastFactory.danger("Reservation deletion failed!");
        }
    }

    return {
        getAll,
        store,
        find,
        update,
        deleteReservation
    }
});
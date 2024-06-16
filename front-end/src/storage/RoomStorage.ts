import {defineStore} from "pinia";
import HotelService from "@/services/HotelService.ts";
import ToastFactory from "@/services/ToastService.ts";
import {Room} from "@/types/Room.ts";

export const useRoomStore = defineStore('room', () => {
    const getAll = async (hotelId: string) => {
        return await HotelService.getHotelRooms(hotelId);
    }

    const store = async (hotelId: string, room: any) => {
        try {
            await HotelService.storeHotelRoom(hotelId, room);
            ToastFactory.success("Room created!");
        } catch (error) {
            ToastFactory.danger("Room creation failed!");
            if (error instanceof Error) {
                throw new Error("Room creation failed!");
            }
            throw new Error("Room creation failed!");
        }
    }

    const find = async (hotelId: string, roomId: string) => {
        try {
           return await HotelService.getHotelRoom(hotelId, roomId);
        } catch (error) {
            ToastFactory.danger("Room retrieval failed!");
        }
    }

   const update = async (hotelId: string, room: Room) => {
       try {
           await HotelService.updateHotelRoom(hotelId, room.id, room);
           ToastFactory.success("Room updated!");
       } catch (error) {
           ToastFactory.danger("Room update failed!");
           if (error instanceof Error) {
               throw new Error("Room update failed!");
           }
           throw new Error("Room update failed!");
       }
   }
   const deleteRoom = async (hotelId: string, roomId: string) => {
        try {
            await HotelService.deleteHotelRoom(hotelId, roomId);
            ToastFactory.success("Room deleted!");
        } catch (error) {
            ToastFactory.danger("Room deletion failed!");
        }
    }

    return {
        getAll,
        store,
        find,
        update,
        deleteRoom
    }
});
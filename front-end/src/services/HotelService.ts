import ApiClient from "@/services/ApiClient.ts";
import {Hotel} from "@/types/Hotel.ts";
import {Room} from "@/types/Room.ts";
import {Restaurant} from "@/types/Restaurant.ts";
import ValidationError from "@/services/ValidationError.ts";

class HotelService {
    private readonly endpoint: string;

    constructor(endpoint: string) {
        this.endpoint = endpoint;
    }

    public async getAll(): Promise<any> {
        const response = await ApiClient.get(`${this.endpoint}`);
        const responseData = await response.json();
        return responseData.data;
    }

    public async getById(id: string): Promise<any> {
        const response = await ApiClient.get(`${this.endpoint}/${id}`);
        const responseData = await response.json();
        return responseData.data;
    }

    public async store(hotel: Hotel): Promise<any> {
       const response = await ApiClient.post(`${this.endpoint}`, hotel);
        if ( response.status === 422 ) {
            const responseData = await response.json();
            throw new ValidationError("" ,responseData.errors);
        }
        if (!response.ok) {
            throw new Error("Hotel creation failed!");
        }
        return response;
    }

    public async update(hotel: Hotel): Promise<any> {
        const response = await ApiClient.patch(`${this.endpoint}/${hotel.id}`, hotel);
        const responseData = await response.json();
        if ( response.status === 422 ) {
            const responseData = await response.json();
            throw new ValidationError("" ,responseData.errors);
        }
        if (!response.ok) {
            throw new Error("Hotel update failed!");
        }
        return response;
    }

    public async delete(id: string): Promise<any> {
        const response = await ApiClient.delete(`${this.endpoint}/${id}`);
        if (!response.ok) {
            throw new Error("Hotel deletion failed!");
        }
        return response;
    }

    public async getHotelRooms(hotelId: string): Promise<any> {
        const response = await ApiClient.get(`${this.endpoint}/${hotelId}/rooms`);
        const responseData = await response.json();
        console.log(responseData.data);
        return responseData.data;
    }

    public async getHotelRoom(hotelId: string, roomId: string): Promise<any> {
        return await ApiClient.get(`${this.endpoint}/${hotelId}/rooms/${roomId}`);
    }

    public async storeHotelRoom(hotelId: string, room: Room): Promise<any> {
        return await ApiClient.post(`${this.endpoint}/${hotelId}/rooms`, room);
    }

    public async updateHotelRoom(hotelId: string, roomId: string, room: Room): Promise<any> {
        return await ApiClient.patch(`${this.endpoint}/${hotelId}/rooms/${roomId}`, room);
    }

    public async deleteHotelRoom(hotelId: string, roomId: string): Promise<any> {
        return await ApiClient.delete(`${this.endpoint}/${hotelId}/rooms/${roomId}`);
    }
}

export default new HotelService('http://localhost:82/api/hotels');
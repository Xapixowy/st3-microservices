import ApiClient from "@/services/ApiClient.ts";
import {Reservation} from "@/types/Reservation.ts";
import ValidationError from "@/services/ValidationError.ts";

class ReservationService {
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

    public async store(reservation: Reservation): Promise<any> {
        const response = await ApiClient.post(`${this.endpoint}`, reservation);
        if (response.status === 422 ) {
            const responseData = await response.json();
            throw new ValidationError("" ,responseData.errors);
        }
        if (!response.ok) {
            throw new Error("Reservation creation failed!");
        }
        return response;
    }

    public async update(reservation: Reservation): Promise<any> {
        const response = await ApiClient.patch(`${this.endpoint}/${reservation.id}`, reservation);
        if (response.status === 422 ) {
            const responseData = await response.json();
            throw new ValidationError("" ,responseData.errors);
        }
        if (!response.ok) {
            throw new Error("Reservation update failed!");
        }
        return response;
    }

    public async delete(id: string): Promise<any> {
        const response = await ApiClient.delete(`${this.endpoint}/${id}`);
        if (!response.ok) {
            throw new Error("Reservation deletion failed!");
        }
        return response;
    }
}

export default new ReservationService('http://localhost:83/api/reservations');
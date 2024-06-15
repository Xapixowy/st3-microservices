import ApiClient from "@/services/ApiClient.ts";
import {Reservation} from "@/types/Reservation.ts";

class ReservationService {
    private readonly endpoint: string;

    constructor(endpoint: string) {
        this.endpoint = endpoint;
    }

    public async getAll(): Promise<any> {
        return await ApiClient.get(`${this.endpoint}`);
    }

    public async getById(id: string): Promise<any> {
        return await ApiClient.get(`${this.endpoint}/${id}`);
    }

    public async store(reservation: Reservation): Promise<any> {
        return await ApiClient.post(`${this.endpoint}`, reservation);
    }

    public async update(reservation: Reservation): Promise<any> {
        return await ApiClient.patch(`${this.endpoint}/${reservation.id}`, reservation);
    }

    public async delete(id: string): Promise<any> {
        return await ApiClient.delete(`${this.endpoint}/${id}`);
    }
}

export default new ReservationService('http://localhost:83/api/reservations');
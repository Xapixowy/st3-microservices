import ApiClient from "@/services/ApiClient.ts";
import {Restaurant} from "@/types/Restaurant.ts";
import {Table} from "@/types/Table.ts";
import ValidationError from "@/services/ValidationError.ts";

class RestaurantService {
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

    public async store(restaurant: Restaurant): Promise<any> {
            const response = await ApiClient.post(`${this.endpoint}`, restaurant);
            if ( response.status === 422 ) {
                const responseData = await response.json();
                throw new ValidationError("" ,responseData.errors);
            }
            if (!response.ok) {
                throw new Error("Restaurant creation failed!");
            }
            return response;
    }

    public async update(restaurant: Restaurant): Promise<any> {
        const response = await ApiClient.patch(`${this.endpoint}/${restaurant.id}`, restaurant);
        const responseData = await response.json();
        if ( response.status === 422 ) {
            const responseData = await response.json();
            throw new ValidationError("" ,responseData.errors);
        }
        if (!response.ok) {
            throw new Error("Restaurant update failed!");
        }
        return response;
    }

    public async delete(id: string): Promise<any> {
        const response = await ApiClient.delete(`${this.endpoint}/${id}`);
        if (!response.ok) {
            throw new Error("Restaurant deletion failed!");
        }
        return response;
    }

    public async getRestaurantTables(restaurantId: string): Promise<any> {
         const response = await ApiClient.get(`${this.endpoint}/${restaurantId}/tables`);
         const responseData = await response.json();
         return responseData.data;
    }

    public async getRestaurantTable(restaurantId: string, tableId: string): Promise<any> {
        const response = await ApiClient.get(`${this.endpoint}/${restaurantId}/tables/${tableId}`);
        const responseData = await response.json();
        return responseData.data;
    }

    public async storeRestaurantTable(restaurantId: string, table: Table): Promise<any> {
        const response = await ApiClient.post(`${this.endpoint}/${restaurantId}/tables`, table);
        if ( response.status === 422 ) {
            const responseData = await response.json();
            throw new ValidationError("" ,responseData.errors);
        }
        if (!response.ok) {
            throw new Error("Restaurant table creation failed!");
        }
        return response;
    }

    public async updateRestaurantTable(restaurantId: string, tableId: string | undefined, table: Table): Promise<any> {
        const response = await ApiClient.patch(`${this.endpoint}/${restaurantId}/tables/${tableId}`, table);
        if ( response.status === 422 ) {
            const responseData = await response.json();
            throw new ValidationError("" ,responseData.errors);
        }
        if (!response.ok) {
            throw new Error("Restaurant table update failed!");
        }
        return response;
    }

    public async deleteRestaurantTable(restaurantId: string, tableId: string): Promise<any> {
        const response = await ApiClient.delete(`${this.endpoint}/${restaurantId}/tables/${tableId}`);
        if (!response.ok) {
            throw new Error("Restaurant table deletion failed!");
        }
        return response;
    }
}

export default new RestaurantService('http://localhost:82/api/restaurants');
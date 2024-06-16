import ApiClient from "@/services/ApiClient.ts";

class CountryService {
    private readonly endpoint: string;

    constructor(endpoint: string) {
        this.endpoint = endpoint;
    }

    public async getAll(): Promise<any> {
        const response = await ApiClient.get(`${this.endpoint}`);
        const responseData = await response.json();
        return responseData.data;
    }

    public async find(numeric: string): Promise<any> {
        return await ApiClient.get(`${this.endpoint}/find?numeric=${numeric}}`);
    }
}

export default new CountryService('http://localhost:81/api/countries');
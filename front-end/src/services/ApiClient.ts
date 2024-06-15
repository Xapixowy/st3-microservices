

class ApiClient {
    private static instance: ApiClient;
    private token: string;


    constructor() {
    }

    setToken(token: string) {
        this.token = token;
    }

    public getInstance(): ApiClient {
        if (!ApiClient.instance) {
            ApiClient.instance = new ApiClient();
        }
        return ApiClient.instance;
    }

    public async get(endpoint: string = "", params?: any): Promise<any> {
       return await fetch(`${endpoint}`, {
           method: 'GET',
           headers: {
               'Accept': 'application/json',
               'Content-Type': 'application/json',
           },
       });
    }

    public async post(endpoint: string = "", body?: unknown,  params?: unknown): Promise<any> {
        return await fetch(`${endpoint}`, {
            method: 'POST',
            body: JSON.stringify(body),
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            }
        });
    }

    public async put(endpoint: string = "", body?: any,  params?: any): Promise<any> {
        return await fetch(`${endpoint}`, {
            method: 'PUT',
            body: JSON.stringify(body),
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            }
        });
    }

    public async patch(endpoint: string = "", body?: any,  params?: any): Promise<any> {
        return await fetch(`${endpoint}`, {
            method: 'PATCH',
            body: JSON.stringify(body),
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            }
        });
    }

    public async delete(endpoint: string = "", body?: any,  params?: any): Promise<any> {
        return await fetch(`${endpoint}`, {
            method: 'DELETE',
            body: JSON.stringify(body),
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            }
        });
    }
}

export default new ApiClient();
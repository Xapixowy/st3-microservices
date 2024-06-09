import ApiClient from "./ApiClient.ts";
import {User} from "@/types/User.ts";
import ToastFactory from "@/services/ToastService.ts";

class AuthService {
    private readonly endpoint: string;
    private readonly ApiClient: ApiClient;

    constructor(endpoint: string) {
        this.endpoint = endpoint;
    }

    private async activate(email: string, verificationCode: string): Promise<void> {
       return await ApiClient.post(`${this.endpoint}/activate`, {
           email,
           verification_code: verificationCode
       });
    }

    public async login(username: string, password: string): Promise<any> {
        try {
            return await ApiClient.post(`${this.endpoint}/login?email=${username}&password=${password}`);
        } catch(error) {
            throw new Error(error.message);
        }
    }

    public async register(user: User): Promise<any> {
        try{
            const response = await ApiClient.post(`${this.endpoint}/register`, user);
            const responseData = await response.json();
            if(response.status === 422){
                throw new Error(responseData.errors);
            }
            return await this.activate(user.email, response.data.verification_code);
        } catch(error) {
            throw new Error(error.message);
        }
    }


    public async logout(): Promise<any> {
        ApiClient.setToken("");
        localStorage.removeItem("token");
    }
}

export default new AuthService('api/auth');
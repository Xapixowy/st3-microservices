import ApiClient from "./ApiClient.ts";
import {User} from "@/types/User.ts";
import ToastFactory from "@/services/ToastService.ts";
import ValidationError from "@/services/ValidationError.ts";

class AuthService {
    private readonly endpoint: string;

    constructor(endpoint: string) {
        this.endpoint = endpoint;
    }

    private async activate(email: string, verificationCode: string): Promise<void> {
       return await ApiClient.post(`${this.endpoint}/activate`, {
           email,
           verification_code: `${verificationCode}`
       });
    }

    public async login(username: string, password: string): Promise<any> {
        try {
           const response = await ApiClient.post(`${this.endpoint}/login?email=${username}&password=${password}`);
           if(!response.ok){
               throw new Error("Invalid credentials");
           }
           const responseData = await response.json();
           this.token = responseData.token;
        } catch(error) {
            throw new Error(error.message);
        }
    }

    public async register(user: User): Promise<any> {
            const response = await ApiClient.post(`${this.endpoint}/register`, user);
            const responseData = await response.json();
            if(response.status === 422){
                throw new ValidationError(responseData.message, responseData.errors);
            }
            return await this.activate(user.email, responseData.verification_code.toString());
    }

    public set token(token: string) {
        localStorage.setItem("token", token);
    }

    public get token(): string {
        return localStorage.getItem("token");
    }

    public isLoggedIn(): boolean {
        return !!this.token;
    }

    public async logout(): Promise<any> {
        await ApiClient.post(`${this.endpoint}/logout`);
        ApiClient.setToken("");
        localStorage.removeItem("token");
    }
}

export default new AuthService('http://localhost:81/api/auth');
import {defineStore, Store} from "pinia";
import {User} from "@/types/User.ts";
import AuthService from "@/services/AuthService.ts";
import ToastFactory from "@/services/ToastService.ts";
import router from "@/router.ts";
import ValidationError from "@/services/ValidationError.ts";


export const usUserStore = defineStore('user', () => {
    const login: (username:string, password: string) => void = async (username: string, password: string) => {
        try {
            await AuthService.login(username, password);
            ToastFactory.success("Login successful!");
        } catch (error) {
            ToastFactory.danger("Login failed!");
            console.error(error);
        }
    }

    const register: (user: User) => void = async (user: User) => {
        try {
            const response = await AuthService.register(user);
            console.log(await response.json());
            await router.push('/login');
            ToastFactory.success("Register successful!");
        } catch (error) {
            ToastFactory.danger("Register failed!");
            if(error instanceof ValidationError) {
                throw new ValidationError(error.message, error.errorObject);
            } else {
                throw new Error(error.message);
            }
        }
    }

    const logout: () => void = async () => {
        await AuthService.logout();
        await router.push('/login');
        ToastFactory.success("Logout successful!");
    }

    return {
        login,
        register,
        logout
    }
})
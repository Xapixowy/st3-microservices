import {defineStore, Store} from "pinia";
import {User} from "@/types/User.ts";
import AuthService from "@/services/AuthService.ts";
import ToastFactory from "@/services/ToastService.ts";
import router from "@/router.ts";


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
            await AuthService.register(user);
            await router.push('/login');
            ToastFactory.success("Register successful!");
        } catch (error) {
            ToastFactory.danger("Register failed!");
            console.error(error);
            throw new Error(error.errors);
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
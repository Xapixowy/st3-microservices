import {defineStore} from "pinia";
import CountryService from "@/services/CountryService.ts";

export const userCountryStore = defineStore('country', () => {
    const getAll = async () => {
        return await CountryService.getAll();
    }

    const find = async (numeric: string) => {
        return await CountryService.find(numeric);
    }

    return {
        getAll,
        find
    }
});
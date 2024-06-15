<template>
  <main-layout :title="hotel.name" :description="hotel.description">
    <div class="create-hotel-form">
      <v-form>
        <v-text-field v-model="hotelName" label="Name" :rules="[v => !!v || 'Name is required']" />
        <p v-if="hotelNameError" class="error">{{ hotelNameError }}</p>
        <v-text-field v-model="hotelWebsite" label="Website" :rules="[v => !!v || 'Website is required']" />
        <p v-if="hotelWebsiteError" class="error">{{ hotelWebsiteError }}</p>
        <v-text-field v-model="hotelDescription" label="Description" :rules="[v => !!v || 'Description is required']" />
        <p v-if="hotelDescriptionError" class="error">{{ hotelDescriptionError }}</p>
        <v-text-field v-model="hotelStreet" label="Street" :rules="[v => !!v || 'Street is required']" />
        <p v-if="hotelStreetError" class="error">{{ hotelStreetError.message }}</p>
        <v-text-field v-model="hotelBuildingNumber" label="Building number" :rules="[v => !!v || 'Building number is required']" />
        <p v-if="hotelBuildingNumberError" class="error">{{ hotelBuildingNumberError }}</p>
        <v-text-field v-model="hotelCity" label="City" :rules="[v => !!v || 'City is required']" />
        <p v-if="hotelCityError" class="error">{{ hotelCityError }}</p>
        <v-text-field v-model="hotelZipCode" label="Zip code" :rules="[v => !!v || 'Zip code is required']" />
        <p v-if="hotelZipCodeError" class="error">{{ hotelZipCodeError }}</p>
        <v-select v-model="hotelCountryNumeric" :items="countries" item-value="numeric" item-title="name" label="Country" :rules="[v => !!v || 'Country is required']" />
        <v-text-field v-model="hotelPhone" label="Phone" :rules="[v => !!v || 'Phone is required']" />
        <p v-if="hotelPhoneError" class="error">{{ hotelPhoneError }}</p>
        <v-text-field v-model="hotelEmail" label="Email" :rules="[v => !!v || 'Email is required']" />
        <p v-if="hotelEmailError" class="error">{{ hotelEmailError }}</p>
        <div class="create-hotel-form__actions">
          <v-btn @click="cancel">Cancel</v-btn>
          <v-btn @click="editHotelHandler">Edit</v-btn>
        </div>
      </v-form>
    </div>
  </main-layout>
</template>

<script setup lang="ts">
import {computed, onMounted, ref} from "vue";
import MainLayout from "@/shared/MainLayout.vue";
import {Hotel} from "@/types/Hotel.ts";
import {useRouter} from "vue-router";
import {userHotelStore} from "@/storage/HotelStorage.ts";
import {Country} from "@/types/Country.ts";
import {userCountryStore} from "@/storage/CountryStorage.ts";

const props = defineProps<{
  id: string
}>();

const hotel = ref<Hotel>({
  id: '',
  name: '',
  website: '',
  description: '',
  address: {
    street: '',
    building_number: '',
    city: '',
    zip_code: '',
    country: {
      numeric: '',
    }
  },
  contact: {
    phone: '',
    email: ''
  }
});
const errors = ref<string[]>([]);

const router = useRouter();
const hotelStore = userHotelStore();
const countryStore = userCountryStore();
const countries = ref<Country[]>([]);

const hotelName = computed(() => hotel.value.name);
const hotelWebsite = computed(() => hotel.value.website);
const hotelDescription = computed(() => hotel.value.description);
const hotelStreet = computed(() => hotel.value.address.street);
const hotelBuildingNumber = computed(() => hotel.value.address.building_number);
const hotelCity = computed(() => hotel.value.address.city);
const hotelZipCode = computed(() => hotel.value.address.zip_code);
const hotelCountryNumeric = computed(() => hotel.value.address.country.numeric);
const hotelPhone = computed(() => hotel.value.contact.phone);
const hotelEmail = computed(() => hotel.value.contact.email);

const hotelNameError = computed(() => {
  return !!errors.value.name ? errors.value.name[0] : '';
});
const hotelWebsiteError = computed(() => {
  return !!errors.value.website ? errors.value.website[0] : '';
});
const hotelDescriptionError = computed(() => {
  return !!errors.value.description ? errors.value.description[0] : '';
});
const hotelStreetError = computed(() => {
  return !!errors.value.street ? errors.value.street[0] : '';
});
const hotelBuildingNumberError = computed(() => {
  return !!errors.value.building_number ? errors.value.building_number[0] : '';
});
const hotelCityError = computed(() => {
  return !!errors.value.city ? errors.value.city[0] : '';
});
const hotelZipCodeError = computed(() => {
  return !!errors.value.zip_code ? errors.value.zip_code[0] : '';
});
const hotelPhoneError = computed(() => {
  return !!errors.value.phone ? errors.value.phone[0] : '';
});
const hotelEmailError = computed(() => {
  return !!errors.value.email ? errors.value.email[0] : '';
});

const editHotelHandler = async () => {
  try {
    await hotelStore.update(hotel.value);
    await router.push('/hotels');
  } catch (error) {
    errors.value = error.errorObject;
  }
}

const cancel = () => {
  router.push('/hotels');
}


onMounted(async () => {
  hotel.value = await hotelStore.find(props.id);
  countries.value = await countryStore.getAll();

});

</script>


<style scoped>

</style>
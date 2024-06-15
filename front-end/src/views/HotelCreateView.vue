<template>
  <main-layout title="Hotel" description="Create a new hotel">
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
          <v-btn @click="createHotelHandler">Create</v-btn>
        </div>
      </v-form>
    </div>
  </main-layout>
</template>

<script setup lang="ts">
import MainLayout from "@/shared/MainLayout.vue";
import {ref, onMounted, computed} from "vue";
import router from "@/router.ts";
import {userCountryStore} from "@/storage/CountryStorage.ts";
import {Country} from "@/types/Country.ts";
import {Hotel} from "@/types/Hotel.ts";
import {userHotelStore} from "@/storage/HotelStorage.ts";

const hotelStore = userHotelStore();
const countryStore = userCountryStore();
const errors = ref<string[]>([]);

const hotelName = ref('');
const hotelWebsite = ref('');
const hotelDescription = ref('');
const hotelStreet = ref('');
const hotelBuildingNumber = ref('');
const hotelCity = ref('');
const hotelZipCode = ref('');
const hotelCountryNumeric = ref('');
const hotelPhone = ref('');
const hotelEmail = ref('');

const countries = ref<Country[]>([]);

const formData = computed<Hotel>(() => {
  return {
    name: hotelName.value,
    website: hotelWebsite.value,
    description: hotelDescription.value,
    street: hotelStreet.value,
    building_number: hotelBuildingNumber.value,
    city: hotelCity.value,
    zip_code: hotelZipCode.value,
    country_numeric: hotelCountryNumeric.value,
    phone: hotelPhone.value,
    email: hotelEmail.value
  }
});

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


const createHotelHandler = async () => {
  try {
    await hotelStore.store(formData.value);
    await router.push('/hotels');
  } catch (error) {
    errors.value = error.errorObject;
  }
}

const cancel = () => {
  router.push('/restaurants');
}

onMounted(async () => {
  countries.value = await countryStore.getAll();
})

</script>

<style lang="scss" scoped>
.create-hotel-form {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  width: 100%;
  height: auto;
  border-radius: 1rem;
  padding: 1.5rem;

  form {
    width: 50%;
    gap: 1rem;
  }

  .create-hotel-form__actions {
    width: 100%;
    display: flex;
    justify-content: center;
    gap: 1rem;
  }
}

.error {
  color: red;
}
</style>
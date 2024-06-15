<template>
  <main-layout title="Restaurant" description="Create a new restaurant">
    <div class="create-restaurant-form">
      <v-form>
        <v-text-field v-model="restaurantName" label="Name" :rules="[v => !!v || 'Name is required']" />
        <p v-if="restaurantNameError" class="error">{{ restaurantNameError }}</p>
        <v-text-field v-model="restaurantWebsite" label="Website" :rules="[v => !!v || 'Website is required']" />
        <p v-if="restaurantWebsiteError" class="error">{{ restaurantWebsiteError }}</p>
        <v-text-field v-model="restaurantDescription" label="Description" :rules="[v => !!v || 'Description is required']" />
        <p v-if="restaurantDescriptionError" class="error">{{ restaurantDescriptionError }}</p>
        <v-text-field v-model="restaurantStreet" label="Street" :rules="[v => !!v || 'Street is required']" />
        <p v-if="restaurantStreetError" class="error">{{ restaurantStreetError.message }}</p>
        <v-text-field v-model="restaurantBuildingNumber" label="Building number" :rules="[v => !!v || 'Building number is required']" />
        <p v-if="restaurantBuildingNumberError" class="error">{{ restaurantBuildingNumberError }}</p>
        <v-text-field v-model="restaurantCity" label="City" :rules="[v => !!v || 'City is required']" />
        <p v-if="restaurantCityError" class="error">{{ restaurantCityError }}</p>
        <v-text-field v-model="restaurantZipCode" label="Zip code" :rules="[v => !!v || 'Zip code is required']" />
        <p v-if="restaurantZipCodeError" class="error">{{ restaurantZipCodeError }}</p>
        <v-select v-model="restaurantCountryNumeric" :items="countries" item-value="numeric" item-title="name" label="Country" :rules="[v => !!v || 'Country is required']" />
        <p v-if="restaurantCountryNumericError" class="error">{{ restaurantCountryNumericError }}</p>
        <v-text-field v-model="restaurantPhone" label="Phone" :rules="[v => !!v || 'Phone is required']" />
        <p v-if="restaurantPhoneError" class="error">{{ restaurantPhoneError }}</p>
        <v-text-field v-model="restaurantEmail" label="Email" :rules="[v => !!v || 'Email is required']" />
        <p v-if="restaurantEmailError" class="error">{{ restaurantEmailError }}</p>
        <div class="create-restaurant-form__actions">
          <v-btn @click="cancel">Cancel</v-btn>
          <v-btn @click="createRestaurant">Create</v-btn>
        </div>
      </v-form>
    </div>
  </main-layout>
</template>

<script setup lang="ts">
import MainLayout from "@/shared/MainLayout.vue";
import {userRestaurantStore} from "@/storage/RestaurantStorage.ts";
import {ref, onMounted, computed} from "vue";
import {Restaurant} from "@/types/Restaurant.ts";
import router from "@/router.ts";
import {userCountryStore} from "@/storage/CountryStorage.ts";
import {Country} from "@/types/Country.ts";

const restaurantStore = userRestaurantStore();
const countryStore = userCountryStore();
const errors = ref<string[]>([]);

const restaurantName = ref('');
const restaurantWebsite = ref('');
const restaurantDescription = ref('');
const restaurantStreet = ref('');
const restaurantBuildingNumber = ref('');
const restaurantCity = ref('');
const restaurantZipCode = ref('');
const restaurantCountryNumeric = ref('');
const restaurantPhone = ref('');
const restaurantEmail = ref('');

const countries = ref<Country[]>([]);

const formData = computed<Restaurant>(() => {
 return {
   name: restaurantName.value,
   website: restaurantWebsite.value,
   description: restaurantDescription.value,
   street: restaurantStreet.value,
   building_number: restaurantBuildingNumber.value,
   city: restaurantCity.value,
   zip_code: restaurantZipCode.value,
   country_numeric: restaurantCountryNumeric.value,
   phone: restaurantPhone.value,
   email: restaurantEmail.value
 }
});

const restaurantNameError = computed(() => {
  return !!errors.value.name ? errors.value.name[0] : '';
});
const restaurantWebsiteError = computed(() => {
  return !!errors.value.website ? errors.value.website[0] : '';
});
const restaurantDescriptionError = computed(() => {
  return !!errors.value.description ? errors.value.description[0] : '';
});
const restaurantStreetError = computed(() => {
  return !!errors.value.street ? errors.value.street[0] : '';
});
const restaurantBuildingNumberError = computed(() => {
  return !!errors.value.building_number ? errors.value.building_number[0] : '';
});
const restaurantCityError = computed(() => {
  return !!errors.value.city ? errors.value.city[0] : '';
});
const restaurantZipCodeError = computed(() => {
  return !!errors.value.zip_code ? errors.value.zip_code[0] : '';
});
const restaurantCountryNumericError = computed(() => {
  return !!errors.value.country_numeric ? errors.value.country_numeric[0] : '';
});
const restaurantPhoneError = computed(() => {
  return !!errors.value.phone ? errors.value.phone[0] : '';
});
const restaurantEmailError = computed(() => {
  return !!errors.value.email ? errors.value.email[0] : '';
});

const createRestaurant = async () => {
  try {
    await restaurantStore.store(formData.value);
    await router.push('/restaurants');
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
.create-restaurant-form {
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

  .create-restaurant-form__actions {
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
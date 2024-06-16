<template>
  <main-layout :title="restaurant.name" :description="restaurant.description">
    <div class="form-container">
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
        <v-text-field v-model="restaurantPhone" label="Phone" :rules="[v => !!v || 'Phone is required']" />
        <p v-if="restaurantPhoneError" class="error">{{ restaurantPhoneError }}</p>
        <v-text-field v-model="restaurantEmail" label="Email" :rules="[v => !!v || 'Email is required']" />
        <p v-if="restaurantEmailError" class="error">{{ restaurantEmailError }}</p>
        <div class="form__actions">
          <v-btn @click="cancel">Cancel</v-btn>
          <v-btn @click="editRestaurantHandler">Edit</v-btn>
        </div>
      </v-form>
    </div>
  </main-layout>
</template>

<script setup lang="ts">
import {computed, ref, onBeforeMount, watch} from "vue";
import MainLayout from "@/shared/MainLayout.vue";
import {Restaurant} from "@/types/Restaurant.ts";
import {useRouter} from "vue-router";
import {Country} from "@/types/Country.ts";
import {userCountryStore} from "@/storage/CountryStorage.ts";
import {useRestaurantStore} from "@/storage/RestaurantStorage.ts";

const props = defineProps<{
  id: string
}>();

const restaurant = ref<Restaurant>({
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
const restaurantStore = useRestaurantStore();
const countryStore = userCountryStore();
const countries = ref<Country[]>([]);

const restaurantId = ref<string>('');
const restaurantName = ref<string>('');
const restaurantWebsite = ref<string>('');
const restaurantDescription = ref<string>('');
const restaurantStreet = ref<string>('');
const restaurantBuildingNumber = ref<string>('');
const restaurantCity = ref<string>('');
const restaurantZipCode = ref<string>('');
const restaurantCountryNumeric = ref<string>('');
const restaurantPhone = ref<string>('');
const restaurantEmail = ref<string>('');


watch(restaurant, () => {
  restaurantId.value = restaurant.value.id;
  restaurantName.value = restaurant.value.name;
  restaurantWebsite.value = restaurant.value.website;
  restaurantDescription.value = restaurant.value.description;
  restaurantStreet.value = restaurant.value.address.street;
  restaurantBuildingNumber.value = restaurant.value.address.building_number;
  restaurantCity.value = restaurant.value.address.city;
  restaurantZipCode.value = restaurant.value.address.zip_code;
  restaurantCountryNumeric.value = restaurant.value.address.country.numeric;
  restaurantPhone.value = restaurant.value.contact.phone;
  restaurantEmail.value = restaurant.value.contact.email;
})

const restaurantFormData = computed(() => {
  return {
    id: restaurantId.value,
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
const restaurantPhoneError = computed(() => {
  return !!errors.value.phone ? errors.value.phone[0] : '';
});
const restaurantEmailError = computed(() => {
  return !!errors.value.email ? errors.value.email[0] : '';
});


const editRestaurantHandler = async () => {
  try {
    await restaurantStore.update(restaurantFormData.value);
    await router.push('/restaurants');
  } catch (error) {
    errors.value = error.errorObject;
  }
}

const cancel = () => {
  router.push('/restaurants');
}


onBeforeMount(async () => {
  restaurant.value = await restaurantStore.find(props.id);
  countries.value = await countryStore.getAll();

});

</script>


<style scoped>


</style>
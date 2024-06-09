
<template>
  <form class="login-form">
    <FormErrors :errors="errors" />
    <div class="login-form__inputs">
      <v-text-field
          v-model="firstName"
          label="First Name"
          type="text"
          :rules="[v => !!v || 'First name is required']"
          class="mb-2"
          variant="solo"
      ></v-text-field>
      <v-text-field
          v-model="lastName"
          label="Last Name"
          type="text"
          :rules="[v => !!v || 'Last name is required']"
          class="mb-2"
          variant="solo"
      ></v-text-field>
      <v-text-field
          v-model="email"
          label="E-Mail"
          type="email"
          :rules="[v => !!v || 'Email is required']"
          class="mb-2"
          variant="solo"
      ></v-text-field>
      <v-text-field
          v-model="phone"
          label="Phone"
          type="text"
          prefix="+48"
          :rules="[v => !!v || 'Phone is required']"
          class="mb-2"
          variant="solo"
      ></v-text-field>
      <v-text-field
          v-model="password"
          label="Password"
          type="password"
          :rules="[v => !!v || 'Password is required']"
          class="login-input__input"
          variant="solo"
      ></v-text-field>
      <v-text-field
          v-model="confirmPassword"
          label="Confirm Password"
          type="password"
          :rules="[v => !!v || 'Confirm Password is required']"
          class="login-input__input"
          variant="solo"
      ></v-text-field>
    </div>
    <div class="login-form__actions">
      <v-btn
          class="login-form__btn"
          @click="register"
          :disabled="!isFormValid"
      >
        Register
      </v-btn>
      <div class="login-form__link">
        <a href="/login">
          Back to Login
        </a>
      </div>
    </div>
  </form>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'
import FormErrors from "@components/FormErrors.vue";
import {usUserStore} from "@/storage/UserStorage.ts";

const userStore = usUserStore();
const router = useRouter()

const firstName = ref<string>('')
const lastName = ref<string>('')
const email = ref<string>('')
const password = ref<string>('')
const confirmPassword = ref<string>('')
const phone = ref<string>('');

const errors = ref<string[]>([])

const isFormValid = computed<boolean>(() => {
  return !!firstName.value && !!lastName.value && !!email.value && !!password.value && !!confirmPassword.value;
});

const formData = computed(() => {
  return {
    firstName: firstName.value,
    lastName: lastName.value,
    email: email.value,
    password: password.value,
    confirmPassword: confirmPassword.value,
    phone: phone.value
  }
});

const checkPassword = (password: string, confirmPassword: string) => {
  return password === confirmPassword;
}


const register = async (e) => {
  e.preventDefault();
  if(!checkPassword(password.value, confirmPassword.value)) {
    errors.value.push("Passwords don't match");
    return;
  }
  try {
    userStore.register(formData.value);
  } catch (error) {
    console.log(error);
    errors.value.push(error.message);
  }
}
</script>

<style lang="scss" scoped>
.login-form {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  width: 25rem;
  height: auto;
  border-radius: 1rem;
  box-shadow: 0 0 1rem rgba(0, 0, 0, 0.3);
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background-color: var(--black);
  padding: 1.5rem;
  &__actions {
    width: 70%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    gap: 1rem;
  }
  &__inputs {
    width: 100%;
    display: flex;
    flex-direction: column;
    gap: 0.1rem;
    .v-text-field {

      width: 100%;
      margin-bottom: 0.5rem;
    }
  }
  &__link {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 0.5rem;
    a {
      color: var(--white);
      text-decoration: none;
    }
    a:hover {
      text-decoration: underline;
    }
  }
}
</style>d
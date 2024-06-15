
<template>
<form class="login-form">
  <div class="login-form__inputs">
      <v-text-field
          v-model="username"
          label="Username"
          type="text"
          :rules="[v => !!v || 'Username is required']"
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
  </div>
  <div class="login-form__actions">
    <v-btn
        class="login-form__btn"
        @click="login"
        :disabled="!isFormValid"
    >
      Login
    </v-btn>
    <v-btn
        class="login-form__btn"
        @click="register"
    >
      Register
    </v-btn>
  </div>
</form>
</template>

<script setup lang="ts">
import {computed, ref} from 'vue'
import { useRouter } from 'vue-router'
import {usUserStore} from "@/storage/UserStorage.ts";

const userStore = usUserStore();
const router = useRouter()

const username = ref('');
const password = ref('');

const isFormValid = computed<boolean>(() => {
  return !!username.value && !!password.value;
});

const login = async () => {
  await userStore.login(username.value, password.value);
  await router.push('/restaurants')
}

const register = () => {
    router.push('/register')
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
    gap: 0.5rem;
    .v-text-field {
      width: 100%;
      margin-bottom: 1rem;
    }
  }
}
</style>
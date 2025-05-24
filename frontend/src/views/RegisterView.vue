<template>
  <div class="register container">
    <h1 class="text-center">Register</h1>
    <form @submit.prevent="submitForm" class="needs-validation" novalidate>
      <div class="mb-3">
        <label for="name" class="form-label">Name:</label>
        <input type="text" id="name" v-model="form.name" class="form-control" required />
        <div class="invalid-feedback">
          Please enter your name.
        </div>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email:</label>
        <input type="email" id="email" v-model="form.email" class="form-control" required />
        <div class="invalid-feedback">
          Please enter a valid email.
        </div>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password:</label>
        <input type="password" id="password" v-model="form.password" class="form-control" required />
        <div class="invalid-feedback">
          Please enter your password.
        </div>
      </div>
      <button type="submit" class="btn btn-primary w-100">Register</button>
    </form>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useSessionStore } from '@/stores/session';
import type {RegisterReuest} from "@/core/models/Auth/RegisterReuest.ts";

const form = ref<RegisterReuest>({
  name: '',
  email: '',
  password: ''
});

const sessionStore = useSessionStore();

const submitForm = async () => {
  try {
    await sessionStore.doRegister(form.value);
  } catch (error) {
    console.log(error);
  }
};
</script>

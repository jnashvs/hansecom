<template>
  <div class="login-page container">
    <h1 class="text-center">Login</h1>
    <form @submit.prevent="handleLogin" class="needs-validation" novalidate>
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
      <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useSessionStore } from '@/stores/session';
import { useRouter } from 'vue-router';
import type {LoginRequest} from "@/core/models/Auth/LoginRequest.ts";

const form = ref<LoginRequest>({
  email: null,
  password: null,
});

const error = ref<string | null>(null);
const sessionStore = useSessionStore();
const router = useRouter();

const handleLogin = async () => {
  error.value = null;
  try {
    await sessionStore.doLogin(form.value);
    router.push('/');
  } catch (err: never) {
    console.log(err);
  }
};
</script>

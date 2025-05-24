<template>
  <div class="register container">
    <h1 class="text-center">Register</h1>
    <form @submit.prevent="submitForm" class="needs-validation" novalidate>
      <div class="mb-3">
        <label for="name" class="form-label">Name:</label>
        <input type="text" id="name" v-model="form.name" class="form-control" required />
        <div v-if="errors.name" class="text-danger">
          {{ errors.name }}
        </div>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email:</label>
        <input type="email" id="email" v-model="form.email" class="form-control" required />
        <div v-if="errors.email" class="text-danger">
          {{ errors.email }}
        </div>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password:</label>
        <input type="password" id="password" v-model="form.password" class="form-control" required />
        <div v-if="errors.password" class="text-danger">
          {{ errors.password }}
        </div>
      </div>
      <button type="submit" class="btn btn-primary w-100" :disabled="isLoading">
        <span v-if="isLoading">
          <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
          <span>Submitting...</span>
        </span>
        <span v-else>
          Register
        </span>
      </button>
    </form>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { useSessionStore } from '@/stores/session';
import * as yup from 'yup';

const isLoading = ref<boolean>(false);

const schema = yup.object({
  name: yup.string().required('Name is required'),
  email: yup.string().required('Email is required').email('Enter a valid email'),
  password: yup.string().required('Password is required').min(8, 'Password must be at least 8 characters'),
});

const form = ref({
  name: '',
  email: '',
  password: '',
});

const errors = ref({
  name: '',
  email: '',
  password: '',
});

const clearErrors = () => {
  errors.value.name = '';
  errors.value.email = '';
  errors.value.password = '';
}

const sessionStore = useSessionStore();

const submitForm = async () => {
  try {
    clearErrors();
    isLoading.value = true;
    await schema.validate(form.value, { abortEarly: false });
    await sessionStore.doRegister(form.value);
  } catch (validationError) {
    if (validationError.inner) {
      validationError.inner.forEach(err => {
        errors.value[err.path] = err.message;
      });
    }
  } finally {
    isLoading.value = false;
  }
};
</script>

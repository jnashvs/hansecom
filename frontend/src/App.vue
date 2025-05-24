<template>
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm sticky-top">
    <div class="container">
      <RouterLink class="navbar-brand fw-bold d-flex align-items-center" to="/">
        <i class="bi bi-lightning-charge-fill me-2"></i> Hansecom
      </RouterLink>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <RouterLink class="nav-link" to="/">Home</RouterLink>
          </li>
          <li class="nav-item">
            <RouterLink class="nav-link" to="/about">About</RouterLink>
          </li>
        </ul>
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <template v-if="isAuthenticated">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person-circle me-2 fs-4"></i>
                <span class="fw-semibold">{{ userDetails?.name || 'User' }}</span>
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                <li><span class="dropdown-item-text small text-muted">{{ userDetails?.email }}</span></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="#" @click.prevent="logout">Logout</a></li>
              </ul>
            </li>
          </template>
          <template v-else>
            <li class="nav-item">
              <RouterLink class="nav-link" to="/login">Login</RouterLink>
            </li>
            <li class="nav-item">
              <RouterLink class="nav-link" to="/register">Register</RouterLink>
            </li>
          </template>
        </ul>
      </div>
    </div>
  </nav>
  <main class="bg-light min-vh-100 d-flex flex-column justify-content-center align-items-center">
    <div class="container py-5">
      <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
          <div class="p-4 p-md-5 bg-white rounded-4 shadow-sm">
            <RouterView />
          </div>
        </div>
      </div>
    </div>
  </main>
  <footer class="bg-primary text-white text-center py-3 mt-auto shadow-sm">
    <div class="container">
      <small>&copy; {{ new Date().getFullYear() }} Hansecom. All rights reserved.</small>
    </div>
  </footer>
</template>

<script setup lang="ts">
import '@/assets/scss/main.scss'
import { RouterLink, RouterView, useRouter } from 'vue-router'
import { storeToRefs } from 'pinia'
import { useSessionStore } from '@/stores/session'
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap'
import 'bootstrap-icons/font/bootstrap-icons.css'

const sessionStore = useSessionStore()
const { isAuthenticated, userDetails } = storeToRefs(sessionStore)
const router = useRouter()

function logout() {
  sessionStore.doLogout()
}
</script>

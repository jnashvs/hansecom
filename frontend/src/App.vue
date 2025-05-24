<script setup lang="ts">
import { RouterLink, RouterView } from 'vue-router'
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap';
</script>

<template>
  <div class="container">
    <div class="header-content">
      <header>
        <div class="wrapper">
          <nav>
            <RouterLink to="/">Home</RouterLink>
            <RouterLink to="/about">About</RouterLink>
          </nav>
        </div>
      </header>
    </div>
    <div class="app-content">
      <RouterView />
    </div>
  </div>
</template>

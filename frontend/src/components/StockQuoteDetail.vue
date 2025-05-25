<template>
  <div v-if="quote" class="card mb-4">
    <div class="card-body">
      <h5 class="card-title">Quote for {{ quote.symbol }}</h5>
      <ul class="list-group list-group-flush">
        <li class="list-group-item"><strong>Name:</strong> {{ quote.name }}</li>
        <li class="list-group-item"><strong>Price:</strong> {{ quote.price }}</li>
        <li class="list-group-item"><strong>Open:</strong> {{ quote.open }}</li>
        <li class="list-group-item"><strong>High:</strong> {{ quote.high }}</li>
        <li class="list-group-item"><strong>Low:</strong> {{ quote.low }}</li>
        <li class="list-group-item"><strong>Close:</strong> {{ quote.close }}</li>
        <li class="list-group-item"><strong>Date:</strong> {{ quote.date }}</li>
      </ul>
    </div>
  </div>
</template>
<script setup lang="ts">
import type { Stock } from '@/core/models/Stock/Stock';
defineProps<{ quote: Stock|null }>();
</script>
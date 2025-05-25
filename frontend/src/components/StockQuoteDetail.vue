<template>
  <div v-if="quote">
    <h5 class="mb-3">Quote for {{ quote.symbol }}</h5>
    <table class="table table-striped table-bordered rounded-2">
      <tbody>
      <tr>
        <th>Name</th>
        <td>{{ quote.name }}</td>
      </tr>
      <tr>
        <th>Price</th>
        <td>{{ quote.price }}</td>
      </tr>
      <tr>
        <th>Open</th>
        <td>{{ quote.open }}</td>
      </tr>
      <tr>
        <th>High</th>
        <td>{{ quote.high }}</td>
      </tr>
      <tr>
        <th>Low</th>
        <td>{{ quote.low }}</td>
      </tr>
      <tr>
        <th>Close</th>
        <td>{{ quote.close }}</td>
      </tr>
      <tr>
        <th>Date</th>
        <td>{{ quote.date }}</td>
      </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup lang="ts">
import type { Stock } from '@/core/models/Stock/Stock';
defineProps<{ quote: Stock|null }>();
</script>

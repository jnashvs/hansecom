<template>
  <div class="container stock-history-container mt-4">
    <h3>Stock Market Overview</h3>

    <form class="my-4" @submit.prevent="searchQuote">
      <div class="input-group">
        <input v-model="quoteSymbol" type="text" class="form-control" placeholder="Enter stock symbol (e.g. AAPL)" />
        <button class="btn btn-primary" type="submit">Search Quote</button>
      </div>
    </form>

    <div v-if="isLoading" class="alert alert-info">Searching...</div>
    <div v-if="quoteError" class="alert alert-danger">{{ quoteError }}</div>

    <div class="row">
      <div :class="quoteResult ? 'col-12 col-md-4 mb-3' : 'col-12 mb-3'">
        <StockQuoteDetail :quote="quoteResult" />
        <div v-if="stocksStore.loading" class="alert alert-info">Loading...</div>
        <div v-if="stocksStore.error" class="alert alert-danger">{{ stocksStore.error }}</div>
      </div>
      <div :class="quoteResult ? 'col-12 col-md-8' : 'col-12'">
        <h5 class="mb-3">Stock History</h5>

        <table v-if="!stocksStore.loading && !stocksStore.error" class="table table-striped table-bordered rounded-2">
          <thead class="thead-dark">
            <tr>
              <th v-for="column in columns" @click="sort(column.key)">
                {{ column.label }} <i :class="getSortIcon(column.key)"></i>
              </th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="stock in stocksStore.items" :key="stock.id">
              <td>{{ stock.date }}</td>
              <td>{{ stock.symbol }}</td>
              <td>{{ stock.open }}</td>
              <td>{{ stock.high }}</td>
              <td>{{ stock.low }}</td>
              <td>{{ stock.close }}</td>
            </tr>
          </tbody>
        </table>
        <div v-if="!stocksStore.loading && !stocksStore.error && stocksStore.items.length === 0" class="alert alert-warning">
          No stock history found.
        </div>

        <nav v-if="totalPages > 1">
          <ul class="pagination justify-content-center mt-3">
            <li class="page-item" :class="{ disabled: currentPage === 1 }">
              <button class="page-link btn-sm" @click="goToPage(currentPage - 1)">Previous</button>
            </li>
            <li v-for="page in totalPages" :key="page" class="page-item" :class="{ active: currentPage === page }">
              <button class="page-link btn-sm" @click="goToPage(page)">{{ page }}</button>
            </li>
            <li class="page-item" :class="{ disabled: currentPage === totalPages }">
              <button class="page-link btn-sm" @click="goToPage(currentPage + 1)">Next</button>
            </li>
          </ul>
        </nav>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, computed } from 'vue';
import { useStocksStore } from '@/stores/stocks';
import type { Stock } from '@/core/models/Stock/Stock';
import StockQuoteDetail from '@/components/StockQuoteDetail.vue';

const columns = [
  { key: 'date', label: 'Date' },
  { key: 'symbol', label: 'Symbol' },
  { key: 'open', label: 'Open' },
  { key: 'high', label: 'High' },
  { key: 'low', label: 'Low' },
  { key: 'close', label: 'Close' },
];

const stocksStore = useStocksStore();
const quoteSymbol = ref('');
const quoteResult = ref<Stock|null>(null);
const isLoading = ref(false);
const quoteError = ref('');
const pageSize = 6;
const currentPage = ref(1);

const totalPages = computed(() => Math.ceil(stocksStore.recordsTotal / pageSize));

const searchQuote = async () => {

  if (!quoteSymbol.value) return;

  isLoading.value = true;
  quoteError.value = '';
  quoteResult.value = null;

  try {
    quoteResult.value = await stocksStore.fetchQuote(quoteSymbol.value);
  } catch (err: any) {
    quoteError.value = err.response?.data?.message || err.message || 'Failed to fetch quote.';
  } finally {
    loadStockHistory();
    isLoading.value = false;
  }
};

const sortBy = ref('created_at');
const sortDesc = ref(false);

const sort = (column: string) => {
  if (sortBy.value === column) {
    sortDesc.value = !sortDesc.value;
  } else {
    sortBy.value = column;
    sortDesc.value = false;
  }
  loadStockHistory();
};

const getSortIcon = (column: string) => {
  if (sortBy.value !== column) return 'bi bi-arrow-down-up';
  return sortDesc.value ? 'bi bi-arrow-down' : 'bi bi-arrow-up';
};

const loadStockHistory = () => {
  stocksStore.fetchStocks({
    pageIndex: currentPage.value,
    pageSize,
    sortBy: sortBy.value,
    sortDesc: sortDesc.value ? 1 : 0,
  });
};

const goToPage = (page: number) => {
  if (page < 1 || page > totalPages.value) return;
  currentPage.value = page;
  loadStockHistory();
};

onMounted(() => {
  loadStockHistory();
});
</script>

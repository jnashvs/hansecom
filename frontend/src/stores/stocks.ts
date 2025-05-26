import { defineStore } from 'pinia';
import type { StocksState } from '@/core/models/Stock/StocksState.ts';
import type { StockPaginatedResult } from '@/core/models/Stock/StockPaginatedResult.ts';
import ApiPath from '@/core/config/api_path.json';
import { ApiService } from '@/core/services/ApiService';
import type { Stock } from "@/core/models/Stock/Stock.ts";
import type { ParamsQuery } from "@/core/models/ParamsQuery.ts";

export const useStocksStore = defineStore('stocks', {
  state: (): StocksState => ({
    items: [],
    recordsTotal: 0,
    loading: false,
    error: null,
  }),
  actions: {
    async fetchStocks({
      search = '',
      pageIndex = 0,
      pageSize = 6,
      sortBy = 'created_at',
      sortDesc = 0
    }: ParamsQuery = {}) {
      this.loading = true;
      this.error = null;
      try {
        const params = {
          search,
          pageIndex,
          pageSize,
          sortBy,
          sortDesc
        };

        const stocksIf = ApiService(ApiPath.stocks.history);
        const response = await stocksIf.get(params) as StockPaginatedResult<Stock>;

        this.items = response.items;
        this.recordsTotal = response.recordsTotal;
      } catch (err: any) {
        this.error = err.response?.data?.message || err.message || 'Failed to fetch stocks.';
      } finally {
        this.loading = false;
      }
    },
    async fetchQuote(symbol: string) {
      try {
        const quoteIf = ApiService(ApiPath.stocks.quote);
        const payload = { symbol };
        return await quoteIf.post(payload) as Stock;
      } catch (err: any) {
        throw err;
      }
    },
  },
});

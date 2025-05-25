import type {Stock} from "@/core/models/Stock/Stock.ts";

export interface StockPaginatedResult<T> {
  items: Stock[];
  recordsTotal: number;
}

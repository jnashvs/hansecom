import { Stock } from './Stock.ts';

export interface StocksState {
  items: Stock[];
  recordsTotal: number;
  loading: boolean;
  error: string | null;
}

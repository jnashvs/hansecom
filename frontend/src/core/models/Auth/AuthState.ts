import type { UserDetails } from "../UserDetails.ts";
export interface AuthState {
  token?: string | null;
  userDetails?: UserDetails;
  error?: Error;
}

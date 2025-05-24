import type { UserDetails } from "../UserDetails";

export interface RegisterResponse {
  success: boolean;
  user: UserDetails;
}

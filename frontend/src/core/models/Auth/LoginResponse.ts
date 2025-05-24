import type { UserDetails } from "../UserDetails";

export interface LoginResponse {
  authorization: {
    token: string;
    type: string;
    expires_in: number;
  };
  user: UserDetails;
}

import { defineStore } from 'pinia';
import type { LoginRequest } from "@/core/models/Auth/LoginRequest";
import type { LoginResponse } from "@/core/models/Auth/LoginResponse";
import type { AuthState } from "@/core/models/Auth/AuthState";
import ApiPath from "@/core/config/api_path.json";
import { ApiService } from "@/core/services/ApiService";
import router from '@/router';
import { getToken, saveToken, destroyToken } from '@/core/services/JwtService';
import type { RegisterRequest } from "@/core/models/Auth/RegisterRequest";
import type {RegisterResponse} from "@/core/models/Auth/RegisterResponse.ts";
import type { UserDetails } from '@/core/models/UserDetails';
import { NotificationHelper } from "@/core/helpers/NotificationHelper.ts";

export const useSessionStore = defineStore('session', {
  state: (): AuthState => ({
    token: undefined,
    userDetails: undefined,
    error: undefined,
  }),

  getters: {
    isAuthenticated: (state) => !!state.token,
  },

  actions: {
    initSession() {
      const token = getToken();
      if (token) {
        this.token = token;
        this.fetchUserData();
      }
    },
    async fetchUserData() {
      if (this.token && !this.userDetails) {
        const userDetailsIf = ApiService(ApiPath.auth.whoami);
        try {
          this.userDetails = await userDetailsIf.get() as UserDetails;
        } catch (error) {
          destroyToken();
          this.token = null;
          this.userDetails = undefined;
          this.error = error;
        } finally {
        }
      }
    },

    async doLogin(data: LoginRequest): Promise<void> {
      const loginIf = ApiService(ApiPath.auth.login);
      try {
        const response: LoginResponse = await loginIf.post(data);
        const token = response?.authorization?.token;
        if (token) {
          saveToken(token);
          this.token = token;
          this.userDetails = response?.user;
          this.error = undefined;
        }
      } catch (error) {
        this.error = error;
        throw error;
      } finally {
      }
    },

    async doRegister(data: RegisterRequest): Promise<void> {
      const registerIf = ApiService(ApiPath.auth.register);
      try {
        const response: RegisterResponse = await registerIf.post(data);

        if (response.success) {
          NotificationHelper.showSuccess("User created successfully!");
          await router.push({name: "login"});
        }
      } catch (error) {
        this.error = error;
        throw error;
      }
    },

    async doRefresh() {
      const refreshIf = ApiService(ApiPath.auth.refresh);
      try {
        const response = await refreshIf.post(this.token);
        this.token = response.token;
        saveToken(this.token);
        window.location.reload();
      } catch (error) {
        this.token = undefined;
        this.userDetails = undefined;
        destroyToken();
        window.location.reload();
        this.error = error;
      }
    },

    async doLogout(): Promise<void> {
      destroyToken();
      this.token = undefined;
      this.userDetails = undefined;
      this.error = undefined;
      await router.push({ name: 'login' });
    },
  },
});

import { reactive, watch } from "vue";
import type { LoginRequest } from "@/core/models/Auth/LoginRequest";
import type { LoginResponse } from "@/core/models/Auth/LoginResponse";
import type { AuthState } from "@/core/models/Auth/AuthState";
import ApiPath from "@/core/config/api_path.json";
import { CookieHelper } from "@/core/helpers/CookieHelper";
import { ApiService } from "@/core/services/ApiService";

const AUTH_KEY = "id_token";
const AUTH_VALIDATING_KEY = "validatingAccess";

const token = CookieHelper.getCookie(AUTH_KEY)
  ? CookieHelper.getCookie(AUTH_KEY)
  : null;

const state = reactive<AuthState>({
  authenticating: false,
  token,
  userDetails: undefined,
  error: undefined,
});

const fetchUserData = () =>
  new Promise<void>((resolve, reject) => {
    if (state.token) {
      if (!state.userDetails) {
        const userDetailsIf = ApiService(ApiPath.auth.whoami);
        userDetailsIf.get();
        state.authenticating = true;
        watch([userDetailsIf.loading], () => {
          if (userDetailsIf.error.value) {
            CookieHelper.removeCookie(AUTH_KEY);
            state.token = null;
          } else if (userDetailsIf.data) {
            state.userDetails = userDetailsIf.data.value.data;
          }
          state.authenticating = false;
          resolve();
        });
      } else {
        resolve();
      }
    } else {
      reject();
    }
  });

export const SessionService = () => {
  const doLogin = (data: LoginRequest): Promise<void> =>
    new Promise<void>((resolve, reject) => {
      state.authenticating = true;
      const loginIf = ApiService(ApiPath.auth.login);
      loginIf
        .post(data)
        .then(() => {
          const response: LoginResponse = loginIf.data.value;
          CookieHelper.addCookie(AUTH_KEY, response.token);
          state.token = response.token;
          resolve();
        })
        .catch((error) => {
          reject(error);
        });
    });
  const doRefresh = () => {
    state.authenticating = true;
    const refreshIf = ApiService(ApiPath.auth.refresh);
    refreshIf
      .post(state.token)
      .then(() => {
        state.token = refreshIf.data.value.token;
        state.authenticating = false;
        CookieHelper.addCookie(AUTH_KEY, refreshIf.data.value.token);
        window.location.reload();
      })
      .catch(() => {
        state.token = undefined;
        state.authenticating = false;
        state.userDetails = undefined;
        CookieHelper.removeCookie(AUTH_KEY);
        window.location.reload();
      });
  };

  const doLogout = (): Promise<void> => {
    return new Promise<void>((resolve) => {
        CookieHelper.removeCookie(AUTH_KEY);
        CookieHelper.removeCookie(AUTH_VALIDATING_KEY);
        state.token = undefined;
        state.authenticating = false;
        state.userDetails = undefined;
        resolve();
    });
  };

  return {
    doLogin,
    doRefresh,
    doLogout,
    fetchUserData,
    state,
  };
};

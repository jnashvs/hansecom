import axios from "axios";
import { computed, ref } from "vue";
import { NotificationHelper } from "@/core/helpers/NotificationHelper";
import { CookieHelper } from "@/core/helpers/CookieHelper";
import { useSessionStore } from "@/stores/session";
import type { LoginRequest } from "@/core/models/Auth/LoginRequest.ts";

const AUTH_KEY = "id_token";

export const ApiService = (endpoint: string) => {
  const loading = ref(false);
  const data = ref();
  const error = ref();

  const token = CookieHelper.getCookie(AUTH_KEY)
    ? CookieHelper.getCookie(AUTH_KEY)
    : null;

  const axiosInstance = axios.create({
    baseURL: import.meta.env.VITE_API_URL,
  });

  axiosInstance.defaults.headers.common["Authorization"] = token
    ? `Bearer ${token}`
    : false;

  axiosInstance.interceptors.request.use(
    (config) => {
      return config;
    },
    (error) => {
      return Promise.reject(error);
    },
  );

  axiosInstance.interceptors.response.use(
    (response) => {
      return response;
    },
    (axiosErr) => {
      let response;
      let errorList: string[];
      const sessionStore = useSessionStore();

      if (
        axiosErr.config.url === endpoint &&
        axiosErr.config.method === "get" &&
        axiosErr.config.responseType === "blob"
      ) {
        return Promise.reject(axiosErr);
      }

      if (!axiosErr.response) {
        NotificationHelper.showError(["Network error"]);
        loading.value = false;
        return Promise.reject(axiosErr);
      }

      switch (axiosErr.response.status) {
        case 400:
          response = axiosErr.response.data;
          errorList = [response.message, response.details].filter(Boolean);
          NotificationHelper.showError(errorList);
          break;
        case 401:
          response = axiosErr.response.data;
          errorList = [response.message, response.details].filter(Boolean);
          NotificationHelper.showError(errorList);
          sessionStore.doLogout();
          break;
        case 403:
          NotificationHelper.showError([
            axiosErr.response.data.message,
            axiosErr.response.data.details,
          ].filter(Boolean));
          break;
        case 404:
          if (axiosErr.response.data.messages) {
            NotificationHelper.showError([axiosErr.response.data.messages].filter(Boolean));
          } else {
            NotificationHelper.showError(["Invalid endpoint"]);
          }
          break;
        case 422:
          response = axiosErr.response.data;
          errorList = [response.message, response.details].filter(Boolean);
          NotificationHelper.showError(errorList);
          break;
        case 500:
          response = axiosErr.response.data;
          errorList = [response.details].filter(Boolean);
          NotificationHelper.showError(errorList);
          break;
        default:
          NotificationHelper.showError(["Unknown error"]);
          break;
      }
      return Promise.reject(axiosErr.response);
    },
  );

  const errorMessage = computed(() => {
    if (error.value) {
      return error.value.message;
    }
    return null;
  });

  const errorDetails = computed(() => {
    if (error.value && error.value.response) {
      return error.value.response.data.message;
    }
    return null;
  });

  const get = (params?: {
    params: {
      search: string | undefined;
      pageIndex: number | undefined;
      pageSize: number | undefined;
      sortBy: string | undefined;
      sortDesc: boolean | undefined
    }
  }) => {
    loading.value = true;
    error.value = undefined;

    return new Promise((resolve, reject) => {
      axiosInstance
        .get(endpoint, { params })
        .then((res) => {
          resolve(res.data.data);
        })
        .catch((e) => {
          error.value = e;
          loading.value = false;
          reject(e);
        })
        .finally(() => {
          loading.value = false;
        });
    });
  };

  const post = (payload?: LoginRequest) => {
    loading.value = true
    error.value = undefined

    return new Promise<never>((resolve, reject) => {
      axiosInstance
        .post(endpoint, payload)
        .then((res) => {
          resolve(res.data.data)
        })
        .catch((e) => {
          error.value = e
          loading.value = false
          reject(e)
        })
        .finally(() => {
          loading.value = false
        })
    })
  }

  const put = (payload?: never) => {
    loading.value = true;
    error.value = undefined;

    return new Promise<never>((resolve, reject) => {
      axiosInstance
        .put(endpoint, payload)
        .then((res) => {
          resolve(res.data.data);
        })
        .catch((e) => {
          error.value = e;
          loading.value = false;
          reject(e);
        })
        .finally(() => {
          loading.value = false;
        });
    });
  };

  const del = (payload?: never) => {
    loading.value = true;
    error.value = undefined;

    return new Promise((resolve, reject) => {
      axiosInstance
        .delete(endpoint, { data: payload })
        .then((res) => {
          resolve(res.data.data);
        })
        .catch((e) => {
          error.value = e;
          loading.value = false;
          reject(e);
        })
        .finally(() => {
          loading.value = false;
        });
    });
  };

  return {
    data: data,
    loading,
    error,
    errorMessage,
    errorDetails,
    get,
    post,
    put,
    del,
  };
};

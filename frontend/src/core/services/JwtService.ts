import { CookieHelper } from "@/core/helpers/CookieHelper";

const ID_TOKEN_KEY = "id_token" as string;

/**
 * @description get token form localStorage
 */
export const getToken = (): string | null => {
  return CookieHelper.getCookie(ID_TOKEN_KEY);
};

/**
 * @description save token into localStorage
 * @param token
 */
export const saveToken = (token: string): void => {
  CookieHelper.addCookie(ID_TOKEN_KEY, token);
};

/**
 * @description remove token form localStorage
 */
export const destroyToken = (): void => {
  CookieHelper.removeCookie(ID_TOKEN_KEY);
};

export default { getToken, saveToken, destroyToken };

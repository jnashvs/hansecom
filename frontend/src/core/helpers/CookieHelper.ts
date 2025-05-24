export class CookieHelper {
  static getCookie(name: string): string | null {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) {
      return parts.pop()?.split(';').shift() || null;
    }
    return null;
  }

  static removeCookie(cookieName: string): void {
    document.cookie = `${cookieName}=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/; domain=${import.meta.env.VITE_COOKIE_DOMAIN}`;
    document.cookie = `${cookieName}=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/`;
  }

  static addCookie(name: string, value: string): void {
    const exp = new Date();
    exp.setMonth(exp.getMonth() + 12);

    const cookieValue = encodeURIComponent(value);
    const domain = import.meta.env.VITE_COOKIE_DOMAIN
      ? import.meta.env.VITE_COOKIE_DOMAIN
      : window.location.hostname;

    const cookieString = `${name}=${cookieValue}; expires=${exp.toUTCString()}; path=/; domain=${domain}; SameSite=Lax; Secure`;

    document.cookie = cookieString;
  }
}

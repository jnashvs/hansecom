import { TYPE, useToast } from "vue-toastification";
import "vue-toastification/dist/index.css";

export class NotificationHelper {
  static showError(message: string[]): void {
    const toast = useToast();
    toast.error(message.join("\n"), {
      timeout: 10000,
      type: TYPE.ERROR,
    });
  }

  static showSuccess(message: string): void {
    const toast = useToast();
    toast.success(message, {
      timeout: 10000,
      type: TYPE.SUCCESS,
    });
  }
}

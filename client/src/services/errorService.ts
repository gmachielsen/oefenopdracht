import { useI18n } from "vue-i18n";

export interface ApiError {
  message: string;
  code?: string;
  status?: number;
}

export class ErrorService {
  static handleApiError(error: any): string {
    const { t } = useI18n();

    // Network errors
    if (!error.response) {
      return t("errors.network");
    }

    // HTTP status codes
    switch (error.response?.status) {
      case 401:
        return t("errors.unauthorized");
      case 403:
        return t("errors.forbidden");
      case 404:
        return t("errors.notFound");
      case 422:
        return error.response.data?.message || t("errors.validation");
      case 500:
        return t("errors.server");
      default:
        return error.response.data?.message || t("errors.generic");
    }
  }

  static logError(error: any, context?: string): void {
    console.error(`[${context || "App"}] Error:`, error);

    // In production, send to error tracking service
    if (import.meta.env.PROD) {
      // Example: Sentry, LogRocket, etc.
    }
  }
}

export const errorService = new ErrorService();

import { describe, it, expect, beforeEach, vi } from "vitest";

// Mock localStorage first
const localStorageMock = {
  getItem: vi.fn(),
  setItem: vi.fn(),
  removeItem: vi.fn(),
  clear: vi.fn(),
};

Object.defineProperty(window, "localStorage", {
  value: localStorageMock,
});

// Mock axios - must be defined before any imports
vi.mock("../services/api", () => ({
  default: {
    post: vi.fn(),
    get: vi.fn(),
    put: vi.fn(),
    defaults: {
      headers: {
        common: {} as Record<string, string>,
      },
    },
  },
}));

// Import after mocking
import api from "../services/api";

// Type assertion for the mocked API
const mockApi = api as any;

describe("AuthService", () => {
  let authService: any;

  beforeEach(async () => {
    // Reset mocks before each test
    vi.clearAllMocks();
    localStorageMock.getItem.mockReturnValue(null);

    // Reset the module and reimport to get fresh instance
    vi.resetModules();
    const authModule = await import("../services/authService");
    authService = authModule.authService;
  });

  describe("isAuthenticated", () => {
    it("should return false when no token is stored", () => {
      // Arrange
      localStorageMock.getItem.mockReturnValue(null);

      // Act
      const result = authService.isAuthenticated();

      // Assert
      expect(result).toBe(false);
    });

    it("should return true when token is stored", async () => {
      // Arrange
      localStorageMock.getItem.mockReturnValue("fake-jwt-token");

      // Reset and reimport with token
      vi.resetModules();
      const authModule = await import("../services/authService");
      const freshAuthService = authModule.authService;

      // Act
      const result = freshAuthService.isAuthenticated();

      // Assert
      expect(result).toBe(true);
    });
  });

  describe("getToken", () => {
    it("should return null when no token is stored", () => {
      // Arrange
      localStorageMock.getItem.mockReturnValue(null);

      // Act
      const result = authService.getToken();

      // Assert
      expect(result).toBe(null);
    });

    it("should return token when token is stored", async () => {
      // Arrange
      const mockToken = "fake-jwt-token";
      localStorageMock.getItem.mockReturnValue(mockToken);

      // Reset and reimport with token
      vi.resetModules();
      const authModule = await import("../services/authService");
      const freshAuthService = authModule.authService;

      // Act
      const result = freshAuthService.getToken();

      // Assert
      expect(result).toBe(mockToken);
    });
  });

  describe("logout", () => {
    it("should remove token from localStorage and clear auth header", async () => {
      // Arrange
      mockApi.post.mockResolvedValue({ data: {} });

      // Act
      await authService.logout();

      // Assert
      expect(localStorageMock.removeItem).toHaveBeenCalledWith("auth_token");
      expect(mockApi.defaults.headers.common["Authorization"]).toBeUndefined();
    });

    it("should clear localStorage even if API call fails", async () => {
      // Arrange
      mockApi.post.mockRejectedValue(new Error("Network error"));

      // Act
      await authService.logout();

      // Assert
      expect(localStorageMock.removeItem).toHaveBeenCalledWith("auth_token");
    });
  });
});

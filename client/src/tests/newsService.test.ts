import { describe, it, expect, beforeEach, vi } from "vitest";
import type {
  NewsArticle,
  NewsResponse,
  SingleNewsResponse,
} from "../services/newsService";

// Mock axios
const mockAxios = {
  create: vi.fn(() => ({
    get: vi.fn(),
    post: vi.fn(),
    put: vi.fn(),
    delete: vi.fn(),
  })),
};

vi.mock("axios", () => ({
  default: mockAxios,
}));

describe("NewsService", () => {
  let newsService: any;
  let mockApi: any;

  beforeEach(async () => {
    // Reset mocks
    vi.clearAllMocks();

    // Setup mock API instance
    mockApi = {
      get: vi.fn(),
      post: vi.fn(),
      put: vi.fn(),
      delete: vi.fn(),
    };

    mockAxios.create.mockReturnValue(mockApi);

    // Reset modules and import fresh newsService
    vi.resetModules();
    const newsModule = await import("../services/newsService");
    newsService = newsModule.newsService;
  });

  describe("getNews", () => {
    it("should return array of news articles on successful API call", async () => {
      // Arrange
      const mockNewsData: NewsArticle[] = [
        {
          id: 1,
          title: "Test Article 1",
          description: "Test description 1",
          content: "Test content 1",
          image_url: "https://example.com/image1.jpg",
          published_at: "2025-08-14T10:00:00Z",
          created_at: "2025-08-14T09:00:00Z",
        },
        {
          id: 2,
          title: "Test Article 2",
          description: "Test description 2",
          published_at: "2025-08-13T15:00:00Z",
          created_at: "2025-08-13T14:00:00Z",
        },
      ];

      const mockResponse: NewsResponse = {
        success: true,
        data: mockNewsData,
      };

      mockApi.get.mockResolvedValue({ data: mockResponse });

      // Act
      const result = await newsService.getNews();

      // Assert
      expect(mockApi.get).toHaveBeenCalledWith("/news");
      expect(result).toEqual(mockNewsData);
      expect(result).toHaveLength(2);
      expect(result[0].title).toBe("Test Article 1");
    });

    it("should throw error when API call fails", async () => {
      // Arrange
      const mockError = new Error("Network error");
      mockApi.get.mockRejectedValue(mockError);

      // Act & Assert
      await expect(newsService.getNews()).rejects.toThrow("Network error");
      expect(mockApi.get).toHaveBeenCalledWith("/news");
    });

    it("should log error when API call fails", async () => {
      // Arrange
      const consoleSpy = vi
        .spyOn(console, "error")
        .mockImplementation(() => {});
      const mockError = new Error("API Error");
      mockApi.get.mockRejectedValue(mockError);

      // Act
      try {
        await newsService.getNews();
      } catch (error) {
        // Expected to throw
      }

      // Assert
      expect(consoleSpy).toHaveBeenCalledWith(
        "Error fetching news:",
        mockError
      );
      consoleSpy.mockRestore();
    });
  });

  describe("getNewsById", () => {
    it("should return single news article on successful API call", async () => {
      // Arrange
      const mockNewsArticle: NewsArticle = {
        id: 1,
        title: "Detailed Article",
        description: "Detailed description",
        content: "Full article content here...",
        image_url: "https://example.com/detailed-image.jpg",
        published_at: "2025-08-14T10:00:00Z",
        created_at: "2025-08-14T09:00:00Z",
      };

      const mockResponse: SingleNewsResponse = {
        success: true,
        data: mockNewsArticle,
      };

      mockApi.get.mockResolvedValue({ data: mockResponse });

      // Act
      const result = await newsService.getNewsById(1);

      // Assert
      expect(mockApi.get).toHaveBeenCalledWith("/news/1");
      expect(result).toEqual(mockNewsArticle);
      expect(result.id).toBe(1);
      expect(result.title).toBe("Detailed Article");
    });

    it("should throw error when API call fails", async () => {
      // Arrange
      const mockError = new Error("Article not found");
      mockApi.get.mockRejectedValue(mockError);

      // Act & Assert
      await expect(newsService.getNewsById(999)).rejects.toThrow(
        "Article not found"
      );
      expect(mockApi.get).toHaveBeenCalledWith("/news/999");
    });

    it("should log error when API call fails", async () => {
      // Arrange
      const consoleSpy = vi
        .spyOn(console, "error")
        .mockImplementation(() => {});
      const mockError = new Error("404 Not Found");
      mockApi.get.mockRejectedValue(mockError);

      // Act
      try {
        await newsService.getNewsById(404);
      } catch (error) {
        // Expected to throw
      }

      // Assert
      expect(consoleSpy).toHaveBeenCalledWith(
        "Error fetching news article:",
        mockError
      );
      consoleSpy.mockRestore();
    });
  });

  describe("formatDate", () => {
    it("should format date string to Dutch locale", () => {
      // Arrange
      const dateString = "2025-08-14T10:30:00Z";

      // Act
      const result = newsService.formatDate(dateString);

      // Assert
      expect(result).toBe("14 augustus 2025");
    });

    it("should format different date correctly", () => {
      // Arrange
      const dateString = "2024-12-25T00:00:00Z";

      // Act
      const result = newsService.formatDate(dateString);

      // Assert
      expect(result).toBe("25 december 2024");
    });

    it("should handle invalid date string", () => {
      // Arrange
      const invalidDate = "invalid-date";

      // Act
      const result = newsService.formatDate(invalidDate);

      // Assert
      expect(result).toBe("Invalid Date");
    });
  });

  describe("truncateText", () => {
    it("should return original text if within limit", () => {
      // Arrange
      const text = "Short text";

      // Act
      const result = newsService.truncateText(text, 150);

      // Assert
      expect(result).toBe("Short text");
    });

    it("should truncate text if exceeds limit", () => {
      // Arrange
      const longText =
        "This is a very long text that should be truncated because it exceeds the maximum length limit that we have set for this particular function test case.";

      // Act
      const result = newsService.truncateText(longText, 50);

      // Assert
      expect(result).toBe(
        "This is a very long text that should be truncated ..."
      );
      expect(result.length).toBe(53); // 50 chars + '...'
    });

    it("should use default max length of 150 when not specified", () => {
      // Arrange
      const longText = "A".repeat(200); // 200 'A' characters

      // Act
      const result = newsService.truncateText(longText);

      // Assert
      expect(result.length).toBe(153); // 150 chars + '...'
      expect(result.endsWith("...")).toBe(true);
    });

    it("should return exact text if exactly at limit", () => {
      // Arrange
      const exactText = "A".repeat(150);

      // Act
      const result = newsService.truncateText(exactText, 150);

      // Assert
      expect(result).toBe(exactText);
      expect(result.length).toBe(150);
    });
  });
});

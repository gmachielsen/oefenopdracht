import axios from "axios";

const API_BASE_URL = "http://localhost:8000/api";

export interface NewsArticle {
  id: number;
  title: string;
  description: string;
  content?: string;
  image_url?: string;
  published_at: string;
  created_at: string;
}

export interface NewsResponse {
  success: boolean;
  data: NewsArticle[];
}

export interface SingleNewsResponse {
  success: boolean;
  data: NewsArticle;
}

class NewsService {
  private api = axios.create({
    baseURL: API_BASE_URL,
  });

  async getNews(): Promise<NewsArticle[]> {
    try {
      const response = await this.api.get<NewsResponse>("/news");
      return response.data.data;
    } catch (error) {
      console.error("Error fetching news:", error);
      throw error;
    }
  }

  async getNewsById(id: number): Promise<NewsArticle> {
    try {
      const response = await this.api.get<SingleNewsResponse>(`/news/${id}`);
      return response.data.data;
    } catch (error) {
      console.error("Error fetching news article:", error);
      throw error;
    }
  }

  formatDate(dateString: string): string {
    return new Date(dateString).toLocaleDateString("nl-NL", {
      year: "numeric",
      month: "long",
      day: "numeric",
    });
  }

  truncateText(text: string, maxLength: number = 150): string {
    if (text.length <= maxLength) return text;
    return text.substr(0, maxLength) + "...";
  }
}

export const newsService = new NewsService();

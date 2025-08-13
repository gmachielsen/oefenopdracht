import api from "./api";

export interface LoginCredentials {
  email: string;
  password: string;
}

export interface User {
  id: number;
  name: string;
  first_name: string | null;
  last_name: string | null;
  email: string;
  email_verified_at: string | null;
  birth_date: string | null;
  profile_photo: string | null;
}

export interface UpdateProfileData {
  first_name?: string;
  last_name?: string;
  email?: string;
  birth_date?: string;
  profile_photo?: string;
}

export interface AuthResponse {
  access_token: string;
  token_type: string;
  expires_in: number;
  user: User;
}

class AuthService {
  private token: string | null = null;

  constructor() {
    this.token = localStorage.getItem("auth_token");
    if (this.token) {
      this.setAuthHeader();
    }
  }

  async login(credentials: LoginCredentials): Promise<AuthResponse> {
    const response = await api.post("/login", credentials);
    const authData = response.data;

    this.token = authData.access_token;
    localStorage.setItem("auth_token", this.token!);
    this.setAuthHeader();

    return authData;
  }

  async logout(): Promise<void> {
    try {
      await api.post("/logout");
    } catch (error) {
      // Continue with logout even if API call fails
    } finally {
      this.token = null;
      localStorage.removeItem("auth_token");
      this.removeAuthHeader();
    }
  }

  async getUser(): Promise<User> {
    const response = await api.get("/me");
    return response.data;
  }

  async refreshToken(): Promise<AuthResponse> {
    const response = await api.post("/refresh");
    const authData = response.data;

    this.token = authData.access_token;
    localStorage.setItem("auth_token", this.token!);
    this.setAuthHeader();

    return authData;
  }

  async updateProfile(profileData: UpdateProfileData): Promise<User> {
    const response = await api.put("/profile", profileData);
    return response.data.user;
  }

  async uploadProfilePhoto(file: File): Promise<string> {
    return new Promise((resolve, reject) => {
      const reader = new FileReader();
      reader.onload = () => {
        const base64String = reader.result as string;
        resolve(base64String);
      };
      reader.onerror = () => {
        reject(new Error("Fout bij het lezen van het bestand"));
      };
      reader.readAsDataURL(file);
    });
  }

  isAuthenticated(): boolean {
    return this.token !== null;
  }

  getToken(): string | null {
    return this.token;
  }

  private setAuthHeader(): void {
    if (this.token) {
      api.defaults.headers.common["Authorization"] = `Bearer ${this.token}`;
    }
  }

  private removeAuthHeader(): void {
    delete api.defaults.headers.common["Authorization"];
  }
}

export const authService = new AuthService();

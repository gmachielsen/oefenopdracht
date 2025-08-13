import api from "./api";

export interface Example {
  id?: number;
  name: string;
  email: string;
  created_at?: string;
}

export const exampleService = {
  // Get all examples
  getAll: async () => {
    const response = await api.get("/examples");
    return response.data;
  },

  // Get example by ID
  getById: async (id: number) => {
    const response = await api.get(`/examples/${id}`);
    return response.data;
  },

  // Create new example
  create: async (data: Omit<Example, "id" | "created_at">) => {
    const response = await api.post("/examples", data);
    return response.data;
  },

  // Update example
  update: async (id: number, data: Partial<Example>) => {
    const response = await api.put(`/examples/${id}`, data);
    return response.data;
  },

  // Delete example
  delete: async (id: number) => {
    const response = await api.delete(`/examples/${id}`);
    return response.data;
  },

  // Test API connection
  testConnection: async () => {
    const response = await api.get("/test");
    return response.data;
  },
};

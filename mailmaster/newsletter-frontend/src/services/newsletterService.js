// src/services/newsletterService.js
import axiosInstance from '../api/axiosInstance';

const newsletterService = {
  getAll: () => axiosInstance.get('/newsletters'),
  getById: (id) => axiosInstance.get(`/newsletters/${id}`),
  create: (data) => axiosInstance.post('/newsletters', data),
  update: (id, data) => axiosInstance.put(`/newsletters/${id}`, data),
  delete: (id) => axiosInstance.delete(`/newsletters/${id}`),
};

export default newsletterService;
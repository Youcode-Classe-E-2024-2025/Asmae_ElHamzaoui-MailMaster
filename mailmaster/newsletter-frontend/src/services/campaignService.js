// src/services/campaignService.js
import axiosInstance from '../api/axiosInstance';

const campaignService = {
  getAll: () => axiosInstance.get('/campaigns'),
  getById: (id) => axiosInstance.get(`/campaigns/${id}`),
  create: (data) => axiosInstance.post('/campaigns', data),
  update: (id, data) => axiosInstance.put(`/campaigns/${id}`, data),
  delete: (id) => axiosInstance.delete(`/campaigns/${id}`),
};

export default campaignService;
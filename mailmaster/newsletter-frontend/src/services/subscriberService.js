// src/services/subscriberService.js
import axiosInstance from '../api/axiosInstance';

const subscriberService = {
  getAll: () => axiosInstance.get('/subscribers'),
  getById: (id) => axiosInstance.get(`/subscribers/${id}`), // Attention: l'API utilise {subscriber} mais l'ID est passé
  create: (data) => axiosInstance.post('/subscribers', data),
  update: (id, data) => axiosInstance.put(`/subscribers/${id}`, data), // Attention: l'API utilise {subscriber}
  delete: (id) => axiosInstance.delete(`/subscribers/${id}`), // Attention: l'API utilise {subscriber}
};

export default subscriberService;
// src/api/axiosInstance.js
import axios from 'axios';

// Récupérez l'URL de base de votre API depuis les variables d'environnement
// Ou définissez-la directement ici pour le développement
const API_BASE_URL = process.env.REACT_APP_API_URL || 'http://localhost:8000/api'; // Ajustez si nécessaire

const axiosInstance = axios.create({
  baseURL: API_BASE_URL,
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  },
});

// Intercepteur pour ajouter le token d'authentification à chaque requête
axiosInstance.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem('authToken'); // Ou récupérez le token depuis votre state management
    if (token) {
      config.headers['Authorization'] = `Bearer ${token}`;
    }
    return config;
  },
  (error) => {
    return Promise.reject(error);
  }
);

// Optionnel : Intercepteur pour gérer les erreurs globales (ex: 401 Unauthorized)
axiosInstance.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response && error.response.status === 401) {
      // Ex: Déconnecter l'utilisateur, rediriger vers la page de connexion
      console.error("Unauthorized! Redirecting to login.");
      localStorage.removeItem('authToken'); // Nettoyer le token
      // Redirection (si vous utilisez react-router-dom history ou un hook de navigation)
      // window.location.href = '/login'; // Solution simple mais recharge la page
    }
    return Promise.reject(error);
  }
);


export default axiosInstance;
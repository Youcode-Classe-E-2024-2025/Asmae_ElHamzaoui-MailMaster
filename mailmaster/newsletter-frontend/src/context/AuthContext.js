// src/context/AuthContext.js
import React, { createContext, useState, useContext, useEffect } from 'react';
import axiosInstance from '../api/axiosInstance';

const AuthContext = createContext(null);

export const AuthProvider = ({ children }) => {
  const [token, setToken] = useState(localStorage.getItem('authToken'));
  const [user, setUser] = useState(null); // Optionnel: stocker les infos utilisateur
  const [loading, setLoading] = useState(true); // Pour savoir si l'état initial est chargé

  useEffect(() => {
    const storedToken = localStorage.getItem('authToken');
    if (storedToken) {
      setToken(storedToken);
      // Optionnel: Tenter de récupérer les infos utilisateur si le token existe
      // fetchUser(); // Vous pouvez créer une fonction fetchUser qui appelle une route /api/user par exemple
    }
    setLoading(false); // Fin du chargement initial
  }, []);

  const login = async (credentials) => {
    try {
      const response = await axiosInstance.post('/login', credentials);
      const { token: receivedToken, user: userData } = response.data; // Adaptez selon la structure de votre réponse API login
      localStorage.setItem('authToken', receivedToken);
      setToken(receivedToken);
      setUser(userData); // Stockez les infos utilisateur si retournées
      return true; // Succès
    } catch (error) {
      console.error("Login failed:", error.response?.data || error.message);
      // Gérer les erreurs (ex: afficher un message)
      return false; // Échec
    }
  };

  const register = async (userData) => {
    try {
      await axiosInstance.post('/register', userData);
      // Peut-être rediriger vers le login ou connecter directement si l'API retourne un token
      return true; // Succès
    } catch (error) {
      console.error("Registration failed:", error.response?.data || error.message);
      // Gérer les erreurs de validation etc.
      return false; // Échec
    }
  };


  const logout = async () => {
    try {
       // Appeler l'API de déconnexion (important côté serveur pour invalider le token si nécessaire)
       await axiosInstance.post('/logout');
    } catch (error) {
        console.error("Logout API call failed:", error.response?.data || error.message);
        // Gérer l'erreur, mais procéder à la déconnexion côté client quand même
    } finally {
        localStorage.removeItem('authToken');
        setToken(null);
        setUser(null);
        // Rediriger vers la page de connexion
        window.location.href = '/login'; // Ou utiliser useNavigate de react-router-dom
    }
  };

  const value = {
    token,
    user,
    isAuthenticated: !!token,
    loading,
    login,
    register,
    logout,
  };

  return (
    <AuthContext.Provider value={value}>
      {!loading && children} {/* Ne rendre les enfants qu'une fois le chargement initial terminé */}
    </AuthContext.Provider>
  );
};

export const useAuth = () => {
  return useContext(AuthContext);
};
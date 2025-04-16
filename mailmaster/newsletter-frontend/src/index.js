// src/index.js ou src/main.jsx
import React from 'react';
import ReactDOM from 'react-dom/client';
import App from './App';
import { BrowserRouter } from 'react-router-dom';
import { AuthProvider } from './context/AuthContext'; // Importez AuthProvider
import './index.css'; // Ou votre fichier CSS principal

const root = ReactDOM.createRoot(document.getElementById('root'));
root.render(
  <React.StrictMode>
    <BrowserRouter> {/* Le Router doit englober AuthProvider si AuthProvider utilise des hooks de routage */}
      <AuthProvider> {/* Enveloppez App avec AuthProvider */}
        <App />
      </AuthProvider>
    </BrowserRouter>
  </React.StrictMode>
);
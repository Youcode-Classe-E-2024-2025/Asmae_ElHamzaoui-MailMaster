// src/App.js
import React from 'react';
import { Routes, Route, Link, useNavigate } from 'react-router-dom';
import { useAuth } from './context/AuthContext';

import LoginPage from './pages/LoginPage';
import RegisterPage from './pages/RegisterPage';
import HomePage from './pages/HomePage'; // À créer
import CampaignsPage from './pages/CampaignsPage'; // À créer
import NewslettersPage from './pages/NewslettersPage'; // À créer
import SubscribersPage from './pages/SubscribersPage'; // À créer
// Importez d'autres pages (détail, création, édition) si nécessaire

import ProtectedRoute from './components/ProtectedRoute';

function App() {
  const { isAuthenticated, logout } = useAuth();
  const navigate = useNavigate();

  const handleLogout = () => {
    logout();
    // La redirection est gérée dans la fonction logout du contexte
  };

  return (
    <div>
      <nav> {/* Barre de navigation simple */}
        <ul>
          <li><Link to="/">Accueil</Link></li>
          {isAuthenticated ? (
            <>
              <li><Link to="/campaigns">Campagnes</Link></li>
              <li><Link to="/newsletters">Newsletters</Link></li>
              <li><Link to="/subscribers">Abonnés</Link></li>
              <li><button onClick={handleLogout}>Déconnexion</button></li>
            </>
          ) : (
            <>
              <li><Link to="/login">Connexion</Link></li>
              <li><Link to="/register">Inscription</Link></li>
            </>
          )}
        </ul>
      </nav>

      <hr />

      <Routes>
        {/* Routes publiques */}
        <Route path="/login" element={<LoginPage />} />
        <Route path="/register" element={<RegisterPage />} />

        {/* Routes protégées */}
        <Route element={<ProtectedRoute />}>
          <Route path="/" element={<HomePage />} />
          <Route path="/campaigns" element={<CampaignsPage />} />
          {/* Ajoutez ici les routes pour voir/créer/éditer les campagnes si besoin */}
          {/* <Route path="/campaigns/create" element={<CampaignCreatePage />} /> */}
          {/* <Route path="/campaigns/:id" element={<CampaignDetailPage />} /> */}
          {/* <Route path="/campaigns/:id/edit" element={<CampaignEditPage />} /> */}

          <Route path="/newsletters" element={<NewslettersPage />} />
          {/* Routes CRUD pour Newsletters */}

          <Route path="/subscribers" element={<SubscribersPage />} />
          {/* Routes CRUD pour Subscribers */}
        </Route>

        {/* Route par défaut ou 404 */}
        <Route path="*" element={<div>404 Not Found</div>} />
      </Routes>
    </div>
  );
}

export default App;
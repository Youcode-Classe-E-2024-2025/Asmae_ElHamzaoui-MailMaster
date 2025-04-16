// src/pages/HomePage.js
import React from 'react';
import { useAuth } from '../context/AuthContext';

function HomePage() {
  const { user } = useAuth(); // Récupère les infos utilisateur si stockées

  return (
    <div>
      <h1>Bienvenue !</h1>
      {user && <p>Connecté en tant que : {user.name || user.email}</p>}
      <p>Ceci est la page d'accueil de votre application.</p>
      <p>Utilisez la navigation pour accéder aux différentes sections.</p>
    </div>
  );
}

export default HomePage;
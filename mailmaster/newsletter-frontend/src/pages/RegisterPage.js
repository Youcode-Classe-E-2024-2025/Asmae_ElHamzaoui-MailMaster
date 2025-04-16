// src/pages/RegisterPage.js
import React, { useState } from 'react';
import { useAuth } from '../context/AuthContext';
import { useNavigate, Link } from 'react-router-dom';

function RegisterPage() {
  const [name, setName] = useState('');
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [passwordConfirmation, setPasswordConfirmation] = useState('');
  const [role, setRole] = useState('client'); // Valeur par défaut
  const [error, setError] = useState('');
  const [success, setSuccess] = useState('');
  const { register } = useAuth(); // Utilisez la fonction register du contexte
  const navigate = useNavigate();

  const handleSubmit = async (e) => {
    e.preventDefault();
    setError('');
    setSuccess('');

    if (password !== passwordConfirmation) {
      setError("Les mots de passe ne correspondent pas.");
      return;
    }

    const userData = {
      name,
      email,
      password,
      password_confirmation: passwordConfirmation,
      role,
    };

    const registered = await register(userData);

    if (registered) {
      setSuccess("Inscription réussie ! Vous pouvez maintenant vous connecter.");
      // Optionnel: rediriger automatiquement vers le login après un délai
      setTimeout(() => navigate('/login'), 2000);
    } else {
      // L'erreur spécifique devrait être gérée dans la fonction register du contexte
      // ou retournée pour affichage ici.
      setError("Erreur lors de l'inscription. Vérifiez les informations fournies.");
    }
  };

  return (
    <div>
      <h2>Inscription</h2>
      <form onSubmit={handleSubmit}>
        <div>
          <label>Nom:</label>
          <input type="text" value={name} onChange={(e) => setName(e.target.value)} required />
        </div>
        <div>
          <label>Email:</label>
          <input type="email" value={email} onChange={(e) => setEmail(e.target.value)} required />
        </div>
        <div>
          <label>Mot de passe:</label>
          <input type="password" value={password} onChange={(e) => setPassword(e.target.value)} required minLength="8" />
        </div>
        <div>
          <label>Confirmer Mot de passe:</label>
          <input type="password" value={passwordConfirmation} onChange={(e) => setPasswordConfirmation(e.target.value)} required />
        </div>
        <div>
          <label>Rôle:</label>
          <select value={role} onChange={(e) => setRole(e.target.value)} required>
            <option value="client">Client</option>
            <option value="agent">Agent</option>
             {/* Peut-être masquer l'option admin */}
            <option value="admin">Admin</option>
          </select>
        </div>
        {error && <p style={{ color: 'red' }}>{error}</p>}
        {success && <p style={{ color: 'green' }}>{success}</p>}
        <button type="submit">S'inscrire</button>
      </form>
       <p>Déjà un compte ? <Link to="/login">Connectez-vous</Link></p>
    </div>
  );
}

export default RegisterPage;
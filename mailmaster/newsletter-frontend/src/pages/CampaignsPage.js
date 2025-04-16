// src/pages/CampaignsPage.js
import React, { useState, useEffect } from 'react';
import campaignService from '../services/campaignService';
import { Link } from 'react-router-dom'; // Pour les liens vers création/détail

function CampaignsPage() {
  const [campaigns, setCampaigns] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState('');

  useEffect(() => {
    fetchCampaigns();
  }, []);

  const fetchCampaigns = async () => {
    setLoading(true);
    setError('');
    try {
      const response = await campaignService.getAll();
      setCampaigns(response.data); // Assurez-vous que response.data contient le tableau
    } catch (err) {
      console.error("Failed to fetch campaigns:", err);
      setError("Impossible de charger les campagnes.");
    } finally {
      setLoading(false);
    }
  };

  const handleDelete = async (id) => {
     if (window.confirm("Êtes-vous sûr de vouloir supprimer cette campagne ?")) {
         try {
             await campaignService.delete(id);
             // Rafraîchir la liste après suppression
             fetchCampaigns();
             // Ou filtrer localement : setCampaigns(campaigns.filter(c => c.id !== id));
         } catch (err) {
             console.error("Failed to delete campaign:", err);
             setError("Erreur lors de la suppression de la campagne.");
         }
     }
  };


  if (loading) return <div>Chargement des campagnes...</div>;
  if (error) return <div style={{ color: 'red' }}>{error}</div>;

  return (
    <div>
      <h2>Liste des Campagnes</h2>
      {/* <Link to="/campaigns/create">Créer une nouvelle campagne</Link> */} {/* Décommentez quand la page de création existe */}
      {campaigns.length === 0 ? (
        <p>Aucune campagne trouvée.</p>
      ) : (
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Newsletter ID</th>
              <th>Date Planifiée</th>
              <th>Statut (Exemple)</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            {campaigns.map((campaign) => (
              <tr key={campaign.id}>
                <td>{campaign.id}</td>
                <td>{campaign.newsletter_id}</td>
                <td>{new Date(campaign.scheduled_at).toLocaleString()}</td>
                <td>{campaign.status || 'N/A'}</td> {/* Ajoutez le statut si votre API le renvoie */}
                <td>
                  {/* <Link to={`/campaigns/${campaign.id}`}>Voir</Link> | */}
                  {/* <Link to={`/campaigns/${campaign.id}/edit`}>Modifier</Link> | */}
                  <button onClick={() => handleDelete(campaign.id)}>Supprimer</button>
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      )}
    </div>
  );
}

export default CampaignsPage;
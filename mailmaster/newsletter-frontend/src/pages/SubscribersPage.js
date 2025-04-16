import React, { useState, useEffect } from 'react';
import subscriberService from '../services/subscriberService'; // Assurez-vous que ce service existe
import { Link } from 'react-router-dom';

function SubscribersPage() {
  const [subscribers, setSubscribers] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState('');

  useEffect(() => {
    fetchSubscribers();
  }, []);

  const fetchSubscribers = async () => {
    setLoading(true);
    setError('');
    try {
      const response = await subscriberService.getAll();
      setSubscribers(response.data); // Adaptez si nécessaire
    } catch (err) {
      console.error("Failed to fetch subscribers:", err);
      setError("Impossible de charger les abonnés.");
    } finally {
      setLoading(false);
    }
  };

  const handleDelete = async (id) => {
     if (window.confirm("Êtes-vous sûr de vouloir supprimer cet abonné ?")) {
         try {
             // Attention : L'API utilise {subscriber} dans l'URL, mais le service attend un ID.
             // Assurez-vous que subscriberService.delete gère correctement l'appel à /subscribers/{id}
             await subscriberService.delete(id);
             fetchSubscribers(); // Recharger la liste
         } catch (err) {
             console.error("Failed to delete subscriber:", err);
             setError("Erreur lors de la suppression de l'abonné.");
         }
     }
  };

  if (loading) return <div>Chargement des abonnés...</div>;
  if (error) return <div style={{ color: 'red' }}>{error}</div>;

  return (
    <div>
      <h2>Liste des Abonnés</h2>
       {/* <Link to="/subscribers/create">Ajouter un abonné</Link> */} {/* Si vous ajoutez un formulaire */}
       {subscribers.length === 0 ? (
          <p>Aucun abonné trouvé.</p>
       ) : (
          <table>
             <thead>
               <tr>
                 <th>ID</th>
                 <th>Email</th>
                 <th>Nom</th>
                 <th>Actions</th>
               </tr>
             </thead>
             <tbody>
               {subscribers.map((subscriber) => (
                 <tr key={subscriber.id}>
                   <td>{subscriber.id}</td>
                   <td>{subscriber.email}</td>
                   <td>{subscriber.name || 'N/A'}</td>
                   <td>
                     {/* <Link to={`/subscribers/${subscriber.id}`}>Voir</Link> | */}
                     {/* <Link to={`/subscribers/${subscriber.id}/edit`}>Modifier</Link> | */}
                     <button onClick={() => handleDelete(subscriber.id)}>Supprimer</button>
                   </td>
                 </tr>
               ))}
             </tbody>
           </table>
       )}
    </div>
  );
}

export default SubscribersPage;
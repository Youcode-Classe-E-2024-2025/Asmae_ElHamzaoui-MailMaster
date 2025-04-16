import React, { useState, useEffect } from 'react';
import newsletterService from '../services/newsletterService'; // Assurez-vous que ce service existe
import { Link } from 'react-router-dom';

function NewslettersPage() {
  const [newsletters, setNewsletters] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState('');

  useEffect(() => {
    fetchNewsletters();
  }, []);

  const fetchNewsletters = async () => {
    setLoading(true);
    setError('');
    try {
      const response = await newsletterService.getAll();
      setNewsletters(response.data); // Adaptez si la structure de la réponse est différente
    } catch (err) {
      console.error("Failed to fetch newsletters:", err);
      setError("Impossible de charger les newsletters.");
    } finally {
      setLoading(false);
    }
  };

   const handleDelete = async (id) => {
     if (window.confirm("Êtes-vous sûr de vouloir supprimer cette newsletter ?")) {
         try {
             await newsletterService.delete(id);
             fetchNewsletters(); // Recharger la liste
         } catch (err) {
             console.error("Failed to delete newsletter:", err);
             setError("Erreur lors de la suppression de la newsletter.");
         }
     }
  };

  if (loading) return <div>Chargement des newsletters...</div>;
  if (error) return <div style={{ color: 'red' }}>{error}</div>;

  return (
    <div>
      <h2>Liste des Newsletters</h2>
      <Link to="/newsletters/create">Créer une nouvelle newsletter</Link>
      {/* Ajoutez ici le code pour afficher la liste (tableau, etc.) */}
      {newsletters.length === 0 ? (
          <p>Aucune newsletter trouvée.</p>
      ) : (
        <table>
           <thead>
             <tr>
               <th>ID</th>
               <th>Titre</th>
               {/* <th>Contenu (extrait)</th> */}
               <th>Actions</th>
             </tr>
           </thead>
           <tbody>
             {newsletters.map((newsletter) => (
               <tr key={newsletter.id}>
                 <td>{newsletter.id}</td>
                 <td>{newsletter.title}</td>
                 {/* <td>{newsletter.content.substring(0, 50)}...</td> */}
                 <td>
                   {/* <Link to={`/newsletters/${newsletter.id}`}>Voir</Link> | */}
                   {/* <Link to={`/newsletters/${newsletter.id}/edit`}>Modifier</Link> | */}
                   <button onClick={() => handleDelete(newsletter.id)}>Supprimer</button>
                 </td>
               </tr>
             ))}
           </tbody>
         </table>
      )}
    </div>
  );
}

export default NewslettersPage;
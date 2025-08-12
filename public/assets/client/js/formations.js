// Fonction pour récupérer les sessions depuis le backend
async function fetchFormations() {
  try {
    const response = await fetch('/api/sessions', {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
      },
    });

    if (!response.ok) {
      throw new Error('Erreur lors de la récupération des sessions');
    }

    const data = await response.json();
    return data.sessions; // Retourne la liste des sessions
  } catch (error) {
    console.error('Erreur:', error);
    return []; // Retourne un tableau vide en cas d'erreur
  }
}

// Export pour utilisation dans d'autres fichiers
window.fetchFormations = fetchFormations;

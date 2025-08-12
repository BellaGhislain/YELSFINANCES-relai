// --- Données simulées ---
const formations = [
  { id: 1, title: 'Développement Web', sessionStart: '2024-07-01', sessionEnd: '2024-08-01', location: 'Paris, France', mode: 'Présentiel', amount: 50000, duration: '4 semaines' },
  { id: 2, title: 'Marketing Digital', sessionStart: '2024-07-10', sessionEnd: '2024-08-10', location: 'En ligne', mode: 'En ligne', amount: 40000, duration: '4 semaines' },
  { id: 3, title: 'Data Science', sessionStart: '2024-08-01', sessionEnd: '2024-09-01', location: 'Lyon, France', mode: 'Présentiel', amount: 60000, duration: '4 semaines' },
  { id: 4, title: 'Design', sessionStart: '2024-08-15', sessionEnd: '2024-09-15', location: 'En ligne', mode: 'En ligne', amount: 35000, duration: '4 semaines' },
];

const subscriptions = [
  { name: 'Alice Dupont', email: 'alice@mail.com', formationId: 1, session: '2024-07-01 - 2024-08-01', date: '2024-06-10' },
  { name: 'Bob Martin', email: 'bob@mail.com', formationId: 2, session: '2024-07-10 - 2024-08-10', date: '2024-06-12' },
  { name: 'Claire Nguema', email: 'claire@mail.com', formationId: 3, session: '2024-08-01 - 2024-09-01', date: '2024-06-15' },
];

// --- Affichage des souscriptions ---
function renderSubscriptions() {
  const tbody = document.querySelector('#subscriptionsTable tbody');
  tbody.innerHTML = '';
  subscriptions.forEach(sub => {
    const formation = formations.find(f => f.id === sub.formationId);
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td>${sub.name}</td>
      <td>${sub.email}</td>
      <td>${formation ? formation.title : 'Inconnu'}</td>
      <td>${sub.session}</td>
      <td>${sub.date}</td>
    `;
    tbody.appendChild(tr);
  });
}

// --- Affichage des formations (sessions & montants) ---
function renderFormations() {
  const tbody = document.querySelector('#formationsTable tbody');
  tbody.innerHTML = '';
  formations.forEach((formation, idx) => {
    const tr = document.createElement('tr');
    tr.innerHTML = `
      <td>${formation.title}</td>
      <td>
        <form class="form-inline" onsubmit="return false;">
          <input type="date" value="${formation.sessionStart}" data-idx="${idx}" class="session-start-input">
        </form>
      </td>
      <td>
        <form class="form-inline" onsubmit="return false;">
          <input type="date" value="${formation.sessionEnd}" data-idx="${idx}" class="session-end-input">
        </form>
      </td>

      <td>
        <form class="form-inline" onsubmit="return false;">
          <input type="text" value="${formation.location}" data-idx="${idx}" class="location-input" placeholder="Lieu de formation">
        </form>
      </td>
      <td>
        <form class="form-inline" onsubmit="return false;">
          <select data-idx="${idx}" class="mode-input">
            <option value="Présentiel" ${formation.mode === 'Présentiel' ? 'selected' : ''}>Présentiel</option>
            <option value="En ligne" ${formation.mode === 'En ligne' ? 'selected' : ''}>En ligne</option>
          </select>
        </form>
      </td>
      <td>
        <form class="form-inline" onsubmit="return false;">
          <input type="number" min="0" value="${formation.amount}" data-idx="${idx}" class="amount-input">
        </form>
      </td>
      <td>
        <button class="btn-admin" data-idx="${idx}" onclick="saveFormation(${idx})">Enregistrer</button>
      </td>
    `;
    tbody.appendChild(tr);
  });
}

// --- Calcul du nombre de semaines ---
function calculateWeeks(startDate, endDate) {
  const start = new Date(startDate);
  const end = new Date(endDate);
  const diffTime = Math.abs(end - start);
  const diffWeeks = Math.ceil(diffTime / (1000 * 60 * 60 * 24 * 7));
  return diffWeeks;
}

// --- Sauvegarde des modifications ---
window.saveFormation = function(idx) {
  const sessionStartInput = document.querySelector(`input.session-start-input[data-idx='${idx}']`);
  const sessionEndInput = document.querySelector(`input.session-end-input[data-idx='${idx}']`);
  const locationInput = document.querySelector(`input.location-input[data-idx='${idx}']`);
  const modeInput = document.querySelector(`select.mode-input[data-idx='${idx}']`);
  const amountInput = document.querySelector(`input.amount-input[data-idx='${idx}']`);
  
  if (sessionStartInput && sessionEndInput && locationInput && modeInput && amountInput) {
    // Validation des dates
    if (sessionStartInput.value >= sessionEndInput.value) {
      alert('La date de fin doit être postérieure à la date de début !');
      return;
    }
    
    // Validation du lieu
    if (!locationInput.value.trim()) {
      alert('Le lieu de formation est obligatoire !');
      return;
    }
    
    // Calcul du nombre de semaines
    const weeks = calculateWeeks(sessionStartInput.value, sessionEndInput.value);
    
    formations[idx].sessionStart = sessionStartInput.value;
    formations[idx].sessionEnd = sessionEndInput.value;
    formations[idx].location = locationInput.value.trim();
    formations[idx].mode = modeInput.value;
    formations[idx].amount = parseInt(amountInput.value, 10);
    formations[idx].duration = `${weeks} semaine${weeks > 1 ? 's' : ''}`;
    
    // Mettre à jour les souscriptions avec la nouvelle session
    subscriptions.forEach(sub => {
      if (sub.formationId === formations[idx].id) {
        sub.session = `${formations[idx].sessionStart} - ${formations[idx].sessionEnd}`;
      }
    });
    
    alert(`Formation mise à jour : ${formations[idx].title}\nDurée calculée : ${weeks} semaine${weeks > 1 ? 's' : ''}`);
    renderFormations();
    renderSubscriptions();
  }
};

// --- Initialisation ---
document.addEventListener('DOMContentLoaded', () => {
  renderSubscriptions();
  renderFormations();
}); 
// Variables globales
let currentFilter = 'all';
let searchTerm = '';

// DOM Content Loaded
document.addEventListener('DOMContentLoaded', function() {
  initializeApp();
});

function initializeApp() {
  setupEventListeners();
  renderFormations();
  setupScrollEffects();
}

function setupEventListeners() {
  // Navigation mobile - Sidebar
  const mobileMenuBtn = document.getElementById('mobileMenuBtn');
  const mobileSidebarClose = document.getElementById('mobileSidebarClose');
  const mobileSidebarOverlay = document.getElementById('mobileSidebarOverlay');
  
  if (mobileMenuBtn) {
    mobileMenuBtn.addEventListener('click', toggleMobileSidebar);
  }
  
  if (mobileSidebarClose) {
    mobileSidebarClose.addEventListener('click', closeMobileSidebar);
  }
  
  if (mobileSidebarOverlay) {
    mobileSidebarOverlay.addEventListener('click', closeMobileSidebar);
  }

  // Recherche
  const searchInput = document.getElementById('searchInput');
  const searchInputMobile = document.getElementById('searchInputMobile');
  
  if (searchInput) {
    searchInput.addEventListener('input', handleSearch);
  }
  
  if (searchInputMobile) {
    searchInputMobile.addEventListener('input', handleSearch);
  }

  // Filtres
  const filterBtns = document.querySelectorAll('.filter-btn');
  filterBtns.forEach(btn => {
    btn.addEventListener('click', () => handleFilter(btn.dataset.category));
  });

  // Panier
  const cartBtn = document.getElementById('cartBtn');
  const cartBtnMobile = document.getElementById('cartBtnMobile');
  
  if (cartBtn) {
    cartBtn.addEventListener('click', openCartModal);
  }
  
  if (cartBtnMobile) {
    cartBtnMobile.addEventListener('click', () => {
      openCartModal();
      // Fermer la sidebar mobile après avoir cliqué sur le panier
      closeMobileSidebar();
    });
  }
  
  // Gérer le panier mobile dans la navigation
  const cartBtnMobileNav = document.getElementById('cartBtnMobile');
  if (cartBtnMobileNav) {
    cartBtnMobileNav.addEventListener('click', openCartModal);
  }

  // Modals
  setupModalListeners();

  // Navigation smooth scroll
  setupSmoothScroll();

  // Hero buttons
  setupHeroButtons();

  // Gestion de la touche Échap pour arrêter la vidéo et fermer le menu mobile
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      const formationModal = document.getElementById('formationModal');
      if (formationModal && formationModal.classList.contains('active')) {
        closeFormationModal();
      }
      
      // Fermer la sidebar mobile avec Échap
      const mobileSidebar = document.getElementById('mobileSidebar');
      if (mobileSidebar && mobileSidebar.classList.contains('active')) {
        closeMobileSidebar();
      }
    }
  });
}

function setupModalListeners() {
  // Cart modal
  const closeCartBtn = document.getElementById('closeCartBtn');
  const clearCartBtn = document.getElementById('clearCartBtn');
  const checkoutBtn = document.getElementById('checkoutBtn');
  
  if (closeCartBtn) closeCartBtn.addEventListener('click', closeCartModal);
  if (clearCartBtn) clearCartBtn.addEventListener('click', () => cartManager.clearCart());
  if (checkoutBtn) checkoutBtn.addEventListener('click', openCheckoutModal);

  // Formation modal
  const closeFormationBtn = document.getElementById('closeFormationBtn');
  if (closeFormationBtn) closeFormationBtn.addEventListener('click', closeFormationModal);

  // Checkout modal
  const closeCheckoutBtn = document.getElementById('closeCheckoutBtn');
  const checkoutForm = document.getElementById('checkoutForm');
  
  if (closeCheckoutBtn) closeCheckoutBtn.addEventListener('click', closeCheckoutModal);
  if (checkoutForm) checkoutForm.addEventListener('submit', handleCheckout);

  // Close modals on backdrop click
  const modals = document.querySelectorAll('.modal');
  modals.forEach(modal => {
    modal.addEventListener('click', (e) => {
      if (e.target === modal) {
        modal.classList.remove('active');
        
        // Si c'est la modal de formation, arrêter la vidéo
        if (modal.id === 'formationModal') {
          const iframe = document.getElementById('youtubeVideo');
          const placeholder = document.getElementById('videoPlaceholder');
          
          if (iframe) {
            iframe.src = 'about:blank';
            iframe.style.display = 'none';
          }
          
          if (placeholder) {
            placeholder.style.display = 'block';
          }
        }
      }
    });
  });
}

function setupSmoothScroll() {
  const navLinks = document.querySelectorAll('.nav-link[href^="#"]');
  navLinks.forEach(link => {
    link.addEventListener('click', (e) => {
      e.preventDefault();
      const targetId = link.getAttribute('href').substring(1);
      const targetElement = document.getElementById(targetId);
      
      if (targetElement) {
        const offsetTop = targetElement.offsetTop - 80; // Account for fixed header
        window.scrollTo({
          top: offsetTop,
          behavior: 'smooth'
        });
        
        // Fermer la sidebar mobile si ouverte
        closeMobileSidebar();
      }
    });
  });
}

function setupHeroButtons() {
  const heroButtons = document.querySelectorAll('.hero-actions .btn');
  heroButtons.forEach(btn => {
    btn.addEventListener('click', () => {
      const formationsSection = document.getElementById('formations');
      if (formationsSection) {
        const offsetTop = formationsSection.offsetTop - 80;
        window.scrollTo({
          top: offsetTop,
          behavior: 'smooth'
        });
      }
    });
  });
}

function setupScrollEffects() {
  const header = document.querySelector('.header');
  let lastScrollY = window.scrollY;

  window.addEventListener('scroll', () => {
    const currentScrollY = window.scrollY;
    
    // Header effects on scroll
    if (currentScrollY > 50) {
      header.classList.add('scrolled');
    } else {
      header.classList.remove('scrolled');
    }

    // Active navigation link
    updateActiveNavLink();
    
    // Scroll animations
    animateOnScroll();
    
    lastScrollY = currentScrollY;
  });
}

function animateOnScroll() {
  const elements = document.querySelectorAll('.fade-in-up');
  elements.forEach(element => {
    const elementTop = element.getBoundingClientRect().top;
    const elementVisible = 150;
    
    if (elementTop < window.innerHeight - elementVisible) {
      element.classList.add('visible');
    }
  });
}

function updateActiveNavLink() {
  const sections = ['home', 'formations', 'about', 'contact'];
  const navLinks = document.querySelectorAll('.nav-link');
  
  let currentSection = 'home';
  
  sections.forEach(sectionId => {
    const section = document.getElementById(sectionId);
    if (section) {
      const rect = section.getBoundingClientRect();
      if (rect.top <= 100 && rect.bottom >= 100) {
        currentSection = sectionId;
      }
    }
  });
  
  navLinks.forEach(link => {
    link.classList.remove('active');
    if (link.getAttribute('href') === `#${currentSection}`) {
      link.classList.add('active');
    }
  });
}

function toggleMobileSidebar() {
  const mobileSidebar = document.getElementById('mobileSidebar');
  const mobileSidebarOverlay = document.getElementById('mobileSidebarOverlay');
  const mobileMenuBtn = document.getElementById('mobileMenuBtn');
  const icon = mobileMenuBtn.querySelector('i');
  
  if (mobileSidebar && mobileSidebarOverlay) {
    mobileSidebar.classList.add('active');
    mobileSidebarOverlay.classList.add('active');
    icon.className = 'fas fa-times';
    
    // Empêcher le scroll du body
    document.body.style.overflow = 'hidden';
  }
}

function closeMobileSidebar() {
  const mobileSidebar = document.getElementById('mobileSidebar');
  const mobileSidebarOverlay = document.getElementById('mobileSidebarOverlay');
  const mobileMenuBtn = document.getElementById('mobileMenuBtn');
  const icon = mobileMenuBtn.querySelector('i');
  
  if (mobileSidebar && mobileSidebarOverlay) {
    mobileSidebar.classList.remove('active');
    mobileSidebarOverlay.classList.remove('active');
    icon.className = 'fas fa-bars';
    
    // Restaurer le scroll du body
    document.body.style.overflow = '';
  }
}

function handleSearch(e) {
  searchTerm = e.target.value.toLowerCase();
  renderFormations();
}

function handleFilter(category) {
  currentFilter = category;
  
  // Update filter buttons
  const filterBtns = document.querySelectorAll('.filter-btn');
  filterBtns.forEach(btn => {
    btn.classList.remove('active');
    if (btn.dataset.category === category) {
      btn.classList.add('active');
    }
  });
  
  renderFormations();
}

function renderFormations() {
  const grid = document.getElementById('formationsGrid');
  if (!grid) return;

  let filteredFormations = formations.filter(formation => {
    const matchesFilter = currentFilter === 'all' || formation.category === currentFilter;
    const matchesSearch = formation.title.toLowerCase().includes(searchTerm) ||
                         formation.description.toLowerCase().includes(searchTerm);
    return matchesFilter && matchesSearch;
  });

  if (filteredFormations.length === 0) {
    grid.innerHTML = `
      <div style="grid-column: 1 / -1; text-align: center; padding: 4rem;">
        <i class="fas fa-search" style="font-size: 3rem; color: var(--gray-400); margin-bottom: 1rem;"></i>
        <p style="color: var(--gray-500); font-size: 1.2rem;">Aucune formation trouvée</p>
      </div>
    `;
    return;
  }

  grid.innerHTML = filteredFormations.map(formation => `
    <div class="formation-card fade-in-up" onclick="openFormationDetail(${formation.id})">
      <div class="formation-image" style="background-image: url('${formation.image}')">
        <span class="formation-badge">${getCategoryName(formation.category)}</span>
      </div>
      <div class="formation-content">
        <h3 class="formation-title">${formation.title}</h3>
        <p class="formation-description">${formation.description}</p>
        <div class="formation-meta">
          <span><i class="fas fa-clock"></i> ${formation.duration}</span>
          <span><i class="fas fa-signal"></i> ${formation.level}</span>
          <span><i class="fas fa-users"></i> ${formation.students}</span>
          <span><i class="fas fa-calendar-alt"></i> ${formation.sessionStart}</span>
          <span><i class="fas fa-map-marker-alt"></i> ${formation.location}</span>
          <span><i class="fas fa-laptop"></i> ${formation.mode}</span>
        </div>
        <div class="formation-footer">
          <div class="formation-price">
            ${formation.price} F CFA
          </div>
          <button class="view-more-btn" onclick="event.stopPropagation(); openFormationDetail(${formation.id})">
            <i class="fas fa-eye"></i>
            Voir plus
          </button>
        </div>
      </div>
    </div>
  `).join('');

  // Add animation
  const cards = grid.querySelectorAll('.formation-card');
  cards.forEach((card, index) => {
    card.style.opacity = '0';
    card.style.transform = 'translateY(30px)';
    setTimeout(() => {
      card.style.transition = 'all 0.5s ease';
      card.style.opacity = '1';
      card.style.transform = 'translateY(0)';
    }, index * 100);
  });
}

function getCategoryName(category) {
  const names = {
    'web': 'Dev Web',
    'marketing': 'Marketing',
    'data': 'Data Science',
    'design': 'Design'
  };
  return names[category] || category;
}

function generateStars(rating) {
  const fullStars = Math.floor(rating);
  const hasHalfStar = rating % 1 !== 0;
  let stars = '';
  
  for (let i = 0; i < fullStars; i++) {
    stars += '<i class="fas fa-star"></i>';
  }
  
  if (hasHalfStar) {
    stars += '<i class="fas fa-star-half-alt"></i>';
  }
  
  const emptyStars = 5 - Math.ceil(rating);
  for (let i = 0; i < emptyStars; i++) {
    stars += '<i class="far fa-star"></i>';
  }
  
  return stars;
}

// Modal functions
function openCartModal() {
  const modal = document.getElementById('cartModal');
  if (modal) {
    modal.classList.add('active');
    cartManager.renderCartItems();
  }
  
  // Synchroniser les compteurs de panier
  updateCartCounters();
}

function updateCartCounters() {
  const cartCount = document.getElementById('cartCount');
  const cartCountMobile = document.getElementById('cartCountMobile');
  const count = cartManager.cart.length;
  
  if (cartCount) cartCount.textContent = count;
  if (cartCountMobile) cartCountMobile.textContent = count;
}

function closeCartModal() {
  const modal = document.getElementById('cartModal');
  if (modal) {
    modal.classList.remove('active');
  }
}

function openFormationDetail(formationId) {
  const formation = formations.find(f => f.id === formationId);
  if (!formation) return;

  const modal = document.getElementById('formationModal');
  const content = document.getElementById('formationDetailContent');
  
  if (!modal || !content) return;

  content.innerHTML = `
    <div class="formation-detail-header">
      <div class="formation-video-container">
        <div class="video-placeholder" id="videoPlaceholder">
          <div class="video-thumbnail">
            <img src="https://img.youtube.com/vi/xaBnqfw6zro/maxresdefault.jpg" alt="Vidéo de présentation">
            <div class="play-button" onclick="loadVideo()">
              <i class="fas fa-play"></i>
            </div>
          </div>
        </div>
        <iframe 
          id="youtubeVideo"
          src="about:blank"
          title="Présentation de la formation"
          frameborder="0" 
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
          allowfullscreen
          style="display: none;">
        </iframe>
      </div>
      <h2 class="formation-detail-title">${formation.title}</h2>
    </div>
    <div class="formation-detail-body">
      <div class="formation-detail-meta">
        <div><i class="fas fa-clock"></i> ${formation.duration}</div>
        <div><i class="fas fa-signal"></i> ${formation.level}</div>
        <div><i class="fas fa-users"></i> ${formation.students} déjà inscrit</div>
        <div><i class="fas fa-user"></i> ${formation.instructor}</div>
        <div><i class="fas fa-calendar-alt"></i> Début: ${formation.sessionStart}</div>
        <div><i class="fas fa-map-marker-alt"></i> ${formation.location}</div>
        <div><i class="fas fa-laptop"></i> ${formation.mode}</div>
      </div>
      <div class="formation-detail-description">
        <p>${formation.longDescription}</p>
      </div>
      <div class="formation-detail-features">
        <h4>Ce que vous apprendrez :</h4>
        <ul class="features-list">
          ${formation.features.map(feature => `
            <li><i class="fas fa-check"></i> ${feature}</li>
          `).join('')}
        </ul>
      </div>
    </div>
    <div class="formation-detail-footer">
      <div class="formation-detail-price">
        ${formation.price} F CFA
      </div>
      <button class="btn btn-success" onclick="cartManager.addToCart(${formation.id}); closeFormationModal();">
        <i class="fas fa-cart-plus"></i>
        Ajouter au panier
      </button>
    </div>
  `;

  modal.classList.add('active');
}

function closeFormationModal() {
  const modal = document.getElementById('formationModal');
  const iframe = document.getElementById('youtubeVideo');
  const placeholder = document.getElementById('videoPlaceholder');
  
  if (modal) {
    modal.classList.remove('active');
  }
  
  // Arrêter la vidéo en rechargeant l'iframe
  if (iframe) {
    iframe.src = 'about:blank';
    iframe.style.display = 'none';
  }
  
  // Réafficher le placeholder pour la prochaine ouverture
  if (placeholder) {
    placeholder.style.display = 'block';
  }
}

function openCheckoutModal() {
  if (cartManager.cart.length === 0) {
    cartManager.showMessage('Votre panier est vide!', 'warning');
    return;
  }

  const modal = document.getElementById('checkoutModal');
  if (modal) {
    modal.classList.add('active');
    cartManager.renderCheckoutItems();
    closeCartModal();
  }
}

function closeCheckoutModal() {
  const modal = document.getElementById('checkoutModal');
  if (modal) {
    modal.classList.remove('active');
  }
}

// Fonction pour charger la vidéo avec son
function loadVideo() {
  const placeholder = document.getElementById('videoPlaceholder');
  const iframe = document.getElementById('youtubeVideo');
  
  if (placeholder && iframe) {
    // Charger la vidéo YouTube avec autoplay et son
    iframe.src = 'https://www.youtube.com/embed/xaBnqfw6zro?si=vv-vkmxgGeQrq-tZ&autoplay=1&mute=0&enablejsapi=1';
    
    // Masquer le placeholder et afficher l'iframe
    placeholder.style.display = 'none';
    iframe.style.display = 'block';
    
    // Focus sur l'iframe pour activer le son
    iframe.focus();
  }
}

async function handleCheckout(e) {
  e.preventDefault();
  
  const formData = new FormData(e.target);
  const customerData = {
    firstName: formData.get('firstName'),
    lastName: formData.get('lastName'),
    email: formData.get('email'),
    phone: formData.get('phone'),
    company: formData.get('company')
  };

  // Validation simple
  if (!customerData.firstName || !customerData.lastName || !customerData.email) {
    cartManager.showMessage('Veuillez remplir tous les champs obligatoires!', 'warning');
    return;
  }

  // Afficher un indicateur de chargement
  const submitBtn = e.target.querySelector('button[type="submit"]');
  const originalText = submitBtn.innerHTML;
  submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Traitement...';
  submitBtn.disabled = true;

  try {
    const result = await cartManager.processCheckout(customerData);
    
    if (result.success) {
      closeCheckoutModal();
      cartManager.showMessage(`${result.message} Numéro de commande: ${result.orderId}`, 'success');
      
      // Reset form
      e.target.reset();
    }
  } catch (error) {
    cartManager.showMessage('Erreur lors du traitement de la commande. Veuillez réessayer.', 'error');
  } finally {
    submitBtn.innerHTML = originalText;
    submitBtn.disabled = false;
  }
}
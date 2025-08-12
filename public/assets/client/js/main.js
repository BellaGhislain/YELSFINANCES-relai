// Variables globales
let currentFilter = 'all';
let searchTerm = '';

// DOM Content Loaded
document.addEventListener('DOMContentLoaded', function() {
  initializeApp();
});

async function initializeApp() {
  setupEventListeners();
  const formations = await fetchFormations();
  window.formations = formations;
  renderFormations();
  setupScrollEffects();
}

function setupEventListeners() {
  const mobileMenuBtn = document.getElementById('mobileMenuBtn');
  if (mobileMenuBtn) {
    mobileMenuBtn.addEventListener('click', toggleMobileMenu);
  }

  const searchInput = document.getElementById('searchInput');
  if (searchInput) {
    searchInput.addEventListener('input', handleSearch);
  }

  const filterBtns = document.querySelectorAll('.filter-btn');
  filterBtns.forEach(btn => {
    btn.addEventListener('click', () => handleFilter(btn.dataset.category));
  });

  const cartBtn = document.getElementById('cartBtn');
  if (cartBtn) {
    cartBtn.addEventListener('click', openCartModal);
  }

  setupModalListeners();
  setupSmoothScroll();
  setupHeroButtons();

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      const formationModal = document.getElementById('formationModal');
      if (formationModal && formationModal.classList.contains('active')) {
        closeFormationModal();
      }
    }
  });
}

function setupModalListeners() {
  const closeCartBtn = document.getElementById('closeCartBtn');
  const clearCartBtn = document.getElementById('clearCartBtn');
  const checkoutBtn = document.getElementById('checkoutBtn');

  if (closeCartBtn) closeCartBtn.addEventListener('click', closeCartModal);
  if (clearCartBtn) clearCartBtn.addEventListener('click', () => cartManager.clearCart());
  if (checkoutBtn) checkoutBtn.addEventListener('click', openCheckoutModal);

  const closeFormationBtn = document.getElementById('closeFormationBtn');
  if (closeFormationBtn) closeFormationBtn.addEventListener('click', closeFormationModal);

  const closeCheckoutBtn = document.getElementById('closeCheckoutBtn');
  const checkoutForm = document.getElementById('checkoutForm');

  if (closeCheckoutBtn) closeCheckoutBtn.addEventListener('click', closeCheckoutModal);
  if (checkoutForm) checkoutForm.addEventListener('submit', handleCheckout);

  const modals = document.querySelectorAll('.modal');
  modals.forEach(modal => {
    modal.addEventListener('click', (e) => {
      if (e.target === modal) {
        modal.classList.remove('active');
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
        const offsetTop = targetElement.offsetTop - 80;
        window.scrollTo({
          top: offsetTop,
          behavior: 'smooth'
        });
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
    if (currentScrollY > 50) {
      header.classList.add('scrolled');
    } else {
      header.classList.remove('scrolled');
    }
    updateActiveNavLink();
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

function toggleMobileMenu() {
  const navMenu = document.querySelector('.nav-menu');
  navMenu.classList.toggle('active');
}

function handleSearch(e) {
  searchTerm = e.target.value.toLowerCase();
  renderFormations();
}

function handleFilter(category) {
  currentFilter = category;
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

  let filteredFormations = window.formations.filter(formation => {
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
      <div class="formation-image" style="background-image: url('${formation.photo}')">
        <span class="formation-badge">${getCategoryName(formation.category)}</span>
      </div>
      <div class="formation-content">
        <h3 class="formation-title">${formation.title}</h3>
        <p class="formation-description">${formation.description}</p>
        <div class="formation-meta">
          <span><i class="fas fa-clock"></i> ${formation.duration}</span>
          <span><i class="fas fa-signal"></i> ${formation.level}</span>
          <span><i class="fas fa-users"></i> ${formation.students}</span>
          <span><i class="fas fa-calendar-alt"></i> ${formation.session}</span>
        </div>
        <div class="formation-footer">
          <div class="formation-price">${formation.price} F CFA</div>
          <button class="view-more-btn" onclick="event.stopPropagation(); openFormationDetail(${formation.id})">
            <i class="fas fa-eye"></i> Voir plus
          </button>
        </div>
      </div>
    </div>
  `).join('');

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

function openCartModal() {
  const modal = document.getElementById('cartModal');
  if (modal) {
    modal.classList.add('active');
    cartManager.renderCartItems();
  }
}

function closeCartModal() {
  const modal = document.getElementById('cartModal');
  if (modal) {
    modal.classList.remove('active');
  }
}

function openFormationDetail(formationId) {
  const formation = window.formations.find(f => f.id === formationId);
  if (!formation) return;

  const modal = document.getElementById('formationModal');
  const content = document.getElementById('formationDetailContent');
  window.currentYoutubeLink = formation.youtube_link;

  if (!modal || !content) return;

  content.innerHTML = `
    <div class="formation-detail-header">
      <div class="formation-video-container">
        <div class="video-placeholder" id="videoPlaceholder">
          <div class="video-thumbnail">
            <img src="${formation.photo}" alt="Vidéo de présentation">
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
        <div><i class="fas fa-users"></i> ${formation.students} étudiants</div>
        <div>
          <div class="stars">${generateStars(formation.rating)}</div>
          <span>(${formation.rating})</span>
        </div>
        <div><i class="fas fa-user"></i> Formateur(s): ${formation.instructor}</div>
        <div><i class="fas fa-calendar-alt"></i> Période: du ${formation.start_date} au ${formation.end_date}</div>
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
      <div class="formation-detail-price">${formation.price} F CFA</div>
      <button class="btn btn-success" onclick="cartManager.addToCart(${formation.id}); closeFormationModal();">
        <i class="fas fa-cart-plus"></i> Ajouter au panier
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

  if (iframe) {
    iframe.src = 'about:blank';
    iframe.style.display = 'none';
  }

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

function extractYoutubeID(url) {
  const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/;
  const match = url.match(regExp);
  return (match && match[2].length === 11) ? match[2] : null;
}

function loadVideo() {
  const placeholder = document.getElementById('videoPlaceholder');
  const iframe = document.getElementById('youtubeVideo');

  if (placeholder && iframe && window.currentYoutubeLink) {
    const videoID = extractYoutubeID(window.currentYoutubeLink);
    if (!videoID) return;

    iframe.src = `https://www.youtube.com/embed/${videoID}?autoplay=1&mute=0&enablejsapi=1`;
    placeholder.style.display = 'none';
    iframe.style.display = 'block';
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
    company: formData.get('company'),
    country: formData.get('country'),
  };

  if (!customerData.firstName || !customerData.lastName || !customerData.email || !customerData.phone || !customerData.company || !customerData.country) {
    cartManager.showMessage('Veuillez remplir tous les champs obligatoires!', 'warning');
    return;
  }

  const submitBtn = e.target.querySelector('button[type="submit"]');
  const originalText = submitBtn.innerHTML;
  submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Traitement...';
  submitBtn.disabled = true;

  try {
    const result = await cartManager.processCheckout(customerData);
    if (result.success) {
      closeCheckoutModal();
      cartManager.showMessage(`${result.message} Numéro de commande: ${result.orderId}`, 'success');
      e.target.reset();
    } else {
      cartManager.showMessage(result.message, 'error');
    }
  } catch (error) {
    cartManager.showMessage('Erreur lors du traitement de la commande. Veuillez réessayer.', 'error');
  } finally {
    submitBtn.innerHTML = originalText;
    submitBtn.disabled = false;
  }
}

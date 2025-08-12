// ===== GESTION DU HEADER AVEC SCROLL =====
document.addEventListener('DOMContentLoaded', function() {
  const header = document.querySelector('.header');
  
  function handleScroll() {
    if (window.scrollY > 50) {
      header.classList.add('scrolled');
    } else {
      header.classList.remove('scrolled');
    }
  }
  
  // Ajouter l'effet de scroll
  window.addEventListener('scroll', handleScroll);
  
  // Vérifier l'état initial
  handleScroll();
  
  // ===== ANIMATION DU MENU MOBILE =====
  const mobileMenuBtn = document.getElementById('mobileMenuBtn');
  const mobileSidebar = document.getElementById('mobileSidebar');
  const mobileSidebarOverlay = document.getElementById('mobileSidebarOverlay');
  
  if (mobileMenuBtn && mobileSidebar) {
    mobileMenuBtn.addEventListener('click', function() {
      mobileSidebar.classList.toggle('active');
      mobileSidebarOverlay.classList.toggle('active');
      document.body.style.overflow = mobileSidebar.classList.contains('active') ? 'hidden' : '';
    });
  }
  
  if (mobileSidebarOverlay) {
    mobileSidebarOverlay.addEventListener('click', function() {
      mobileSidebar.classList.remove('active');
      mobileSidebarOverlay.classList.remove('active');
      document.body.style.overflow = '';
    });
  }
  
  // ===== FERMETURE DU MENU MOBILE AVEC ÉCHAP =====
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && mobileSidebar && mobileSidebar.classList.contains('active')) {
      mobileSidebar.classList.remove('active');
      mobileSidebarOverlay.classList.remove('active');
      document.body.style.overflow = '';
    }
  });
  
  // ===== ANIMATION DES LIENS DE NAVIGATION =====
  const navLinks = document.querySelectorAll('.nav-link');
  
  navLinks.forEach(link => {
    link.addEventListener('mouseenter', function() {
      this.style.transform = 'translateY(-2px)';
    });
    
    link.addEventListener('mouseleave', function() {
      this.style.transform = 'translateY(0)';
    });
  });
  
  // ===== EFFET DE GLOW SUR LE BRAND =====
  const navBrand = document.querySelector('.nav-brand');
  
  if (navBrand) {
    navBrand.addEventListener('mouseenter', function() {
      this.style.filter = 'drop-shadow(0 0 20px rgba(212, 175, 55, 0.8))';
    });
    
    navBrand.addEventListener('mouseleave', function() {
      this.style.filter = 'drop-shadow(0 0 10px rgba(212, 175, 55, 0.5))';
    });
  }
});

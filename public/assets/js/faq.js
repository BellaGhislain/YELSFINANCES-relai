// ===== GESTION INTERACTIVE DE LA FAQ =====
document.addEventListener('DOMContentLoaded', function() {
  const faqItems = document.querySelectorAll('.faq-item');
  
  faqItems.forEach(item => {
    const question = item.querySelector('.faq-question');
    const answer = item.querySelector('.faq-answer');
    const icon = item.querySelector('.faq-question i');
    
    // Masquer toutes les réponses au chargement
    answer.style.display = 'none';
    
    question.addEventListener('click', function() {
      const isOpen = answer.style.display === 'block';
      
      // Fermer toutes les autres FAQ
      faqItems.forEach(otherItem => {
        if (otherItem !== item) {
          const otherAnswer = otherItem.querySelector('.faq-answer');
          const otherIcon = otherItem.querySelector('.faq-question i');
          
          otherAnswer.style.display = 'none';
          otherIcon.style.transform = 'rotate(0deg)';
          otherItem.classList.remove('active');
        }
      });
      
      // Toggle de la FAQ actuelle
      if (isOpen) {
        answer.style.display = 'none';
        icon.style.transform = 'rotate(0deg)';
        item.classList.remove('active');
      } else {
        answer.style.display = 'block';
        icon.style.transform = 'rotate(180deg)';
        item.classList.add('active');
        
        // Animation d'apparition
        answer.style.opacity = '0';
        answer.style.transform = 'translateY(-10px)';
        
        setTimeout(() => {
          answer.style.transition = 'all 0.3s ease';
          answer.style.opacity = '1';
          answer.style.transform = 'translateY(0)';
        }, 10);
      }
    });
    
    // Effet de hover sur les questions
    question.addEventListener('mouseenter', function() {
      if (answer.style.display !== 'block') {
        icon.style.transform = 'rotate(90deg)';
      }
    });
    
    question.addEventListener('mouseleave', function() {
      if (answer.style.display !== 'block') {
        icon.style.transform = 'rotate(0deg)';
      }
    });
  });
  
  // ===== ANIMATION DES ÉLÉMENTS FAQ AU SCROLL =====
  const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
  };
  
  const faqObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.style.opacity = '1';
        entry.target.style.transform = 'translateY(0)';
      }
    });
  }, observerOptions);
  
  // Observer chaque élément FAQ
  faqItems.forEach((item, index) => {
    item.style.opacity = '0';
    item.style.transform = 'translateY(30px)';
    item.style.transition = `all 0.6s ease ${index * 0.1}s`;
    
    faqObserver.observe(item);
  });
  
  // ===== EFFET DE GLOW SUR LES QUESTIONS ACTIVES =====
  faqItems.forEach(item => {
    item.addEventListener('mouseenter', function() {
      if (this.classList.contains('active')) {
        this.style.boxShadow = '0 0 40px rgba(212, 175, 55, 0.4), 0 0 80px rgba(212, 175, 55, 0.2)';
      }
    });
    
    item.addEventListener('mouseleave', function() {
      if (this.classList.contains('active')) {
        this.style.boxShadow = '0 15px 35px rgba(212, 175, 55, 0.2), 0 0 60px rgba(212, 175, 55, 0.1)';
      }
    });
  });
});

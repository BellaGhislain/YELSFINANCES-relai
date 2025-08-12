// ===== GESTION DU FORMULAIRE DE CONTACT =====
document.addEventListener('DOMContentLoaded', function() {
  const contactForm = document.getElementById('contactForm');
  
  if (contactForm) {
    contactForm.addEventListener('submit', function(e) {
      e.preventDefault();
      
      // Récupérer les valeurs du formulaire
      const formData = new FormData(contactForm);
      const name = formData.get('name') || contactForm.querySelector('input[type="text"]').value;
      const email = formData.get('email') || contactForm.querySelector('input[type="email"]').value;
      const phone = formData.get('phone') || contactForm.querySelector('input[type="tel"]').value;
      const subject = formData.get('subject') || contactForm.querySelector('select').value;
      const message = formData.get('message') || contactForm.querySelector('textarea').value;
      
      // Validation basique
      if (!name || !email || !message) {
        showNotification('Veuillez remplir tous les champs obligatoires', 'error');
        return;
      }
      
      if (!isValidEmail(email)) {
        showNotification('Veuillez entrer une adresse email valide', 'error');
        return;
      }
      
      // Simuler l'envoi
      const submitBtn = contactForm.querySelector('.btn-primary');
      const originalText = submitBtn.textContent;
      
      submitBtn.textContent = 'Envoi en cours...';
      submitBtn.disabled = true;
      
      // Animation de chargement
      submitBtn.style.background = 'linear-gradient(135deg, #666 0%, #999 100%)';
      
      setTimeout(() => {
        // Simuler un délai d'envoi
        showNotification('Votre message a été envoyé avec succès !', 'success');
        
        // Réinitialiser le formulaire
        contactForm.reset();
        
        // Restaurer le bouton
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
        submitBtn.style.background = 'linear-gradient(135deg, #d4af37 0%, #ffd700 100%)';
        
        // Animation de succès
        submitBtn.style.transform = 'scale(1.1)';
        setTimeout(() => {
          submitBtn.style.transform = 'scale(1)';
        }, 200);
        
      }, 2000);
    });
    
    // ===== VALIDATION EN TEMPS RÉEL =====
    const inputs = contactForm.querySelectorAll('input, textarea, select');
    
    inputs.forEach(input => {
      input.addEventListener('blur', function() {
        validateField(this);
      });
      
      input.addEventListener('input', function() {
        if (this.classList.contains('error')) {
          this.classList.remove('error');
          this.style.borderColor = 'rgba(212, 175, 55, 0.3)';
        }
      });
    });
  }
  
  // ===== VALIDATION DES CHAMPS =====
  function validateField(field) {
    const value = field.value.trim();
    
    if (field.hasAttribute('required') && !value) {
      field.classList.add('error');
      field.style.borderColor = 'rgba(255, 100, 100, 0.8)';
      return false;
    }
    
    if (field.type === 'email' && value && !isValidEmail(value)) {
      field.classList.add('error');
      field.style.borderColor = 'rgba(255, 100, 100, 0.8)';
      return false;
    }
    
    return true;
  }
  
  // ===== VALIDATION EMAIL =====
  function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
  }
  
  // ===== NOTIFICATIONS =====
  function showNotification(message, type) {
    // Créer la notification
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
      <div class="notification-content">
        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
        <span>${message}</span>
      </div>
    `;
    
    // Styles de la notification
    notification.style.cssText = `
      position: fixed;
      top: 100px;
      right: 20px;
      background: ${type === 'success' ? 'linear-gradient(135deg, #4CAF50, #45a049)' : 'linear-gradient(135deg, #f44336, #da190b)'};
      color: white;
      padding: 15px 20px;
      border-radius: 8px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.3);
      z-index: 10000;
      transform: translateX(400px);
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255,255,255,0.2);
    `;
    
    // Ajouter au DOM
    document.body.appendChild(notification);
    
    // Animation d'entrée
    setTimeout(() => {
      notification.style.transform = 'translateX(0)';
    }, 100);
    
    // Auto-suppression
    setTimeout(() => {
      notification.style.transform = 'translateX(400px)';
      setTimeout(() => {
        if (notification.parentNode) {
          notification.parentNode.removeChild(notification);
        }
      }, 400);
    }, 4000);
  }
  
  // ===== ANIMATION DES CHAMPS AU FOCUS =====
  const formFields = document.querySelectorAll('.contact-form input, .contact-form textarea, .contact-form select');
  
  formFields.forEach(field => {
    field.addEventListener('focus', function() {
      this.parentElement.style.transform = 'scale(1.02)';
    });
    
    field.addEventListener('blur', function() {
      this.parentElement.style.transform = 'scale(1)';
    });
  });
  
  // ===== EFFET DE GLOW SUR LES ICÔNES DE CONTACT =====
  const contactIcons = document.querySelectorAll('.contact-item i');
  
  contactIcons.forEach(icon => {
    icon.addEventListener('mouseenter', function() {
      this.style.filter = 'drop-shadow(0 0 25px rgba(212, 175, 55, 0.8))';
      this.style.transform = 'scale(1.1) rotate(5deg)';
    });
    
    icon.addEventListener('mouseleave', function() {
      this.style.filter = 'drop-shadow(0 0 15px rgba(212, 175, 55, 0.5))';
      this.style.transform = 'scale(1) rotate(0deg)';
    });
  });
});

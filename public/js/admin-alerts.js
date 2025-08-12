// Admin Alerts Management
document.addEventListener('DOMContentLoaded', function() {
    // Auto-dismiss des alertes après 5 secondes
    const alerts = document.querySelectorAll('.alert');
    
    alerts.forEach(alert => {
        // Auto-dismiss après 5 secondes
        setTimeout(() => {
            if (alert && alert.parentNode) {
                alert.style.transition = 'all 0.3s ease-out';
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                
                setTimeout(() => {
                    if (alert.parentNode) {
                        alert.remove();
                    }
                }, 300);
            }
        }, 5000);
        
        // Animation d'entrée
        alert.style.opacity = '0';
        alert.style.transform = 'translateY(-20px)';
        
        setTimeout(() => {
            alert.style.transition = 'all 0.4s ease-out';
            alert.style.opacity = '1';
            alert.style.transform = 'translateY(0)';
        }, 100);
    });
    
    // Gestion du bouton de fermeture
    const closeButtons = document.querySelectorAll('.alert .btn-close');
    
    closeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const alert = this.closest('.alert');
            if (alert) {
                alert.style.transition = 'all 0.3s ease-out';
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                
                setTimeout(() => {
                    if (alert.parentNode) {
                        alert.remove();
                    }
                }, 300);
            }
        });
    });
    
    // Ajout d'un effet de hover sur les alertes
    alerts.forEach(alert => {
        alert.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.boxShadow = '0 4px 12px rgba(0, 0, 0, 0.15)';
        });
        
        alert.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '0 0.125rem 0.25rem rgba(0, 0, 0, 0.075)';
        });
    });
    
    // Notification toast pour les actions rapides
    window.showToast = function(message, type = 'success', duration = 3000) {
        const toast = document.createElement('div');
        toast.className = `toast toast-${type} position-fixed`;
        toast.style.cssText = `
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
            background: ${type === 'success' ? '#d1f2eb' : '#fde8e8'};
            border-left: 4px solid ${type === 'success' ? '#10b981' : '#ef4444'};
            color: ${type === 'success' ? '#065f46' : '#7f1d1d'};
            padding: 1rem 1.25rem;
            border-radius: 0.75rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transform: translateX(100%);
            transition: transform 0.3s ease-out;
        `;
        
        const icon = type === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill';
        toast.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="${icon} me-2 fs-5"></i>
                <span class="fw-medium">${message}</span>
                <button type="button" class="btn-close ms-auto" onclick="this.parentElement.parentElement.remove()">
                </button>
            </div>
        `;
        
        document.body.appendChild(toast);
        
        // Animation d'entrée
        setTimeout(() => {
            toast.style.transform = 'translateX(0)';
        }, 100);
        
        // Auto-dismiss
        setTimeout(() => {
            toast.style.transform = 'translateX(100%)';
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.remove();
                }
            }, 300);
        }, duration);
    };
    
    // Amélioration des messages de validation des formulaires
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function() {
            // Afficher un indicateur de chargement
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="bi-arrow-clockwise spin me-2"></i>Traitement...';
                submitBtn.disabled = true;
                
                // Réactiver le bouton après 10 secondes (sécurité)
                setTimeout(() => {
                    if (submitBtn) {
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;
                    }
                }, 10000);
            }
        });
    });
    
    // Animation des icônes de chargement
    const spinIcons = document.querySelectorAll('.spin');
    spinIcons.forEach(icon => {
        icon.style.animation = 'spin 1s linear infinite';
    });
});

// CSS pour l'animation de rotation
const style = document.createElement('style');
style.textContent = `
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    
    .toast {
        font-family: 'Inter', sans-serif;
        font-size: 0.95rem;
    }
    
    .toast .btn-close {
        padding: 0.5rem;
        margin: -0.5rem -0.5rem -0.5rem auto;
        background-size: 1.25em;
        opacity: 0.7;
    }
    
    .toast .btn-close:hover {
        opacity: 1;
    }
`;
document.head.appendChild(style);


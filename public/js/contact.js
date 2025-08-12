// Contact.js - Gestion du formulaire de contact

document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.getElementById('contactForm');
    
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Récupérer les données du formulaire
            const formData = new FormData(contactForm);
            const data = Object.fromEntries(formData);
            
            // Validation basique
            if (!data.name || !data.email || !data.message) {
                alert('Veuillez remplir tous les champs obligatoires.');
                return;
            }
            
            if (!isValidEmail(data.email)) {
                alert('Veuillez entrer une adresse email valide.');
                return;
            }
            
            // Simuler l'envoi du formulaire
            console.log('Données du formulaire:', data);
            
            // Afficher un message de succès
            alert('Votre message a été envoyé avec succès ! Nous vous répondrons dans les plus brefs délais.');
            
            // Réinitialiser le formulaire
            contactForm.reset();
        });
    }
    
    // Validation d'email
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
    
    // Animation des champs de formulaire
    const formInputs = document.querySelectorAll('.contact-form input, .contact-form textarea, .contact-form select');
    
    formInputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });
        
        input.addEventListener('blur', function() {
            if (!this.value) {
                this.parentElement.classList.remove('focused');
            }
        });
        
        // Si le champ a déjà une valeur, ajouter la classe focused
        if (input.value) {
            input.parentElement.classList.add('focused');
        }
    });
});



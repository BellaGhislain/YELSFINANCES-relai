@props(['name', 'value' => '', 'placeholder' => '+237 6XX XXX XXX', 'required' => false, 'maxlength' => 10])

<div class="phone-input-container">
    <input type="tel" 
           class="form-control @error($name) is-invalid @enderror" 
           name="{{ $name }}" 
           id="{{ $name }}Label" 
           placeholder="{{ $placeholder }}"
           value="{{ old($name, $value) }}"
           maxlength="{{ $maxlength }}"
           pattern="[0-9]{10}"
           {{ $required ? 'required' : '' }}
           oninput="formatPhoneNumber(this)"
           onkeypress="return event.charCode >= 48 && event.charCode <= 57">
    
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    
    <small class="form-text text-muted">
        Format: 10 chiffres (ex: 690123456)
    </small>
</div>

<script>
function formatPhoneNumber(input) {
    // Supprimer tous les caractères non numériques
    let value = input.value.replace(/\D/g, '');
    
    // Limiter à 10 chiffres
    if (value.length > 10) {
        value = value.slice(0, 10);
    }
    
    // Mettre à jour la valeur
    input.value = value;
    
    // Validation en temps réel
    if (value.length === 10) {
        input.classList.remove('is-invalid');
        input.classList.add('is-valid');
    } else if (value.length > 0) {
        input.classList.remove('is-valid');
        input.classList.add('is-invalid');
    } else {
        input.classList.remove('is-valid', 'is-invalid');
    }
}

// Validation lors de la soumission du formulaire
document.addEventListener('DOMContentLoaded', function() {
    const phoneInputs = document.querySelectorAll('input[type="tel"]');
    
    phoneInputs.forEach(input => {
        const form = input.closest('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                const phoneValue = input.value.replace(/\D/g, '');
                
                if (phoneValue.length !== 10) {
                    e.preventDefault();
                    input.classList.add('is-invalid');
                    input.focus();
                    
                    // Afficher un message d'erreur personnalisé
                    let errorDiv = input.nextElementSibling;
                    if (!errorDiv || !errorDiv.classList.contains('invalid-feedback')) {
                        errorDiv = document.createElement('div');
                        errorDiv.className = 'invalid-feedback';
                        input.parentNode.insertBefore(errorDiv, input.nextSibling);
                    }
                    errorDiv.textContent = 'Le numéro de téléphone doit contenir exactement 10 chiffres.';
                }
            });
        }
    });
});
</script>

<style>
.phone-input-container {
    position: relative;
}

.phone-input-container input[type="tel"] {
    font-family: 'Courier New', monospace;
    letter-spacing: 1px;
}

.phone-input-container input[type="tel"]:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

.phone-input-container input[type="tel"].is-valid {
    border-color: #198754;
    box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.25);
}

.phone-input-container input[type="tel"].is-invalid {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
}

.phone-input-container .form-text {
    font-size: 0.875rem;
    margin-top: 0.25rem;
}
</style>


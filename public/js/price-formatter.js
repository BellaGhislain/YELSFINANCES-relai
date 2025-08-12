// Price Formatter - Formatage automatique des montants
document.addEventListener('DOMContentLoaded', function() {
    
    // Fonction pour formater un montant avec séparateurs de milliers
    function formatPrice(amount, currency = '€', decimals = 2) {
        if (amount === null || amount === undefined || amount === '') {
            return '0 ' + currency;
        }
        
        // Convertir en nombre si c'est une chaîne
        const numAmount = parseFloat(amount);
        
        if (isNaN(numAmount)) {
            return '0 ' + currency;
        }
        
        // Formater avec séparateurs de milliers
        const formattedAmount = numAmount.toLocaleString('fr-FR', {
            minimumFractionDigits: decimals,
            maximumFractionDigits: decimals
        });
        
        return formattedAmount + ' ' + currency;
    }
    
    // Fonction pour formater tous les montants dans une page
    function formatAllPrices() {
        // Sélecteurs pour les montants
        const priceSelectors = [
            '.price-display',
            '[data-price]',
            '.formation-price',
            '.session-price',
            '.total-price',
            '.cart-total',
            '.checkout-total'
        ];
        
        priceSelectors.forEach(selector => {
            const elements = document.querySelectorAll(selector);
            
            elements.forEach(element => {
                // Si l'élément a déjà été formaté, passer au suivant
                if (element.dataset.formatted === 'true') {
                    return;
                }
                
                let amount = null;
                let currency = '€';
                
                // Récupérer le montant depuis différents attributs
                if (element.dataset.amount) {
                    amount = element.dataset.amount;
                } else if (element.dataset.price) {
                    amount = element.dataset.price;
                } else if (element.textContent) {
                    // Extraire le montant du texte
                    const text = element.textContent.trim();
                    const priceMatch = text.match(/(\d+(?:[.,]\d+)?)/);
                    if (priceMatch) {
                        amount = priceMatch[1].replace(',', '.');
                    }
                    
                    // Détecter la devise
                    if (text.includes('€')) currency = '€';
                    else if (text.includes('$')) currency = '$';
                    else if (text.includes('F CFA')) currency = 'F CFA';
                }
                
                if (amount !== null) {
                    const formattedPrice = formatPrice(amount, currency);
                    element.textContent = formattedPrice;
                    element.dataset.formatted = 'true';
                    element.dataset.originalAmount = amount;
                    element.dataset.currency = currency;
                }
            });
        });
        
        // Formater les montants dans les tableaux
        const tableCells = document.querySelectorAll('td:contains("€"), td:contains("$"), td:contains("F CFA")');
        tableCells.forEach(cell => {
            if (cell.dataset.formatted !== 'true') {
                const text = cell.textContent.trim();
                const priceMatch = text.match(/(\d+(?:[.,]\d+)?)/);
                
                if (priceMatch) {
                    let currency = '€';
                    if (text.includes('$')) currency = '$';
                    else if (text.includes('F CFA')) currency = 'F CFA';
                    
                    const amount = parseFloat(priceMatch[1].replace(',', '.'));
                    const formattedPrice = formatPrice(amount, currency);
                    cell.textContent = formattedPrice;
                    cell.dataset.formatted = 'true';
                }
            }
        });
    }
    
    // Fonction pour formater les montants dans les inputs
    function formatPriceInputs() {
        const priceInputs = document.querySelectorAll('input[type="number"][name*="price"], input[type="number"][name*="amount"]');
        
        priceInputs.forEach(input => {
            // Ajouter un événement pour formater lors de la saisie
            input.addEventListener('input', function(e) {
                let value = e.target.value;
                
                // Supprimer tous les caractères non numériques sauf le point
                value = value.replace(/[^\d.]/g, '');
                
                // S'assurer qu'il n'y a qu'un seul point décimal
                const parts = value.split('.');
                if (parts.length > 2) {
                    value = parts[0] + '.' + parts.slice(1).join('');
                }
                
                // Limiter à 2 décimales
                if (parts.length === 2 && parts[1].length > 2) {
                    value = parts[0] + '.' + parts[1].slice(0, 2);
                }
                
                e.target.value = value;
            });
            
            // Formater lors de la perte de focus
            input.addEventListener('blur', function(e) {
                const value = parseFloat(e.target.value);
                if (!isNaN(value)) {
                    const formatted = formatPrice(value, '€', 2);
                    // Stocker la valeur formatée dans un attribut data
                    e.target.dataset.formattedValue = formatted;
                }
            });
        });
    }
    
    // Fonction pour formater les montants dans les cartes de formation
    function formatFormationCards() {
        const formationCards = document.querySelectorAll('.formation-card, .session-card');
        
        formationCards.forEach(card => {
            const priceElement = card.querySelector('.formation-price, .session-price, .price');
            if (priceElement && priceElement.dataset.formatted !== 'true') {
                const text = priceElement.textContent.trim();
                const priceMatch = text.match(/(\d+(?:[.,]\d+)?)/);
                
                if (priceMatch) {
                    let currency = '€';
                    if (text.includes('$')) currency = '$';
                    else if (text.includes('F CFA')) currency = 'F CFA';
                    
                    const amount = parseFloat(priceMatch[1].replace(',', '.'));
                    const formattedPrice = formatPrice(amount, currency);
                    priceElement.textContent = formattedPrice;
                    priceElement.dataset.formatted = 'true';
                }
            }
        });
    }
    
    // Fonction pour formater les montants dans le panier
    function formatCartPrices() {
        const cartItems = document.querySelectorAll('.cart-item, .cart-item-price');
        
        cartItems.forEach(item => {
            if (item.dataset.formatted !== 'true') {
                const text = item.textContent.trim();
                const priceMatch = text.match(/(\d+(?:[.,]\d+)?)/);
                
                if (priceMatch) {
                    let currency = '€';
                    if (text.includes('$')) currency = '$';
                    else if (text.includes('F CFA')) currency = 'F CFA';
                    
                    const amount = parseFloat(priceMatch[1].replace(',', '.'));
                    const formattedPrice = formatPrice(amount, currency);
                    item.textContent = formattedPrice;
                    item.dataset.formatted = 'true';
                }
            }
        });
    }
    
    // Fonction pour formater les totaux
    function formatTotals() {
        const totalElements = document.querySelectorAll('.total, .cart-total, .checkout-total, [class*="total"]');
        
        totalElements.forEach(element => {
            if (element.dataset.formatted !== 'true') {
                const text = element.textContent.trim();
                const priceMatch = text.match(/(\d+(?:[.,]\d+)?)/);
                
                if (priceMatch) {
                    let currency = '€';
                    if (text.includes('$')) currency = '$';
                    else if (text.includes('F CFA')) currency = 'F CFA';
                    
                    const amount = parseFloat(priceMatch[1].replace(',', '.'));
                    const formattedPrice = formatPrice(amount, currency);
                    element.textContent = formattedPrice;
                    element.dataset.formatted = 'true';
                }
            }
        });
    }
    
    // Fonction principale pour formater tous les montants
    function formatAllMoneyValues() {
        formatAllPrices();
        formatPriceInputs();
        formatFormationCards();
        formatCartPrices();
        formatTotals();
    }
    
    // Exécuter le formatage au chargement de la page
    formatAllMoneyValues();
    
    // Exécuter le formatage après les changements de contenu (pour les SPA)
    const observer = new MutationObserver(function(mutations) {
        let shouldFormat = false;
        
        mutations.forEach(function(mutation) {
            if (mutation.type === 'childList' || mutation.type === 'characterData') {
                shouldFormat = true;
            }
        });
        
        if (shouldFormat) {
            setTimeout(formatAllMoneyValues, 100);
        }
    });
    
    // Observer les changements dans le body
    observer.observe(document.body, {
        childList: true,
        subtree: true,
        characterData: true
    });
    
    // Exposer les fonctions globalement pour utilisation externe
    window.PriceFormatter = {
        formatPrice: formatPrice,
        formatAllPrices: formatAllPrices,
        formatAllMoneyValues: formatAllMoneyValues
    };
    
    // Formater les montants dans les modales et popups
    document.addEventListener('show.bs.modal', function() {
        setTimeout(formatAllMoneyValues, 100);
    });
    
    // Formater les montants lors des changements d'onglets
    document.addEventListener('shown.bs.tab', function() {
        setTimeout(formatAllMoneyValues, 100);
    });
});

// Fonction utilitaire pour formater un montant depuis JavaScript
function formatMoney(amount, currency = '€', decimals = 2) {
    if (window.PriceFormatter) {
        return window.PriceFormatter.formatPrice(amount, currency, decimals);
    }
    
    // Fallback si PriceFormatter n'est pas disponible
    if (amount === null || amount === undefined || amount === '') {
        return '0 ' + currency;
    }
    
    const numAmount = parseFloat(amount);
    if (isNaN(numAmount)) {
        return '0 ' + currency;
    }
    
    const formattedAmount = numAmount.toLocaleString('fr-FR', {
        minimumFractionDigits: decimals,
        maximumFractionDigits: decimals
    });
    
    return formattedAmount + ' ' + currency;
}


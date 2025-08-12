# Formatage des Prix & Validation des Téléphones - YEL'S FINANCES

## Vue d'ensemble

Ce système améliore l'affichage des montants et la validation des numéros de téléphone dans toute l'application. Il remplace les anciens affichages de prix par un formatage automatique avec séparateurs de milliers et limite les numéros de téléphone à 10 chiffres.

## Fonctionnalités

### 1. Formatage Automatique des Prix
- **Séparateurs de milliers** : 1 500 € au lieu de 1500€
- **Support multi-devises** : €, $, F CFA
- **Formatage automatique** : Dès le chargement de la page
- **Détection intelligente** : Reconnaît automatiquement les montants dans le contenu
- **Responsive** : S'adapte à tous les écrans

### 2. Validation des Numéros de Téléphone
- **Limite stricte** : Maximum 10 chiffres
- **Caractères autorisés** : Uniquement les chiffres (0-9)
- **Validation en temps réel** : Feedback immédiat lors de la saisie
- **Messages d'erreur** : Explications claires des erreurs
- **Formatage automatique** : Suppression des caractères non autorisés

## Composants Blade

### Composant Prix (`<x-price>`)

```blade
<!-- Utilisation de base -->
<x-price :amount="1500" currency="€" />

<!-- Avec décimales personnalisées -->
<x-price :amount="1500.50" currency="€" :decimals="2" />

<!-- Autres devises -->
<x-price :amount="2500" currency="$" />
<x-price :amount="75000" currency="F CFA" />
```

**Propriétés :**
- `amount` : Le montant à afficher (requis)
- `currency` : La devise (défaut: €)
- `decimals` : Nombre de décimales (défaut: 2)
- `locale` : Locale pour le formatage (défaut: fr_FR)

### Composant Téléphone (`<x-phone-input>`)

```blade
<!-- Utilisation de base -->
<x-phone-input name="phone" :required="true" />

<!-- Avec valeur et placeholder -->
<x-phone-input name="phone" :value="old('phone')" placeholder="690123456" :required="true" />

<!-- Sans validation requise -->
<x-phone-input name="phone" :required="false" />
```

**Propriétés :**
- `name` : Nom du champ (requis)
- `value` : Valeur initiale
- `placeholder` : Texte d'aide (défaut: +237 6XX XXX XXX)
- `required` : Champ obligatoire (défaut: true)
- `maxlength` : Longueur maximale (défaut: 10)

## Fichiers Implémentés

### 1. Composants Blade
- **`resources/views/components/price.blade.php`** : Composant pour l'affichage des prix
- **`resources/views/components/phone-input.blade.php`** : Composant pour les champs de téléphone

### 2. JavaScript
- **`public/js/price-formatter.js`** : Formatage automatique des montants

### 3. Vues Mises à Jour
- **`resources/views/admin/sessions/index.blade.php`** : Liste des sessions avec prix formatés
- **`resources/views/admin/sessions/create.blade.php`** : Création de session avec champ prix amélioré
- **`resources/views/admin/sessions/edit.blade.php`** : Modification de session avec champ prix amélioré
- **`resources/views/admin/trainers/create.blade.php`** : Création de formateur avec validation téléphone
- **`resources/views/admin/trainers/edit.blade.php`** : Modification de formateur avec validation téléphone

### 4. Layouts
- **`resources/views/layouts/app.blade.php`** : Intégration du JavaScript de formatage
- **`resources/views/components/layouts.blade.php`** : Intégration du JavaScript de formatage admin

## Utilisation

### Dans les Vues Blade

#### Affichage des Prix
```blade
<!-- Ancien code -->
<span>{{ number_format($session->price, 2) }} €</span>

<!-- Nouveau code avec composant -->
<x-price :amount="$session->price" currency="€" />

<!-- Ou avec data attributes pour formatage automatique -->
<span data-price="{{ $session->price }}">{{ $session->price }} €</span>
```

#### Champs de Téléphone
```blade
<!-- Ancien code -->
<input type="text" name="phone" class="form-control" value="{{ old('phone') }}">

<!-- Nouveau code avec composant -->
<x-phone-input name="phone" :value="old('phone')" :required="true" />
```

### Dans les Contrôleurs

Les contrôleurs n'ont pas besoin de modifications. Le formatage se fait automatiquement côté client.

### Dans le JavaScript

```javascript
// Formater un montant manuellement
const formattedPrice = formatMoney(1500, '€', 2);
console.log(formattedPrice); // "1 500,00 €"

// Utiliser l'API PriceFormatter
if (window.PriceFormatter) {
    const price = window.PriceFormatter.formatPrice(2500, '$', 2);
    console.log(price); // "2 500,00 $"
}

// Formater tous les montants d'une page
if (window.PriceFormatter) {
    window.PriceFormatter.formatAllMoneyValues();
}
```

## Formatage Automatique

Le système détecte automatiquement et formate les montants dans :

- **Classes CSS** : `.price-display`, `.formation-price`, `.session-price`, `.cart-total`, etc.
- **Attributs data** : `data-price`, `data-amount`
- **Contenu de texte** : Recherche automatique des montants dans le texte
- **Tableaux** : Cellules contenant des montants
- **Formulaires** : Champs de saisie de prix

## Validation des Téléphones

### Règles de Validation
1. **Longueur exacte** : 10 chiffres (ni plus, ni moins)
2. **Caractères autorisés** : Uniquement les chiffres 0-9
3. **Pas de formatage** : Pas de tirets, espaces ou autres caractères
4. **Validation en temps réel** : Feedback immédiat

### Exemples
- ✅ **Valides** : 690123456, 691234567, 692345678
- ❌ **Invalides** : 69012345 (8 chiffres), 6901234567 (11 chiffres), 690-123-456 (tirets)

### Messages d'Erreur
- **Trop court** : "Le numéro de téléphone doit contenir exactement 10 chiffres."
- **Trop long** : Limitation automatique à 10 chiffres
- **Caractères invalides** : Suppression automatique des caractères non autorisés

## Personnalisation

### Couleurs des Prix

Modifiez les styles dans `price.blade.php` :

```css
.price-display[data-currency="€"] {
    color: #198754; /* Vert pour l'euro */
}

.price-display[data-currency="$"] {
    color: #0d6efd; /* Bleu pour le dollar */
}

.price-display[data-currency="F CFA"] {
    color: #fd7e14; /* Orange pour le F CFA */
}
```

### Formatage des Montants

Modifiez la fonction `formatPrice` dans `price-formatter.js` :

```javascript
function formatPrice(amount, currency = '€', decimals = 2) {
    // Utiliser la locale française par défaut
    const formattedAmount = numAmount.toLocaleString('fr-FR', {
        minimumFractionDigits: decimals,
        maximumFractionDigits: decimals
    });
    
    return formattedAmount + ' ' + currency;
}
```

### Validation des Téléphones

Modifiez la longueur maximale dans `phone-input.blade.php` :

```blade
@props(['name', 'value' => '', 'placeholder' => '+237 6XX XXX XXX', 'required' => false, 'maxlength' => 10])
```

## Test

Un fichier de test complet est disponible :

**`public/test-price-phone.html`**

Ce fichier permet de tester :
- ✅ Formatage automatique des prix
- ✅ Validation des numéros de téléphone
- ✅ Utilisation des composants Blade
- ✅ Responsive design
- ✅ Différentes devises

## Compatibilité

- **Navigateurs** : Chrome, Firefox, Safari, Edge (versions modernes)
- **Laravel** : 10.x
- **PHP** : 8.1+
- **JavaScript** : ES6+ (avec fallback pour ES5)

## Support

Pour toute question ou problème :

1. **Vérifiez la console** du navigateur pour les erreurs JavaScript
2. **Testez avec le fichier** `test-price-phone.html`
3. **Vérifiez que** `price-formatter.js` est bien chargé
4. **Assurez-vous que** les composants Blade sont disponibles

## Évolutions Futures

- [ ] Support des devises personnalisées
- [ ] Formatage des pourcentages et ratios
- [ ] Validation des numéros de téléphone internationaux
- [ ] Masques de saisie pour les téléphones
- [ ] Intégration avec les APIs de conversion de devises
- [ ] Support des montants négatifs et des soldes


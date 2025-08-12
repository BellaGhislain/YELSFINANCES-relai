@props(['amount', 'currency' => '€', 'decimals' => 2, 'locale' => 'fr_FR'])

@php
    // Formater le montant avec séparateurs de milliers
    $formattedAmount = number_format($amount, $decimals, ',', ' ');
    
    // Ajouter la devise
    $displayPrice = $formattedAmount . ' ' . $currency;
@endphp

<span class="price-display" data-amount="{{ $amount }}" data-currency="{{ $currency }}">
    {{ $displayPrice }}
</span>

<style>
.price-display {
    font-weight: 600;
    color: #198754;
    font-family: 'Inter', sans-serif;
}

.price-display[data-currency="€"] {
    color: #198754;
}

.price-display[data-currency="$"] {
    color: #0d6efd;
}

.price-display[data-currency="F CFA"] {
    color: #fd7e14;
}
</style>


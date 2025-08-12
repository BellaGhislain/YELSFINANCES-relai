@component('mail::message')
# Confirmation de votre commande

Bonjour {{ $order->first_name }} {{ $order->last_name }},

Merci pour votre commande chez YEL'S FINANCES ! Voici les détails de votre commande :

**Numéro de commande** : FP{{ $order->id }}
**Date** : {{ \Carbon\Carbon::now()->format('d/m/Y') }}
**E-mail** : {{ $order->email }}
**Téléphone** : {{ $order->phone ?? 'Non fourni' }}
**Entreprise** : {{ $order->company ?? 'Non fournie' }}

## Détails de la commande
@foreach ($orderDetails as $detail)
- **Formation** : {{ $detail->session->formation->name }}
  **Période** : {{ \Carbon\Carbon::parse($detail->session->start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($detail->session->end_date)->format('d/m/Y') }}
  **Prix** : {{ $detail->price }} F CFA
  **Quantité** : {{ $detail->quantity }}
@endforeach

**Total** : {{ $order->total_price }} F CFA

## Prochaines étapes
Vous recevrez bientôt des instructions pour accéder à vos formations. Pour toute question, contactez-nous à contact@yelsfinances.com ou au +33 XX XX XX XX.

Merci de votre confiance !

L'équipe YEL'S FINANCES

@component('mail::button', ['url' => url('/contact')])
Contacter le support
@endcomponent

@endcomponent

<x-client-layouts>
    <section class="confirmation-section">
        <div class="container">
            <h2>Commande confirmée</h2>
            <p>Merci pour votre commande, {{ $order->first_name }} {{ $order->last_name }} !</p>
            <p>Numéro de commande : FP{{ $order->id }}</p>
            <p>Un e-mail de confirmation a été envoyé à {{ $order->email }}.</p>

            <h3>Détails de la commande</h3>
            <ul>
                @foreach ($order->orderDetails as $detail)
                    <li>
                        <strong>{{ $detail->session->formation->name }}</strong><br>
                        Période : {{ \Carbon\Carbon::parse($detail->session->start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($detail->session->end_date)->format('d/m/Y') }}<br>
                        Prix : {{ $detail->price }} F CFA<br>
                        Quantité : {{ $detail->quantity }}
                    </li>
                @endforeach
            </ul>
            <p><strong>Total : {{ $order->total_price }} F CFA</strong></p>
            <a href="{{ url('/') }}" class="btn btn-primary">Retour à l'accueil</a>
        </div>
    </section>
</x-client-layouts>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Liste des paiements</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .badge { padding: 4px 8px; border-radius: 4px; }
        .badge-success { background-color: #e6f7e6; color: #28a745; }
        .badge-warning { background-color: #fff3cd; color: #ffc107; }
        .badge-danger { background-color: #f8d7da; color: #dc3545; }
    </style>
</head>
<body>
    <h1>Liste des paiements</h1>
    <table>
        <thead>
            <tr>
                <th>Participant</th>
                <th>Date</th>
                <th>Formation</th>
                <th>Session</th>
                <th>Statut de paiement</th>
                <th>Méthode de paiement</th>
                <th>Montant</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $payment)
                <tr>
                    <td>{{ $payment->order->first_name }} {{ $payment->order->last_name }}</td>
                    <td>{{ \Carbon\Carbon::parse($payment->created_at)->locale('fr')->translatedFormat('d F Y H:i') }}</td>
                    <td>{{ $payment->order->orderDetails->first()->formation->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($payment->order->orderDetails->first()->session->start_date)->locale('fr')->translatedFormat('j F Y') }} - {{ \Carbon\Carbon::parse($payment->order->orderDetails->first()->session->end_date)->locale('fr')->translatedFormat('j F Y') }}</td>
                    <td>
                        <span class="badge {{ $payment->status === 'completed' ? 'badge-success' : ($payment->status === 'pending' ? 'badge-warning' : 'badge-danger') }}">
                            {{ $payment->status === 'completed' ? 'Payé' : ($payment->status === 'pending' ? 'En attente' : 'Échoué') }}
                        </span>
                    </td>
                    <td>{{ $payment->payment_method ? ($payment->payment_method . ' •••• ' . substr($payment->payment_method, -4)) : 'N/A' }}</td>
                    <td>{{ number_format($payment->amount, 0, ',', ' ') }} €</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

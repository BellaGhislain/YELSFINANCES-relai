<!DOCTYPE html>
<html>
<head>
    <title>
        Participants à la session
        {{ is_object($session) && isset($session->formation) ? $session->formation->name : 'Formation inconnue' }}
        -
        {{
            is_object($session) && isset($session->start_date) && isset($session->end_date)
                ? (\Carbon\Carbon::parse($session->start_date)->locale('fr')->translatedFormat('d F Y') . ' - ' . \Carbon\Carbon::parse($session->end_date)->locale('fr')->translatedFormat('d F Y'))
                : 'Dates inconnues'
        }}
    </title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 16px; }
        h1 { text-align: center; font-size: 18px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 9px; }
        th, td { border: 1px solid #ddd; padding: 2px 4px; text-align: left; }
        th { background-color: #f2f2f2; font-size: 10px; }
    </style>
</head>
<body>
    <h1>
        Participants à la session
        {{ is_object($session) && isset($session->formation) ? $session->formation->name : 'Formation inconnue' }}
        -
        {{
            is_object($session) && isset($session->start_date) && isset($session->end_date)
                ? (\Carbon\Carbon::parse($session->start_date)->locale('fr')->translatedFormat('d F Y') . ' - ' . \Carbon\Carbon::parse($session->end_date)->locale('fr')->translatedFormat('d F Y'))
                : 'Dates inconnues'
        }}
    </h1>
    <table>
        <thead>
            <tr>
                <th>Prénom</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Pays</th>
                <th>Entreprise</th>
                <th>Formation</th>
                <th>Prix total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendees as $attendee)
                <tr>
                    <td>{{ $attendee['Prénom'] }}</td>
                    <td>{{ $attendee['Nom'] }}</td>
                    <td>{{ $attendee['Email'] }}</td>
                    <td>{{ $attendee['Téléphone'] }}</td>
                    <td>{{ $attendee['Pays'] }}</td>
                    <td>{{ $attendee['Entreprise'] }}</td>
                    <td>{{ $attendee['Formation'] }}</td>
                    <td>{{ $attendee['Prix total'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

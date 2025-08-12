<!doctype html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/svg+xml" href="/vite.svg" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>YEL'S FINANCES - {{ $pageTitle ?? 'Accueil' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/assets/client/css/style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
  </head>
  <body>
    <!-- Header -->
    <header class="header">
      <nav class="nav">
        <div class="nav-brand">
          <i class="fas fa-graduation-cap"></i>
          <span>YEL'S FINANCES</span>
        </div>
        
        <div class="nav-menu">
          <a href="{{ route('client.index.alias') }}" class="nav-link">Accueil</a>
          <a href="{{ route('client.formation') }}" class="nav-link">Produits</a>
          <a href="{{ route('client.a-propos') }}" class="nav-link">À propos</a>
          <a href="{{ route('client.contact') }}" class="nav-link">Contact</a>
        </div>
      </nav>
    </header>

    {{ $slot }}

    <script src="/assets/client/js/main.js"></script>
    <script src="/assets/client/js/cart.js"></script>
    <script src="/assets/client/js/counter.js"></script>
    <script src="/assets/client/js/parallax.js"></script>
    <script src="/assets/client/js/formations.js"></script>
  </body>
</html>





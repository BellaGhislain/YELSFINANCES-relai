<!doctype html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/svg+xml" href="/vite.svg" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>YEL'S FINANCES - {{ $pageTitle ?? 'Accueil' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/client/css/style.css') }}">
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
          <a href="{{ route('client.index.alias') }}" class="nav-link active">Accueil</a>
          <a href="{{ route('client.formation') }}" class="nav-link">Produits</a>
          <a href="{{ route('client.a-propos') }}" class="nav-link">À propos</a>
          <a href="{{ route('client.contact') }}" class="nav-link">Contact</a>
        </div>

        <div class="nav-actions">
          <div class="search-box">
            <input type="text" id="searchInput" placeholder="Rechercher une formation...">
            <i class="fas fa-search"></i>
          </div>
          
          <button class="cart-btn" id="cartBtn">
            <i class="fas fa-shopping-cart"></i>
            <span class="cart-count" id="cartCount">0</span>
          </button>
        </div>

        <button class="cart-btn mobile-cart-btn" id="cartBtnMobile">
          <i class="fas fa-shopping-cart"></i>
          <span class="cart-count" id="cartCountMobile">0</span>
        </button>

        <button class="mobile-menu-btn" id="mobileMenuBtn">
          <i class="fas fa-bars"></i>
        </button>
      </nav>
      
      <!-- Overlay pour la sidebar mobile -->
      <div class="mobile-sidebar-overlay" id="mobileSidebarOverlay"></div>
      
      <!-- Sidebar Mobile -->
      <div class="mobile-sidebar" id="mobileSidebar">
        <div class="mobile-sidebar-header">
          <h3>Menu</h3>
          <button class="mobile-sidebar-close" id="mobileSidebarClose">
            <i class="fas fa-times"></i>
          </button>
        </div>
        
        <div class="mobile-sidebar-content">
          <div class="nav-menu">
            <a href="{{ route('client.index.alias') }}" class="nav-link active">
              <i class="fas fa-home"></i>
              Accueil
            </a>
            <a href="{{ route('client.formation') }}" class="nav-link">
              <i class="fas fa-graduation-cap"></i>
              Produits
            </a>
            <a href="{{ route('client.a-propos') }}" class="nav-link">
              <i class="fas fa-info-circle"></i>
              À propos
            </a>
            <a href="{{ route('client.contact') }}" class="nav-link">
              <i class="fas fa-envelope"></i>
              Contact
            </a>
          </div>
          
          <div class="nav-actions">
            <div class="search-box">
              <input type="text" id="searchInputMobile" placeholder="Rechercher une formation...">
              <i class="fas fa-search"></i>
            </div>
            
            <button class="cart-btn" id="cartBtnMobile">
              <i class="fas fa-shopping-cart"></i>
              <span class="cart-count" id="cartCountMobile">0</span>
              Mon Panier
            </button>
          </div>
        </div>
      </div>
    </header>

         @yield('content')

    <!-- Footer -->
    <footer class="footer">
      <div class="container">
        <div class="footer-content">
          <div class="footer-section">
            <h4>YEL'S FINANCES</h4>
            <p>Votre partenaire pour l'excellence professionnelle</p>
            <div class="social-links">
              <a href="#"><i class="fab fa-facebook"></i></a>
              <a href="#"><i class="fab fa-twitter"></i></a>
              <a href="#"><i class="fab fa-linkedin"></i></a>
              <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
          </div>
          <div class="footer-section">
            <h4>Formations</h4>
            <a href="{{ route('client.formation') }}">Développement Web</a>
            <a href="{{ route('client.formation') }}">Marketing Digital</a>
            <a href="{{ route('client.formation') }}">Data Science</a>
            <a href="{{ route('client.formation') }}">Design</a>
          </div>
          <div class="footer-section">
            <h4>Support</h4>
            <a href="#">Centre d'aide</a>
            <a href="{{ route('client.contact') }}">Contact</a>
            <a href="#">FAQ</a>
            <a href="#">Conditions</a>
          </div>
          <div class="footer-section">
            <h4>Contact</h4>
            <p><i class="fas fa-envelope"></i> contact@yelsfinances.com</p>
            <p><i class="fas fa-phone"></i> +33 1 23 45 67 89</p>
            <p><i class="fas fa-map-marker-alt"></i> 123 Rue de la Formation, Paris</p>
          </div>
        </div>
        <div class="footer-bottom">
          <p>&copy; 2025 YEL'S FINANCES. Tous droits réservés.</p>
        </div>
      </div>
    </footer>


    <!-- Cart Modal -->
    <div class="modal" id="cartModal">
      <div class="modal-content">
        <div class="modal-header">
          <h3>Votre Panier</h3>
          <button class="close-btn" id="closeCartBtn">
            <i class="fas fa-times"></i>
          </button>
        </div>
        <div class="modal-body" id="cartItems">
          <!-- Les articles du panier seront générés par JavaScript -->
        </div>
        <div class="modal-footer">
          <div class="cart-total">
            <strong>Total: <span id="cartTotal">0 €</span></strong>
          </div>
          <div class="cart-actions">
            <button class="btn btn-secondary" id="clearCartBtn">Vider le panier</button>
            <button class="btn btn-primary" id="checkoutBtn">Commander</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Checkout Modal -->
    <div class="modal" id="checkoutModal">
      <div class="modal-content">
        <div class="modal-header">
          <h3>Finaliser la commande</h3>
          <button class="close-btn" id="closeCheckoutBtn">
            <i class="fas fa-times"></i>
          </button>
        </div>
        <div class="modal-body">
          <form id="checkoutForm" class="checkout-form">
            <div class="form-group">
              <label for="lastName">Nom *</label>
              <input type="text" id="lastName" name="lastName" required>
            </div>
            <div class="form-group">
              <label for="firstName">Prénom *</label>
              <input type="text" id="firstName" name="firstName" required>
            </div>
            <div class="form-group">
              <label for="email">Email *</label>
              <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
              <label for="lastName">Pays</label>
              <input type="text" id="country" name="country">
            </div>
            <div class="form-group">
              <label for="phone">Téléphone</label>
              <input type="tel" id="phone" name="phone">
            </div>
            <div class="form-group">
              <label for="company">Entreprise</label>
              <input type="text" id="company" name="company">
            </div>
            <div class="checkout-summary">
              <h4>Résumé de la commande</h4>
              <div id="checkoutItems"></div>
              <div class="checkout-total">
                <strong>Total: <span id="checkoutTotal">0 €</span></strong>
              </div>
            </div>
            <button type="submit" class="btn btn-primary btn-full">Confirmer la commande</button>
          </form>
        </div>
      </div>
    </div>

    <script src="{{ asset('assets/client/js/main.js') }}"></script>
    <script src="{{ asset('assets/client/js/cart.js') }}"></script>
    <script src="{{ asset('assets/client/js/counter.js') }}"></script>
    <script src="{{ asset('assets/client/js/parallax.js') }}"></script>
    <script src="{{ asset('assets/client/js/formations.js') }}"></script>
  </body>
</html>

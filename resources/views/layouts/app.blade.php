<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>YEL'S FINANCES - {{ $pageTitle ?? 'Accueil' }}</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="/vite.svg">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
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
                <a href="{{ route('client.index.alias') }}" class="nav-link {{ request()->routeIs('client.index.alias') ? 'active' : '' }}">Accueil</a>
                <a href="{{ route('client.formation') }}" class="nav-link {{ request()->routeIs('client.formation') ? 'active' : '' }}">Produits</a>
                <a href="{{ route('client.a-propos') }}" class="nav-link {{ request()->routeIs('client.a-propos') ? 'active' : '' }}">À propos</a>
                <a href="{{ route('client.contact') }}" class="nav-link {{ request()->routeIs('client.contact') ? 'active' : '' }}">Contact</a>
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
                    <a href="{{ route('client.index.alias') }}" class="nav-link {{ request()->routeIs('client.index.alias') ? 'active' : '' }}">
                        <i class="fas fa-home"></i>
                        Accueil
                    </a>
                    <a href="{{ route('client.formation') }}" class="nav-link {{ request()->routeIs('client.formation') ? 'active' : '' }}">
                        <i class="fas fa-graduation-cap"></i>
                        Produits
                    </a>
                    <a href="{{ route('client.a-propos') }}" class="nav-link {{ request()->routeIs('client.a-propos') ? 'active' : '' }}">
                        <i class="fas fa-info-circle"></i>
                        À propos
                    </a>
                    <a href="{{ route('client.contact') }}" class="nav-link {{ request()->routeIs('client.contact') ? 'active' : '' }}">
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

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h4>YEL'S FINANCES</h4>
                    <p>Votre partenaire de confiance pour l'excellence professionnelle. Des formations de qualité dans les domaines du digital, du business et de la tech.</p>
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
                    <p><i class="fas fa-map-marker-alt"></i> 123 Rue de la Formation, 75001 Paris</p>
                    <p><i class="fas fa-phone"></i> +33 1 23 45 67 89</p>
                    <p><i class="fas fa-envelope"></i> contact@yelsfinances.com</p>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2024 YEL'S FINANCES. Tous droits réservés.</p>
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
                    <strong>Total: <span id="cartTotal">0 F CFA</span></strong>
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
                        <label for="firstName">Prénom *</label>
                        <input type="text" id="firstName" required>
                    </div>
                    <div class="form-group">
                        <label for="lastName">Nom *</label>
                        <input type="text" id="lastName" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" id="email" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Téléphone</label>
                        <input type="tel" id="phone">
                    </div>
                    <div class="form-group">
                        <label for="company">Entreprise</label>
                        <input type="text" id="company">
                    </div>
                    <div class="checkout-summary">
                        <h4>Résumé de la commande</h4>
                        <div id="checkoutItems"></div>
                        <div class="checkout-total">
                            <strong>Total: <span id="checkoutTotal">0 F CFA</span></strong>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-full">Confirmer la commande</button>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript Files -->
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/cart.js') }}"></script>
    <script src="{{ asset('js/counter.js') }}"></script>
    <script src="{{ asset('js/parallax.js') }}"></script>
    <script src="{{ asset('js/formations.js') }}"></script>
    <script src="{{ asset('js/header.js') }}"></script>
    <script src="{{ asset('js/faq.js') }}"></script>
    <script src="{{ asset('js/contact.js') }}"></script>
    <script src="{{ asset('js/price-formatter.js') }}"></script>
</body>
</html>

class CartManager {
  constructor() {
    this.cart = this.loadCart();
    this.updateCartDisplay();
  }

  loadCart() {
    const saved = localStorage.getItem('formapro_cart');
    return saved ? JSON.parse(saved) : [];
  }

  saveCart() {
    localStorage.setItem('formapro_cart', JSON.stringify(this.cart));
  }

  async addToCart(sessionId) {
    try {
      const existingItem = this.cart.find(item => item.id === sessionId);
      if (existingItem) {
        this.showMessage('Cette session est déjà dans votre panier !', 'warning');
        return false;
      }

      const response = await fetch('/api/addToCart', {
        method: 'POST',
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
        },
        body: JSON.stringify({ session_id: sessionId }),
      });

      if (!response.ok) {
        const errorData = await response.json();
        throw new Error(errorData.message || 'Erreur serveur lors de l\'ajout au panier');
      }

      const data = await response.json();
      const formation = window.formations.find(f => f.id === sessionId);

      if (!formation) {
        throw new Error('Formation non trouvée dans les données locales');
      }

      this.cart.push({
        id: formation.id,
        title: formation.title,
        price: formation.price,
        image: formation.photo,
        session: formation.session,
        start_date: formation.start_date,
        end_date: formation.end_date,
        instructor: formation.instructor,
        quantity: 1,
      });

      this.saveCart();
      this.updateCartDisplay();
      this.renderCartItems();
      this.showMessage(data.message, 'success');
      return true;
    } catch (error) {
      console.error('Erreur lors de l\'ajout au panier:', error);
      this.showMessage(error.message || 'Erreur lors de l\'ajout au panier', 'error');
      return false;
    }
  }

  removeFromCart(sessionId) {
    this.cart = this.cart.filter(item => item.id !== sessionId);
    this.saveCart();
    this.updateCartDisplay();
    this.renderCartItems();
    this.showMessage('Session retirée du panier !', 'success');
  }

  clearCart() {
    this.cart = [];
    this.saveCart();
    this.updateCartDisplay();
    this.renderCartItems();
    this.showMessage('Panier vidé !', 'success');
  }

  getTotal() {
    return this.cart.reduce((total, item) => total + item.price * item.quantity, 0);
  }

  updateCartDisplay() {
    const cartCount = document.getElementById('cartCount');
    if (cartCount) {
      cartCount.textContent = this.cart.reduce((sum, item) => sum + item.quantity, 0);
      cartCount.style.display = this.cart.length > 0 ? 'flex' : 'none';
    }
  }

  renderCartItems() {
    const cartItems = document.getElementById('cartItems');
    const cartTotal = document.getElementById('cartTotal');

    if (!cartItems) return;

    if (this.cart.length === 0) {
      cartItems.innerHTML = `
        <div class="empty-cart">
          <i class="fas fa-shopping-cart"></i>
          <p>Votre panier est vide</p>
        </div>
      `;
      if (cartTotal) cartTotal.textContent = '0 €';
      return;
    }

    cartItems.innerHTML = this.cart.map(item => `
      <div class="cart-item">
        <div class="cart-item-image" style="background-image: url('${item.image}')"></div>
        <div class="cart-item-info">
          <div class="cart-item-title">${item.title}</div>
          <div class="cart-item-price">${item.price} €</div>
        </div>
        <button class="remove-item-btn" onclick="cartManager.removeFromCart(${item.id})">
          <i class="fas fa-trash-alt"></i>
        </button>
      </div>
    `).join('');

    if (cartTotal) cartTotal.textContent = `${this.getTotal()} €`;
  }

  renderCheckoutItems() {
    const checkoutItems = document.getElementById('checkoutItems');
    const checkoutTotal = document.getElementById('checkoutTotal');

    if (!checkoutItems) return;

    checkoutItems.innerHTML = this.cart.map(item => `
      <div class="checkout-item">
        <div class="checkout-item-content">
          <span>${item.title}</span>
          <span>${item.price} € x ${item.quantity}</span>
        </div>
        <div class="checkout-item-session">
          <i class="fas fa-calendar-alt"></i> Session du ${item.start_date} au ${item.end_date}
        </div>
      </div>
    `).join('');

    if (checkoutTotal) checkoutTotal.textContent = `${this.getTotal()} €`;
  }

  async processCheckout(formData) {
    try {
      const response = await fetch('/api/checkout', {
        method: 'POST',
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
        },
        body: JSON.stringify(formData),
      });

      if (!response.ok) {
        const errorData = await response.json();
        throw new Error(errorData.error || 'Erreur serveur lors du checkout');
      }

      const data = await response.json();
      if (data.paymentUrl) {
        // Rediriger vers la page de paiement CoolPay
        window.location.href = data.paymentUrl;
        return {
          success: true,
          orderId: data.orderId,
          message: data.message,
        };
      } else {
        throw new Error('URL de paiement non fournie');
      }
    } catch (error) {
      console.error('Erreur lors du checkout:', error);
      return {
        success: false,
        message: error.message || 'Erreur lors du traitement de la commande',
      };
    }
  }

  showMessage(message, type = 'success') {
    const existingMessages = document.querySelectorAll('.success-message');
    existingMessages.forEach(msg => msg.remove());

    const messageEl = document.createElement('div');
    messageEl.className = `success-message ${type}`;
    messageEl.innerHTML = `
      <i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'warning' ? 'fa-exclamation-triangle' : 'fa-times-circle'}"></i>
      ${message}
    `;

    document.body.appendChild(messageEl);

    setTimeout(() => {
      messageEl.remove();
    }, 3000);
  }
}

const cartManager = new CartManager();

// Gestion du panier
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

  addToCart(formationId) {
    const formation = formations.find(f => f.id === formationId);
    if (!formation) return false;

    // Vérifier si la formation est déjà dans le panier
    const existingItem = this.cart.find(item => item.id === formationId);
    if (existingItem) {
      this.showMessage('Cette formation est déjà dans votre panier!', 'warning');
      return false;
    }

    this.cart.push({
      id: formation.id,
      title: formation.title,
      price: formation.price,
      image: formation.image
    });

    this.saveCart();
    this.updateCartDisplay();
    this.showMessage('Formation ajoutée au panier!', 'success');
    return true;
  }

  removeFromCart(formationId) {
    this.cart = this.cart.filter(item => item.id !== formationId);
    this.saveCart();
    this.updateCartDisplay();
    this.renderCartItems();
  }

  clearCart() {
    this.cart = [];
    this.saveCart();
    this.updateCartDisplay();
    this.renderCartItems();
  }

  getTotal() {
    return this.cart.reduce((total, item) => total + item.price, 0);
  }

  updateCartDisplay() {
    const cartCount = document.getElementById('cartCount');
    const cartCountMobile = document.getElementById('cartCountMobile');
    
    if (cartCount) {
      cartCount.textContent = this.cart.length;
      cartCount.style.display = this.cart.length > 0 ? 'flex' : 'none';
    }
    
    if (cartCountMobile) {
      cartCountMobile.textContent = this.cart.length;
      cartCountMobile.style.display = this.cart.length > 0 ? 'flex' : 'none';
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
      if (cartTotal) cartTotal.textContent = '0F';
      return;
    }

    cartItems.innerHTML = this.cart.map(item => `
      <div class="cart-item">
        <div class="cart-item-image" style="background-image: url('${item.image}')"></div>
        <div class="cart-item-info">
          <div class="cart-item-title">${item.title}</div>
          <div class="cart-item-price">${item.price} F CFA</div>
        </div>
        <button class="remove-item-btn" onclick="cartManager.removeFromCart(${item.id})">
          <i class="fas fa-trash-alt"></i>
        </button>
      </div>
    `).join('');

          if (cartTotal) cartTotal.textContent = `${this.getTotal()} F CFA`;
  }

  renderCheckoutItems() {
    const checkoutItems = document.getElementById('checkoutItems');
    const checkoutTotal = document.getElementById('checkoutTotal');

    if (!checkoutItems) return;

    checkoutItems.innerHTML = this.cart.map(item => {
      const formation = formations.find(f => f.id === item.id);
      return `
        <div class="checkout-item">
          <div class="checkout-item-content">
            <span>${item.title}</span>
            <span>${item.price} F CFA</span>
          </div>
          <div class="checkout-item-session">
            <i class="fas fa-calendar-alt"></i> Date de début de session: ${formation ? formation.session : ''}
          </div>
        </div>
      `;
    }).join('');

    if (checkoutTotal) checkoutTotal.textContent = `${this.getTotal()} F CFA`;
  }

  showMessage(message, type = 'success') {
    // Supprimer les anciens messages
    const existingMessages = document.querySelectorAll('.success-message');
    existingMessages.forEach(msg => msg.remove());

    const messageEl = document.createElement('div');
    messageEl.className = `success-message ${type}`;
    messageEl.innerHTML = `
      <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle'}"></i>
      ${message}
    `;

    document.body.appendChild(messageEl);

    setTimeout(() => {
      messageEl.remove();
    }, 3000);
  }

  processCheckout(formData) {
    // Simulation du traitement de commande
    return new Promise((resolve) => {
      setTimeout(() => {
        // Ici, vous pourriez envoyer les données à votre backend
        console.log('Commande traitée:', {
          customer: formData,
          items: this.cart,
          total: this.getTotal()
        });

        this.clearCart();
        resolve({
          success: true,
          orderId: 'FP' + Date.now(),
          message: 'Votre commande a été confirmée avec succès!'
        });
      }, 2000);
    });
  }
}

// Initialiser le gestionnaire de panier
const cartManager = new CartManager();
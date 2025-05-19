document.addEventListener('DOMContentLoaded', function () {
  // Estado de la aplicación
  const state = {
    cart: [],
    showCart: false, // Estado para mostrar/ocultar el carrito
  };

  // Elementos del DOM
  const elements = {
    cartCount: document.querySelectorAll('.cart-count'),
    cartItemsContainer: document.querySelector('.cart-items-container'),
    emptyCartMessage: document.querySelector('.empty-cart-message'),
    cartTotal: document.querySelector('.cart-total'),
    cartDrawer: document.querySelector('.cart-drawer'), // Drawer del carrito
    backdrop: document.querySelector('.backdrop'), // Fondo semi-transparente
    toggleCartButtons: document.querySelectorAll('.toggle-cart'), // Botones para abrir/cerrar el carrito
    payButton: document.querySelector('#checkout-button'),
    clearCartButton: document.querySelector('#clear-cart-button'),
  };

  // Métodos para manipular el carrito
  const cartMethods = {
    addToCart: function (product) {
      const existingItem = state.cart.find((item) => item.id === product.id);

      if (existingItem) {
        existingItem.quantity += 1;
      } else {
        state.cart.push({
          id: product.id,
          name: product.name,
          price: product.price,
          image: product.image,
          quantity: 1,
        });
      }
      localStorage.setItem('cart', JSON.stringify(state.cart));
      updateCartUI();
    },

    removeItem: function (index) {
      state.cart.splice(index, 1);
      localStorage.setItem('cart', JSON.stringify(state.cart));
      updateCartUI();
    },

    updateQuantity: function (index, change) {
      state.cart[index].quantity += change;
      if (state.cart[index].quantity <= 0) {
        cartMethods.removeItem(index);
      } else {
        localStorage.setItem('cart', JSON.stringify(state.cart));
        updateCartUI();
      }
    },

    // Vaciar carrito
    clearCart: function () {
      state.cart = [];
      localStorage.setItem('cart', JSON.stringify(state.cart));
      updateCartUI();
    },

    cartTotal: function () {
      return state.cart
        .reduce((total, item) => total + item.price * item.quantity, 0)
        .toFixed(2);
    },

    cartCount: function () {
      return state.cart.reduce((total, item) => total + item.quantity, 0);
    },

    toggleCart: function () {
      state.showCart = !state.showCart;
      elements.cartDrawer.classList.toggle('open', state.showCart);
      elements.backdrop.classList.toggle('open', state.showCart);
      document.body.style.overflow = state.showCart ? 'hidden' : '';
    },
  };

  // Función para actualizar la interfaz de usuario del carrito
  function updateCartUI() {
    // Actualizar contador de elementos
    const count = cartMethods.cartCount();
    elements.cartCount.forEach((element) => {
      element.textContent = count;
      element.style.display = count > 0 ? 'flex' : 'none';
    });

    const mobileCartButton = document.querySelector('.cart-button.md\\:hidden');
    if (mobileCartButton) {
      mobileCartButton.style.display = count > 0 ? 'flex' : 'none';
    }

    // Mensaje de carrito vacío
    if (elements.emptyCartMessage) {
      elements.emptyCartMessage.style.display =
        state.cart.length === 0 ? 'flex' : 'none';
    }

    // Lista de ITEMS del carrito
    if (elements.cartItemsContainer) {
      elements.cartItemsContainer.innerHTML = '';
      state.cart.forEach((item, index) => {
        const itemElement = document.createElement('div');
        itemElement.className =
          'flex items-center py-3 border-b last:border-b-0';
        itemElement.innerHTML = `
          <div class="w-16 h-16 bg-gray-100 rounded overflow-hidden mr-3">
              <img src="${item.image}" alt="${
          item.name
        }" class="w-full h-full object-cover">
          </div>
          <div class="flex-1">
              <h3 class="font-medium text-sm">${item.name}</h3>
              <div class="flex justify-between items-center mt-2">
                  <div class="flex items-center bg-gray-100 rounded-lg">
                      <button 
                          class="quantity-decrease w-8 h-8 flex items-center justify-center text-gray-500 hover:text-gray-700"
                          data-index="${index}">
                          <i class="fas fa-minus text-xs"></i>
                      </button>
                      <span class="w-8 text-center">${item.quantity}</span>
                      <button 
                          class="quantity-increase w-8 h-8 flex items-center justify-center text-gray-500 hover:text-gray-700"
                          data-index="${index}">
                          <i class="fas fa-plus text-xs"></i>
                      </button>
                  </div>
                  <span class="font-medium">${(
                    item.price * item.quantity
                  ).toFixed(2)}€</span>
              </div>
          </div>
          <button 
              class="remove-item ml-2 text-gray-400 hover:text-red-500 p-2"
              data-index="${index}">
              <i class="fas fa-trash-alt"></i>
          </button>
        `;

        elements.cartItemsContainer.appendChild(itemElement);

        // Event listeners
        const decreaseBtn = itemElement.querySelector('.quantity-decrease');
        const increaseBtn = itemElement.querySelector('.quantity-increase');
        const removeBtn = itemElement.querySelector('.remove-item');

        decreaseBtn.addEventListener('click', () =>
          cartMethods.updateQuantity(index, -1)
        );
        increaseBtn.addEventListener('click', () =>
          cartMethods.updateQuantity(index, 1)
        );
        removeBtn.addEventListener('click', () =>
          cartMethods.removeItem(index)
        );
      });
    }

    // Actualizar el total
    if (elements.cartTotal) {
      elements.cartTotal.textContent = `${cartMethods.cartTotal()}€`;
    }

    // Habilitar/deshabilitar el botón de Stripe
    if (elements.payButton) {
      elements.payButton.disabled = state.cart.length === 0;
      elements.payButton.classList.toggle(
        'opacity-50',
        state.cart.length === 0
      );
    }
  }

  // Inicializar la aplicación
  function init() {
    // Cargar carrito desde localStorage
    const savedCart = localStorage.getItem('cart');
    if (savedCart) {
      state.cart = JSON.parse(savedCart);
    }

    // Botones para abrir/cerrar carrito
    elements.toggleCartButtons.forEach((button) => {
      button.addEventListener('click', cartMethods.toggleCart);
    });

    // Botones para agregar al carrito
    document.querySelectorAll('.add-to-cart').forEach((button) => {
      button.addEventListener('click', () => {
        const productData = JSON.parse(button.dataset.product);
        cartMethods.addToCart(productData);
      });
    });

    // Botón para vaciar el carrito
    if (elements.clearCartButton) {
      elements.clearCartButton.addEventListener('click', cartMethods.clearCart);
    }

    // Actualizar la interfaz
    updateCartUI();
  }

  // Iniciar la aplicación
  init();
});

import notificationSound from '../../audio/notification.mp3'; // Ajusta la ruta según tu estructura

document.addEventListener('DOMContentLoaded', function () {
  // Estado de la aplicación
  const state = {
    cart: [],
    showCart: false,
  };

  // Elementos del DOM
  const elements = {
    cartCount: document.querySelectorAll('.cart-count'), // Contadores de ítems (puede haber varios)
    cartItemsContainer: document.querySelector('.cart-items-container'),
    emptyCartMessage: document.querySelector('.empty-cart-message'),
    cartTotalDisplay: document.querySelector('.cart-total'), // Para mostrar el total al usuario
    cartTotalInput: document.getElementById('cart-total-input'), // Input oculto para el formulario
    cartDrawer: document.querySelector('.cart-drawer'),
    backdrop: document.querySelector('.backdrop'),
    toggleCartButtons: document.querySelectorAll('.toggle-cart'),
    clearCartButton: document.getElementById('clear-cart-button'),
    addToCartButtons: document.querySelectorAll('.add-to-cart'),
    cashPaymentForm: document.getElementById('cash-payment-form'),
    mobileCartButton: document.querySelector('.cart-button.md\\:hidden'), // Botón flotante móvil
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
          price: parseFloat(product.price), // Asegurar que el precio es un número
          image: product.image,
          quantity: 1,
        });
      }
      cartMethods.saveCart();
      updateCartUI();
    },

    removeItem: function (index) {
      state.cart.splice(index, 1);
      cartMethods.saveCart();
      updateCartUI();
    },

    updateQuantity: function (index, change) {
      if (state.cart[index]) {
        state.cart[index].quantity += change;
        if (state.cart[index].quantity <= 0) {
          cartMethods.removeItem(index);
        } else {
          cartMethods.saveCart();
          updateCartUI();
        }
      }
    },

    clearCart: function () {
      state.cart = [];
      cartMethods.saveCart();
      updateCartUI();
    },

    calculateTotal: function () {
      return state.cart.reduce(
        (total, item) => total + item.price * item.quantity,
        0
      );
    },

    cartCount: function () {
      return state.cart.reduce((total, item) => total + item.quantity, 0);
    },

    toggleCart: function () {
      state.showCart = !state.showCart;
      if (elements.cartDrawer)
        elements.cartDrawer.classList.toggle('open', state.showCart);
      if (elements.backdrop)
        elements.backdrop.classList.toggle('open', state.showCart);
      document.body.style.overflow = state.showCart ? 'hidden' : '';
    },

    saveCart: function () {
      localStorage.setItem('cart', JSON.stringify(state.cart));
    },

    loadCart: function () {
      const savedCart = localStorage.getItem('cart');
      if (savedCart) {
        try {
          const parsedCart = JSON.parse(savedCart);
          if (Array.isArray(parsedCart)) {
            state.cart = parsedCart.map((item) => ({
              ...item,
              price: parseFloat(item.price),
              quantity: parseInt(item.quantity, 10) || 1,
            }));
          } else {
            state.cart = [];
            localStorage.removeItem('cart');
          }
        } catch (e) {
          console.error('Error al parsear el carrito desde localStorage:', e);
          state.cart = [];
          localStorage.removeItem('cart');
        }
      }
    },
  };

  // Función para actualizar la interfaz de usuario del carrito
  function updateCartUI() {
    const count = cartMethods.cartCount();
    const totalValue = cartMethods.calculateTotal();
    const totalFormatted = totalValue.toFixed(2);

    // Actualizar contadores de ítems
    elements.cartCount.forEach((element) => {
      element.textContent = count;
      element.style.display = count > 0 ? 'flex' : 'none';
    });

    // Visibilidad del botón flotante móvil (el botón en sí, el contador interno ya se actualiza)
    if (elements.mobileCartButton) {
      elements.mobileCartButton.style.display = 'flex'; // O 'flex' si siempre debe estar visible y solo el contador cambia
    }

    // Mensaje de carrito vacío
    if (elements.emptyCartMessage) {
      elements.emptyCartMessage.style.display =
        state.cart.length === 0 ? 'flex' : 'none';
    }

    // Renderizar ítems del carrito
    if (elements.cartItemsContainer) {
      elements.cartItemsContainer.innerHTML = ''; // Limpiar
      state.cart.forEach((item, index) => {
        const itemElement = document.createElement('div');
        itemElement.className =
          'flex items-center py-3 border-b last:border-b-0';
        itemElement.innerHTML = `
          <div class="w-16 h-16 bg-gray-100 rounded overflow-hidden mr-3 flex-shrink-0">
              <img src="${item.image}" alt="${
          item.name
        }" class="w-full h-full object-cover" onerror="this.src='https://via.placeholder.com/64x64.png?text=No+Img'; this.alt='Imagen no disponible';">
          </div>
          <div class="flex-1 min-w-0">
              <h3 class="font-medium text-sm truncate" title="${item.name}">${
          item.name
        }</h3>
              <div class="flex justify-between items-center mt-2">
                  <div class="flex items-center bg-gray-100 rounded-lg">
                      <button class="quantity-decrease w-8 h-8 flex items-center justify-center text-gray-500 hover:text-gray-700" data-index="${index}"><i class="fas fa-minus text-xs"></i></button>
                      <span class="w-8 text-center text-sm">${
                        item.quantity
                      }</span>
                      <button class="quantity-increase w-8 h-8 flex items-center justify-center text-gray-500 hover:text-gray-700" data-index="${index}"><i class="fas fa-plus text-xs"></i></button>
                  </div>
                  <span class="font-medium text-sm whitespace-nowrap ml-2">${(
                    item.price * item.quantity
                  ).toFixed(2)}€</span>
              </div>
          </div>
          <button class="remove-item ml-2 text-gray-400 hover:text-red-500 p-2 flex-shrink-0" data-index="${index}"><i class="fas fa-trash-alt"></i></button>
        `;
        elements.cartItemsContainer.appendChild(itemElement);

        itemElement
          .querySelector('.quantity-decrease')
          .addEventListener('click', () =>
            cartMethods.updateQuantity(index, -1)
          );
        itemElement
          .querySelector('.quantity-increase')
          .addEventListener('click', () =>
            cartMethods.updateQuantity(index, 1)
          );
        itemElement
          .querySelector('.remove-item')
          .addEventListener('click', () => cartMethods.removeItem(index));
      });
    }

    // Actualizar total visible
    if (elements.cartTotalDisplay) {
      elements.cartTotalDisplay.textContent = `${totalFormatted}€`;
    }

    // Actualizar input oculto del total
    if (elements.cartTotalInput) {
      elements.cartTotalInput.value = totalFormatted;
    }

    // Habilitar/deshabilitar botón de pago en efectivo
    if (elements.cashPaymentForm) {
      const submitButton = elements.cashPaymentForm.querySelector(
        'button[type="submit"]'
      );
      if (submitButton) {
        const isEmpty = state.cart.length === 0;
        submitButton.disabled = isEmpty;
        submitButton.classList.toggle('opacity-50', isEmpty);
        submitButton.classList.toggle('cursor-not-allowed', isEmpty);
      }
    }
  }

  // Función para reproducir el sonido con opciones para debugging
  function playNotificationSound() {
    console.log('Intentando reproducir sonido...');

    try {
      // Crear elemento de audio
      const audio = new Audio();

      // Verificar si podemos usar un recurso importado o uno desde carpeta pública
      let audioSrc = '';
      try {
        audioSrc = notificationSound;
        console.log('Usando audio importado:', audioSrc);
      } catch (e) {
        // Si falla la importación, intentar con ruta pública
        audioSrc = '/audio/notification.mp3';
        console.log('Usando audio de carpeta pública:', audioSrc);
      }

      audio.src = audioSrc;
      audio.volume = 1.0; // Volumen máximo

      // Monitorear eventos para debugging
      audio.addEventListener('canplaythrough', () => {
        console.log('Audio listo para reproducirse');
      });

      audio.addEventListener('play', () => {
        console.log('Audio comenzó a reproducirse');
      });

      audio.addEventListener('error', (e) => {
        console.error('Error de audio:', e);
      });

      // Intentar reproducir
      const playPromise = audio.play();

      if (playPromise !== undefined) {
        playPromise
          .then(() => {
            console.log('Reproducción iniciada correctamente');
          })
          .catch((error) => {
            console.error('Error reproduciendo audio:', error);

            // Posible error por política de autoplay, intentar reproducir después de un evento de usuario
            document.addEventListener(
              'click',
              function playOnClick() {
                audio.play();
                document.removeEventListener('click', playOnClick);
              },
              { once: true }
            );
          });
      }
    } catch (e) {
      console.error('Error general al reproducir sonido:', e);
    }
  }

  // Inicializar la aplicación
  function init() {
    cartMethods.loadCart();

    elements.toggleCartButtons.forEach((button) => {
      button.addEventListener('click', (e) => {
        e.preventDefault();
        cartMethods.toggleCart();
      });
    });

    elements.addToCartButtons.forEach((button) => {
      button.addEventListener('click', () => {
        try {
          const productData = JSON.parse(button.dataset.product);
          if (productData && typeof productData.price !== 'undefined') {
            cartMethods.addToCart(productData);
          } else {
            console.error(
              'Datos del producto inválidos o precio no definido:',
              button.dataset.product
            );
          }
        } catch (e) {
          console.error(
            'Error al parsear datos del producto:',
            e,
            button.dataset.product
          );
        }
      });
    });

    if (elements.clearCartButton) {
      elements.clearCartButton.addEventListener('click', cartMethods.clearCart);
    }

    // MODIFICADO: Prevenir el envío inmediato del formulario para dar tiempo al audio
    if (elements.cashPaymentForm) {
      elements.cashPaymentForm.addEventListener('submit', function (e) {
        // Prevenir el envío del formulario para permitir que el audio se reproduzca
        e.preventDefault();

        // Verificar que hay artículos en el carrito
        if (state.cart.length === 0) {
          return; // No hacer nada si el carrito está vacío
        }

        // Intentar reproducir el sonido
        console.log('Procesando pago...');
        playNotificationSound();

        // Guardar referencia al formulario
        const form = this;

        // Enviar el formulario después de un retraso para dar tiempo al audio
        setTimeout(() => {
          console.log('Enviando formulario...');
          form.submit();
        }, 1000); // Esperar 1 segundo
      });
    }

    updateCartUI();
  }

  // Iniciar la aplicación
  init();
});

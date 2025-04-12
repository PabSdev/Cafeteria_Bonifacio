// Archivo: public/js/shopping.js
document.addEventListener('DOMContentLoaded', function () {
    // Estado de la aplicación
    const state = {
        showCart: false,
        cart: [],
        activeCategory: 'all',
        initialized: false,
        paymentRequest: null,
        googlePayClient: null,
        googlePayAvailable: false,
    }

    // Elemento del documento que mostrarán datos dinámicos
    const elements = {
        cartCount: document.querySelectorAll('.cart-count'),
        cartDrawer: document.querySelector('.cart-drawer'),
        backdrop: document.querySelector('.backdrop'),
        categoriesButtons: document.querySelectorAll('.category-button'),
        productItems: document.querySelectorAll('.product-item'),
        cartItemsContainer: document.querySelector('.cart-items-container'),
        emptyCartMessage: document.querySelector('.empty-cart-message'),
        cartTotal: document.querySelector('.cart-total'),
        payButton: document.querySelector('.pay-button'),
    }

    // Métodos para manipular el carrito
    const cartMethods = {
        addToCart: function (product) {
            const existingItem = state.cart.find(
                (item) => item.id === product.id
            )

            if (existingItem) {
                existingItem.quantity += 1
            } else {
                state.cart.push({
                    id: product.id,
                    name: product.name,
                    price: product.price,
                    image: product.image,
                    quantity: 1,
                })
            }

            // Guardar en localStorage
            localStorage.setItem('cart', JSON.stringify(state.cart))

            // Actualizar la UI
            updateCartUI()
        },

        removeItem: function (index) {
            state.cart.splice(index, 1)
            localStorage.setItem('cart', JSON.stringify(state.cart))
            updateCartUI()
        },

        updateQuantity: function (index, change) {
            state.cart[index].quantity += change

            if (state.cart[index].quantity <= 0) {
                cartMethods.removeItem(index)
            } else {
                localStorage.setItem('cart', JSON.stringify(state.cart))
                updateCartUI()
            }
        },

        cartTotal: function () {
            return state.cart
                .reduce((total, item) => total + item.price * item.quantity, 0)
                .toFixed(2)
        },

        cartCount: function () {
            return state.cart.reduce((total, item) => total + item.quantity, 0)
        },

        toggleCart: function () {
            state.showCart = !state.showCart
            document.body.style.overflow = state.showCart ? 'hidden' : ''

            // Actualizar la UI
            elements.cartDrawer.classList.toggle('open', state.showCart)
            elements.backdrop.classList.toggle('open', state.showCart)
        },
    }

    // Métodos para Google Pay
    const paymentMethods = {
        initGooglePay: function () {
            // Cargar Google Pay solo si hay productos en el carrito
            if (state.cart.length === 0) return

            const baseRequest = {
                apiVersion: 2,
                apiVersionMinor: 0,
            }

            const allowedCardNetworks = ['MASTERCARD', 'VISA']
            const allowedCardAuthMethods = ['PAN_ONLY', 'CRYPTOGRAM_3DS']

            const tokenizationSpecification = {
                type: 'PAYMENT_GATEWAY',
                parameters: {
                    gateway: 'example',
                    gatewayMerchantId: 'exampleGatewayMerchantId',
                },
            }

            const baseCardPaymentMethod = {
                type: 'CARD',
                parameters: {
                    allowedAuthMethods: allowedCardAuthMethods,
                    allowedCardNetworks: allowedCardNetworks,
                },
            }

            const cardPaymentMethod = Object.assign(
                { tokenizationSpecification: tokenizationSpecification },
                baseCardPaymentMethod
            )

            const paymentDataRequest = Object.assign({}, baseRequest)
            paymentDataRequest.allowedPaymentMethods = [cardPaymentMethod]
            paymentDataRequest.transactionInfo = {
                totalPriceStatus: 'FINAL',
                totalPrice: cartMethods.cartTotal(),
                currencyCode: 'EUR',
                countryCode: 'ES',
            }
            paymentDataRequest.merchantInfo = {
                merchantName: 'Cafetería Bonifacio',
                merchantId: '01234567890123456789',
            }

            state.paymentRequest = paymentDataRequest

            // Inicializar cliente de Google Pay
            state.googlePayClient = new google.payments.api.PaymentsClient({
                environment: 'TEST', // Cambiar a 'PRODUCTION' en producción
                paymentDataCallbacks: {
                    onPaymentAuthorized: paymentMethods.onPaymentAuthorized,
                },
            })

            // Comprobar si Google Pay está disponible para el usuario
            state.googlePayClient
                .isReadyToPay(baseRequest)
                .then((response) => {
                    state.googlePayAvailable = response.result
                    updatePayButtonUI()
                })
                .catch((error) => {
                    console.error('Error al verificar Google Pay:', error)
                })
        },

        onPaymentAuthorized: function (paymentData) {
            // Aquí procesaríamos el pago en el servidor
            console.log('Pago autorizado:', paymentData)

            // Simular una respuesta exitosa
            return {
                transactionState: 'SUCCESS',
            }
        },

        processGooglePayment: function () {
            if (!state.googlePayAvailable || !state.googlePayClient) {
                alert('Google Pay no está disponible en este momento.')
                return
            }

            // Actualizar el importe por si ha cambiado
            state.paymentRequest.transactionInfo.totalPrice =
                cartMethods.cartTotal()

            state.googlePayClient
                .loadPaymentData(state.paymentRequest)
                .then((paymentData) => {
                    // Aquí procesaríamos el pago exitoso
                    console.log('Pago completado', paymentData)

                    // Limpiar carrito después del pago exitoso
                    state.cart = []
                    localStorage.removeItem('cart')

                    // Cerrar el drawer del carrito
                    state.showCart = false
                    document.body.style.overflow = ''
                    elements.cartDrawer.classList.remove('open')
                    elements.backdrop.classList.remove('open')

                    // Actualizar UI
                    updateCartUI()

                    // Mensaje de éxito
                    alert('¡Pago completado con éxito! Gracias por tu compra.')
                })
                .catch((error) => {
                    console.error('Error en el pago:', error)
                })
        },
    }

    // Función para actualizar la interfaz de usuario del carrito
    function updateCartUI() {
        // Actualizar contador de elementos
        const count = cartMethods.cartCount()
        elements.cartCount.forEach((element) => {
            element.textContent = count
            element.style.display = count > 0 ? 'flex' : 'none'
        })

        // Actualizar mensaje de carrito vacío
        if (elements.emptyCartMessage) {
            elements.emptyCartMessage.style.display =
                state.cart.length === 0 ? 'flex' : 'none'
        }

        // Actualizar items del carrito
        if (elements.cartItemsContainer) {
            elements.cartItemsContainer.innerHTML = ''

            state.cart.forEach((item, index) => {
                const itemElement = document.createElement('div')
                itemElement.className =
                    'flex items-center py-3 border-b last:border-b-0'
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
                                <span class="w-8 text-center">${
                                    item.quantity
                                }</span>
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
                `

                elements.cartItemsContainer.appendChild(itemElement)

                // Agregar event listeners para los botones
                const decreaseBtn =
                    itemElement.querySelector('.quantity-decrease')
                const increaseBtn =
                    itemElement.querySelector('.quantity-increase')
                const removeBtn = itemElement.querySelector('.remove-item')

                decreaseBtn.addEventListener('click', () =>
                    cartMethods.updateQuantity(index, -1)
                )
                increaseBtn.addEventListener('click', () =>
                    cartMethods.updateQuantity(index, 1)
                )
                removeBtn.addEventListener('click', () =>
                    cartMethods.removeItem(index)
                )
            })
        }

        // Actualizar el total
        if (elements.cartTotal) {
            elements.cartTotal.textContent = `${cartMethods.cartTotal()}€`
        }

        // Actualizar el pie del carrito
        const cartFooter = document.querySelector('.cart-footer')
        if (cartFooter) {
            cartFooter.style.display = state.cart.length > 0 ? 'block' : 'none'
        }

        // Mostrar/ocultar botón flotante en móvil
        const floatingCartBtn = document.querySelector('.cart-button')
        if (floatingCartBtn) {
            floatingCartBtn.style.display = count > 0 ? 'flex' : 'none'
        }
    }

    // Actualizar UI del botón de pago
    function updatePayButtonUI() {
        if (!elements.payButton) return

        if (state.googlePayAvailable) {
            elements.payButton.innerHTML = `
                <button class="w-full flex justify-center items-center py-3 bg-black text-white rounded-lg font-medium hover:bg-gray-900 transition-colors">
                    <svg class="mr-2 h-6" viewBox="0 0 103 45" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12.3 15.6v7.8h3.3c1.8 0 3.3-1.3 3.3-3.9s-1.5-3.9-3.3-3.9h-3.3zm0 10.5v-13h3.3c3.4 0 6.1 2.5 6.1 6.5s-2.7 6.5-6.1 6.5h-3.3z" fill="#ffffff"/>
                        <path d="M28.8 26.1l-3.4-13h2.9l2.2 9.3 2.2-9.3h2.9l-3.5 13h-3.3z" fill="#ffffff"/>
                        <path d="M44 17.4c-1.8 0-3.3 1.4-3.3 3.1 0 1.7 1.5 3.1 3.3 3.1s3.3-1.4 3.3-3.1c0-1.7-1.5-3.1-3.3-3.1zm0 8.7c-3.1 0-5.6-2.5-5.6-5.6s2.5-5.6 5.6-5.6 5.6 2.5 5.6 5.6-2.5 5.6-5.6 5.6z" fill="#ffffff"/>
                        <path d="M60.1 17.4c-1.8 0-3.3 1.4-3.3 3.1 0 1.7 1.5 3.1 3.3 3.1s3.3-1.4 3.3-3.1c0-1.7-1.5-3.1-3.3-3.1zm0 8.7c-3.1 0-5.6-2.5-5.6-5.6s2.5-5.6 5.6-5.6 5.6 2.5 5.6 5.6-2.5 5.6-5.6 5.6z" fill="#ffffff"/>
                        <path d="M74.3 26.1v-5.6c0-3.1 1.8-5.6 5.4-5.6 1.6 0 2.7.5 3.4 1.2l-1.4 1.4c-.5-.5-1.1-.8-2-.8-1.9 0-3.1 1.3-3.1 3.8v5.6h-2.3z" fill="#ffffff"/>
                        <path d="M98 18.3c-.5-.5-1.4-1-2.4-1-2.2 0-3.3 1.7-3.3 3.1 0 1.4 1.1 3.1 3.3 3.1 1 0 1.9-.5 2.4-1v.8c0 1.7-1 2.5-2.4 2.5-1.2 0-2.2-.5-2.8-1.4l-1.6 1.6c1 1.4 2.5 2.1 4.4 2.1 2.5 0 4.7-1.5 4.7-4.8v-8.1H98v1.1zm-2.2 3.1c-1.1 0-2-.8-2-1.9 0-1.1.9-1.9 2-1.9 1.1 0 2 .8 2 1.9 0 1.1-.9 1.9-2 1.9z" fill="#ffffff"/>
                        <path d="M87.4 17.4c-1.7 0-3.4.7-4.2 2.1l1.7 1.1c.5-.7 1.2-1.1 2.5-1.1 1.4 0 2.2.8 2.2 1.9v.4h-3.3c-2.5 0-3.9 1.3-3.9 3.2 0 1.9 1.6 3.2 3.7 3.2 1.5 0 2.6-.7 3.3-1.5v1.2h2.3v-6.4c.1-2.8-1.7-4.1-4.3-4.1zm-2.7 7.6c0-.8.7-1.3 1.7-1.3h2.7c0 1.3-1.2 2.4-2.7 2.4-1 0-1.7-.6-1.7-1.1z" fill="#ffffff"/>
                    </svg>
                    Pagar con Google Pay
                </button>
            `
            elements.payButton.addEventListener(
                'click',
                paymentMethods.processGooglePayment
            )
        } else {
            elements.payButton.innerHTML = `
                <button class="w-full py-3 bg-amber-500 text-white rounded-lg font-medium hover:bg-amber-600 transition-colors">
                    Completar Pedido
                </button>
            `
        }
    }

    // Filtrar productos por categoría
    function filterProductsByCategory(category) {
        state.activeCategory = category

        // Actualizar botones de categoría
        elements.categoriesButtons.forEach((button) => {
            if (button.dataset.category === category) {
                button.classList.add('active')
            } else {
                button.classList.remove('active')
            }
        })

        // Mostrar/ocultar productos según la categoría
        elements.productItems.forEach((product) => {
            const productCategory = product.dataset.category

            if (category === 'all' || productCategory === category) {
                product.style.display = 'flex'
                // Agregar animación
                setTimeout(() => {
                    product.style.opacity = '1'
                    product.style.transform = 'scale(1)'
                }, 10)
            } else {
                product.style.opacity = '0'
                product.style.transform = 'scale(0.95)'
                setTimeout(() => {
                    product.style.display = 'none'
                }, 200)
            }
        })
    }

    // Inicializar la aplicación
    function init() {
        if (state.initialized) return

        // Cargar carrito desde localStorage
        const savedCart = localStorage.getItem('cart')
        if (savedCart) {
            state.cart = JSON.parse(savedCart)
        }

        // Inicializar event listeners

        // Botones de categoría
        elements.categoriesButtons.forEach((button) => {
            button.addEventListener('click', () => {
                filterProductsByCategory(button.dataset.category)
            })
        })

        // Botones para abrir/cerrar el carrito
        document.querySelectorAll('.toggle-cart').forEach((button) => {
            button.addEventListener('click', cartMethods.toggleCart)
        })

        // Botones para agregar al carrito
        document.querySelectorAll('.add-to-cart').forEach((button) => {
            button.addEventListener('click', () => {
                const productData = JSON.parse(button.dataset.product)
                cartMethods.addToCart(productData)
            })
        })

        // Inicializar Google Pay después de cargar el carrito
        if (typeof google !== 'undefined' && google.payments) {
            setTimeout(() => {
                paymentMethods.initGooglePay()
            }, 100)
        }

        // Actualizar la interfaz
        updateCartUI()

        state.initialized = true
    }

    // Iniciar la aplicación
    init()
})

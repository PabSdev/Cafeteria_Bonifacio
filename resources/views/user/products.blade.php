<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cafetería Bonifacio - Compras</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9fafb;
        }
        .header {
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .product-card {
            transition: transform 0.2s;
            border-radius: 12px;
        }
        .product-card:hover {
            transform: translateY(-5px);
        }
        .cart-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #f59e0b;
            color: white;
            border-radius: 50%;
            width: 56px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            z-index: 50;
        }
        .cart-drawer {
            position: fixed;
            top: 0;
            right: 0;
            height: 100vh;
            width: 85%;
            max-width: 400px;
            background-color: white;
            box-shadow: -4px 0 15px rgba(0, 0, 0, 0.1);
            z-index: 100;
            transform: translateX(100%);
            transition: transform 0.3s ease-in-out;
        }
        .cart-drawer.open {
            transform: translateX(0);
        }
        .category-button {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            transition: all 0.2s;
            white-space: nowrap;
        }
        .category-button.active {
            background-color: #f59e0b;
            color: white;
            font-weight: 500;
        }
        .backdrop {
            position: fixed;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 90;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }
        .backdrop.open {
            opacity: 1;
            pointer-events: auto;
        }
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>
<body x-data="{
    showCart: false,
    cart: [],
    activeCategory: 'all',
    initialized: false,
    
    addToCart(product) {
        const existingItem = this.cart.find(item => item.id === product.id);
        
        if (existingItem) {
            existingItem.quantity += 1;
        } else {
            this.cart.push({
                id: product.id,
                name: product.name,
                price: product.price,
                image: product.image,
                quantity: 1
            });
        }
        
        // Guardar en localStorage
        localStorage.setItem('cart', JSON.stringify(this.cart));
    },
    
    removeItem(index) {
        this.cart.splice(index, 1);
        localStorage.setItem('cart', JSON.stringify(this.cart));
    },
    
    updateQuantity(index, change) {
        this.cart[index].quantity += change;
        
        if (this.cart[index].quantity <= 0) {
            this.removeItem(index);
        } else {
            localStorage.setItem('cart', JSON.stringify(this.cart));
        }
    },
    
    cartTotal() {
        return this.cart.reduce((total, item) => total + (item.price * item.quantity), 0).toFixed(2);
    },
    
    cartCount() {
        return this.cart.reduce((total, item) => total + item.quantity, 0);
    },
    
    toggleCart() {
        this.showCart = !this.showCart;
        document.body.style.overflow = this.showCart ? 'hidden' : '';
    },
    
    init() {
        if (!this.initialized) {
            // Cargar carrito desde localStorage solo una vez
            const savedCart = localStorage.getItem('cart');
            if (savedCart) {
                this.cart = JSON.parse(savedCart);
            }
            this.initialized = true;
        }
    }
}" x-init="init()" x-cloak>
    <!-- Header simplificado -->
    <header class="header p-4 sticky top-0 z-10">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Espacio vacío a la izquierda en móvil -->
            <div class="w-8 md:w-auto">
                <!-- Vacío en móvil, logo en desktop -->
                <a href="/" class="text-xl font-bold text-amber-600 hidden md:block">
                    <i class="fas fa-coffee mr-2"></i>Bonifacio
                </a>
            </div>
            
            <!-- Logo centrado en móvil -->
            <div class="text-center md:hidden">
                <a href="/" class="text-xl font-bold text-amber-600">
                    <i class="fas fa-coffee mr-2"></i>Bonifacio
                </a>
            </div>
            
            <!-- Espacio vacío a la derecha en móvil, carrito en desktop -->
            <div class="w-8 md:w-auto">
                <div class="relative hidden md:block">
                    <span 
                        class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center"
                        x-text="cartCount()"
                        x-show="cartCount() > 0">
                    </span>
                    <button @click="toggleCart()" class="text-gray-700 hover:text-amber-600">
                        <i class="fas fa-shopping-cart text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Contenedor principal con padding inferior para el botón flotante -->
    <div class="container mx-auto px-4 pb-20">
        <!-- Categorías scrollables horizontalmente -->
        <div class="mb-6 -mx-4 px-4 overflow-x-auto no-scrollbar">
            <div class="flex space-x-3 py-2">
                <button 
                    @click="activeCategory = 'all'" 
                    :class="{'active': activeCategory === 'all'}"
                    class="category-button bg-gray-100 hover:bg-gray-200">
                    Todos
                </button>
                @foreach($products->pluck('categoria')->unique() as $categoria)
                    <button 
                        @click="activeCategory = '{{ $categoria }}'" 
                        :class="{'active': activeCategory === '{{ $categoria }}'}"
                        class="category-button bg-gray-100 hover:bg-gray-200">
                        {{ $categoria }}
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Lista de Productos -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    @foreach($products as $product)
        <div 
            x-show="activeCategory === 'all' || activeCategory === '{{ $product->categoria }}'"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform scale-95"
            x-transition:enter-end="opacity-100 transform scale-100"
            class="product-card bg-white shadow-md overflow-hidden h-full flex flex-col">
            <div class="relative pb-[56.25%] overflow-hidden">
                <img 
                    src="{{ $product->imagen }}" 
                    alt="{{ $product->nombre_producto }}" 
                    class="absolute inset-0 w-full h-full object-cover"
                    onerror="this.src='https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcRdWpuXXMLg0LPElV_NtRAJyhTd4opH9Rx8F6Elh0JM0FUTkK7bQjXdte0vG0AUwUNUJFOa8VPx-CTBQ_8pR1dOsA'"
                >
            </div>
            <div class="p-4 flex-1 flex flex-col">
                <div class="flex justify-between items-start mb-2">
                    <h3 class="font-medium text-base truncate flex-1">{{ $product->nombre_producto }}</h3>
                    <span class="font-bold text-amber-600 text-base whitespace-nowrap ml-2">{{ number_format($product->precio, 2) }}€</span>
                </div>
                <p class="text-gray-500 text-sm line-clamp-2 mb-auto">{{ $product->description }}</p>
                <button 
                    @click="addToCart({
                        id: {{ $product->id }},
                        name: '{{ $product->nombre_producto }}',
                        price: {{ $product->precio }},
                        image: '{{ $product->imagen }}',
                        quantity: 1
                    })"
                    class="mt-4 w-full py-2.5 bg-amber-500 text-white text-sm rounded-lg hover:bg-amber-600 flex items-center justify-center gap-2">
                    <i class="fas fa-plus text-xs"></i> Añadir
                </button>
            </div>
        </div>
    @endforeach
</div>

    <!-- Botón flotante de carrito (visible SOLO en móvil) -->
    <button 
        @click="toggleCart()" 
        class="cart-button md:hidden"
        x-show="cart.length > 0">
        <i class="fas fa-shopping-cart text-xl"></i>
        <span 
            class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center"
            x-text="cartCount()">
        </span>
    </button>

    <!-- Fondo semi-transparente -->
    <div 
        @click="toggleCart()" 
        class="backdrop" 
        :class="{'open': showCart}">
    </div>

    <!-- Drawer del carrito (desliza desde la derecha) -->
    <div class="cart-drawer" :class="{'open': showCart}">
        <div class="h-full flex flex-col">
            <!-- Cabecera del carrito -->
            <div class="p-4 border-b flex justify-between items-center">
                <h2 class="text-lg font-bold">Tu Carrito</h2>
                <button @click="toggleCart()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Lista de productos en el carrito -->
            <div class="flex-1 overflow-y-auto p-4">
                <template x-if="cart.length === 0">
                    <div class="flex flex-col items-center justify-center h-full text-center">
                        <i class="fas fa-shopping-cart text-gray-300 text-5xl mb-4"></i>
                        <p class="text-gray-500">Tu carrito está vacío</p>
                        <button 
                            @click="toggleCart()" 
                            class="mt-4 px-4 py-2 bg-gray-200 text-gray-800 rounded-lg">
                            Explorar productos
                        </button>
                    </div>
                </template>

                <template x-for="(item, index) in cart" :key="index">
                    <div class="flex items-center py-3 border-b last:border-b-0">
                        <div class="w-16 h-16 bg-gray-100 rounded overflow-hidden mr-3">
                            <img :src="item.image" :alt="item.name" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1">
                            <h3 class="font-medium text-sm" x-text="item.name"></h3>
                            <div class="flex justify-between items-center mt-2">
                                <div class="flex items-center bg-gray-100 rounded-lg">
                                    <button 
                                        @click="updateQuantity(index, -1)" 
                                        class="w-8 h-8 flex items-center justify-center text-gray-500 hover:text-gray-700">
                                        <i class="fas fa-minus text-xs"></i>
                                    </button>
                                    <span class="w-8 text-center" x-text="item.quantity"></span>
                                    <button 
                                        @click="updateQuantity(index, 1)" 
                                        class="w-8 h-8 flex items-center justify-center text-gray-500 hover:text-gray-700">
                                        <i class="fas fa-plus text-xs"></i>
                                    </button>
                                </div>
                                <span class="font-medium" x-text="`${(item.price * item.quantity).toFixed(2)}€`"></span>
                            </div>
                        </div>
                        <button 
                            @click="removeItem(index)" 
                            class="ml-2 text-gray-400 hover:text-red-500 p-2">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </template>
            </div>

            <!-- Pie del carrito con total y botón de pago -->
            <div class="p-4 border-t bg-gray-50" x-show="cart.length > 0">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-gray-600">Total:</span>
                    <span class="font-bold text-xl" x-text="`${cartTotal()}€`"></span>
                </div>
                <button class="w-full py-3 bg-amber-500 text-white rounded-lg font-medium hover:bg-amber-600 transition-colors">
                    Completar Pedido
                </button>
            </div>
        </div>
    </div>
</body>
</html>
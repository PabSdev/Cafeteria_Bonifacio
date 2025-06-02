<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cafetería Bonifacio - Compras</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://pay.google.com/gp/p/js/pay.js"></script>
    @vite('resources/css/shopping.css')
    <style>
        /* Estilo para el botón de categoría activo */
        .category-button.active {
            @apply bg-amber-500 text-white shadow-md;
        }
        /* Scrollbar personalizado para categorías (opcional) */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
    </style>
</head>
<body class="bg-gray-50 font-['Poppins',_sans-serif]">
    <!-- Header -->
    <header class="bg-white shadow-sm p-4 sticky top-0 z-20">
        <div class="container mx-auto flex justify-between items-center">
            <div class="w-8 md:w-auto">
                <a href="/" class="text-xl font-bold text-amber-600 hidden md:flex items-center">
                    <i class="fas fa-coffee mr-2"></i>Bonifacio
                </a>
            </div>
            <div class="text-center md:hidden">
                <a href="/" class="text-xl font-bold text-amber-600 flex items-center">
                    <i class="fas fa-coffee mr-2"></i>Bonifacio
                </a>
            </div>
            <div class="w-auto">
                <div class="relative hidden md:block">
                    <button class="toggle-cart text-gray-700 hover:text-amber-600 flex items-center space-x-2 px-3 py-2 rounded-md hover:bg-amber-50 transition-colors">
                        <i class="fas fa-shopping-cart text-xl"></i>
                        <span class="hidden lg:inline font-medium">Carrito</span>
                        <span class="cart-count absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center" style="display: none;">0</span>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Contenedor principal -->
    <div class="container mx-auto px-4 py-8 pb-24">
        <!-- Categorías -->
        <div class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Categorías</h2>
            <div class="no-scrollbar overflow-x-auto pb-2">
                <div class="flex space-x-3">
                    <button
                        class="category-button px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200 ease-in-out focus:outline-none bg-white hover:bg-gray-200 shadow-sm border border-gray-200"
                        data-category="all">
                        Todos
                    </button>
                    @foreach($products->pluck('categoria')->unique()->filter() as $categoria)
                        <button
                            class="category-button px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200 ease-in-out focus:outline-none bg-white hover:bg-gray-200 shadow-sm border border-gray-200"
                            data-category="{{ $categoria }}">
                            {{ $categoria }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Lista de Productos -->
        <div>
            <h2 class="text-2xl font-semibold text-gray-700 mb-6">Nuestros Productos</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <div
                        class="product-item product-card bg-white shadow-lg rounded-xl overflow-hidden h-full flex flex-col group hover:shadow-2xl transition-all duration-300 ease-in-out"
                        data-category="{{ $product->categoria }}"
                        style="opacity: 1; transform: scale(1);">
                        <div class="relative pb-[56.25%] overflow-hidden"> <!-- 16:9 Aspect Ratio -->
                            <img
                                src="{{ $product->imagen }}"
                                alt="{{ $product->nombre_producto }}"
                                class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-300 ease-in-out"
                                onerror="this.src='https://via.placeholder.com/300x200.png?text=Imagen+no+disponible'; this.alt='Imagen no disponible';"
                            >
                        </div>
                        <div class="p-5 flex-1 flex flex-col">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="font-semibold text-lg text-gray-800 group-hover:text-amber-600 transition-colors duration-200 flex-1 truncate" title="{{ $product->nombre_producto }}">{{ $product->nombre_producto }}</h3>
                                <span class="font-bold text-amber-600 text-lg whitespace-nowrap ml-3">{{ number_format($product->precio, 2) }}€</span>
                            </div>
                            <p class="text-gray-600 text-sm line-clamp-3 mb-4 flex-grow">{{ $product->description }}</p>
                            <button
                                class="add-to-cart mt-auto w-full py-3 px-4 bg-amber-500 text-white text-base font-medium rounded-lg hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-opacity-50 flex items-center justify-center gap-2 transition-colors duration-200 ease-in-out"
                                data-product='{
                                    "id": {{ $product->id }},
                                    "name": "{{ $product->nombre_producto }}",
                                    "price": {{ $product->precio }},
                                    "image": "{{ $product->imagen }}",
                                    "quantity": 1
                                }'>
                                <i class="fas fa-cart-plus"></i> Añadir al Carrito
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Botón flotante de carrito (visible SOLO en móvil) -->
    <button class="toggle-cart cart-button md:hidden fixed bottom-6 right-6 bg-amber-500 text-white w-14 h-14 rounded-full shadow-xl flex items-center justify-center z-30 hover:bg-amber-600 transition-colors">
        <i class="fas fa-shopping-cart text-2xl"></i>
        <span class="cart-count absolute -top-1 -right-1 bg-red-600 text-white text-xs font-bold rounded-full w-6 h-6 flex items-center justify-center border-2 border-white" style="display: none;">0</span>
    </button>

    <!-- Fondo semi-transparente -->
    <div class="backdrop toggle-cart fixed inset-0 bg-black bg-opacity-50 z-40" style="display: none;"></div>

    <!-- Drawer del carrito -->
    <div class="cart-drawer fixed top-0 right-0 w-full max-w-md h-full bg-white shadow-xl z-50 transform translate-x-full transition-transform duration-300 ease-in-out">
        <div class="h-full flex flex-col">
            <!-- Cabecera del carrito -->
            <div class="p-5 border-b flex justify-between items-center bg-gray-50">
                <h2 class="text-xl font-semibold text-gray-800">Tu Carrito</h2>
                <button class="toggle-cart text-gray-500 hover:text-gray-800 transition-colors p-2 rounded-full hover:bg-gray-200">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Lista de productos en el carrito -->
            <div class="flex-1 overflow-y-auto p-5">
                <div class="empty-cart-message flex-grow flex flex-col items-center justify-center h-full text-center" style="display: flex;">
                    <i class="fas fa-shopping-bag text-gray-300 text-7xl mb-6"></i>
                    <p class="text-gray-600 text-lg font-medium mb-2">Tu carrito está vacío</p>
                    <p class="text-gray-500 text-sm mb-6">Parece que aún no has añadido nada. ¡Explora nuestros productos!</p>
                    <button class="toggle-cart mt-4 px-6 py-3 bg-amber-500 text-white rounded-lg font-medium hover:bg-amber-600 transition-colors text-sm">
                        <i class="fas fa-store mr-2"></i>Explorar productos
                    </button>
                </div>
                <div class="cart-items-container">
                    <!-- Los items del carrito se insertarán aquí por JS -->
                </div>
            </div>

            <!-- Pie del carrito -->
            <div class="cart-footer p-5 border-t bg-gray-50">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-gray-700 font-medium text-lg">Total:</span>
                    <span class="cart-total font-bold text-2xl text-amber-600">0.00€</span>
                </div>
                <form id="cash-payment-form" action="{{ route('order.create') }}" method="POST" class="flex flex-col gap-4">
                    @csrf
                    <input
                        type="text"
                        name="customer_name"
                        placeholder="Introduce tu nombre completo"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-shadow"
                        required
                    >
                    <input type="hidden" name="cart_total" id="cart-total-input" value="0">
                    <button
                        type="submit"
                        class="w-full py-3 bg-green-500 text-white rounded-lg font-semibold text-base hover:bg-green-600 transition-colors focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="fas fa-money-bill-wave mr-2"></i>Pagar en efectivo
                    </button>
                </form>
                <button
                    id="clear-cart-button"
                    class="w-full py-3 bg-red-500 text-white rounded-lg font-medium hover:bg-red-600 transition-colors mt-3 text-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">
                    <i class="fas fa-trash-alt mr-2"></i>Vaciar Carrito
                </button>
            </div>
        </div>
    </div>

    <!-- Scripts personalizados -->
    @vite('resources/js/shopping/cart.js')
    @vite('resources/js/shopping/filter.js')
</body>
</html>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cafetería Bonifacio - Compras</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Añadir la librería de Google Pay -->
    <script src="https://pay.google.com/gp/p/js/pay.js"></script>
    @vite(['resources/css/shopping.css'])
</head>
<body>
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
                        class="cart-count absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center"
                        style="display: none;">
                        0
                    </span>
                    <button class="toggle-cart text-gray-700 hover:text-amber-600">
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
                    class="category-button bg-gray-100 hover:bg-gray-200 active"
                    data-category="all">
                    Todos
                </button>
                @foreach($products->pluck('categoria')->unique() as $categoria)
                    <button 
                        class="category-button bg-gray-100 hover:bg-gray-200"
                        data-category="{{ $categoria }}">
                        {{ $categoria }}
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Lista de Productos -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($products as $product)
                <div 
                    class="product-item product-card bg-white shadow-md overflow-hidden h-full flex flex-col"
                    data-category="{{ $product->categoria }}"
                    style="transition: all 0.2s ease; opacity: 1; transform: scale(1);">
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
                            class="add-to-cart mt-4 w-full py-2.5 bg-amber-500 text-white text-sm rounded-lg hover:bg-amber-600 flex items-center justify-center gap-2"
                            data-product='{
                                "id": {{ $product->id }},
                                "name": "{{ $product->nombre_producto }}",
                                "price": {{ $product->precio }},
                                "image": "{{ $product->imagen }}",
                                "quantity": 1
                            }'>
                            <i class="fas fa-plus text-xs"></i> Añadir
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Botón flotante de carrito (visible SOLO en móvil) -->
    <button 
        class="toggle-cart cart-button md:hidden"
        style="display: none;">
        <i class="fas fa-shopping-cart text-xl"></i>
        <span class="cart-count absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
            0
        </span>
    </button>

    <!-- Fondo semi-transparente -->
    <div class="backdrop toggle-cart"></div>

    <!-- Drawer del carrito (desliza desde la derecha) -->
    <div class="cart-drawer">
        <div class="h-full flex flex-col">
            <!-- Cabecera del carrito -->
            <div class="p-4 border-b flex justify-between items-center">
                <h2 class="text-lg font-bold">Tu Carrito</h2>
                <button class="toggle-cart text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Lista de productos en el carrito -->
            <div class="flex-1 overflow-y-auto p-4">
                <!-- Mensaje de carrito vacío -->
                <div class="empty-cart-message flex flex-col items-center justify-center h-full text-center">
                    <i class="fas fa-shopping-cart text-gray-300 text-5xl mb-4"></i>
                    <p class="text-gray-500">Tu carrito está vacío</p>
                    <button 
                        class="toggle-cart mt-4 px-4 py-2 bg-gray-200 text-gray-800 rounded-lg">
                        Explorar productos
                    </button>
                </div>

                <!-- Contenedor dinámico de items del carrito -->
                <div class="cart-items-container"></div>
            </div>

            <!-- Pie del carrito con total y botón de pago -->
            <div class="cart-footer p-4 border-t bg-gray-50" style="display: none;">
                <div class="flex justify-between items-center mb-4">
                    <span class="text-gray-600">Total:</span>
                    <span class="cart-total font-bold text-xl">0.00€</span>
                </div>
                <div class="pay-button"></div>
            </div>
        </div>
    </div>

    <!-- Script para la lógica del carrito -->
    @vite(['resources/js/shopping.js'])
</body>
</html>
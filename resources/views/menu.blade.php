<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuestro Menú</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;700&display=swap"
        rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @vite('resources/css/menu.css')
</head>
<body>
<div x-data="{
        activeCategory: 'all',
        categories: ['all', {{ implode(',', $products->pluck('categoria')->unique()->map(fn($cat) => "'$cat'")->toArray()) }}]
    }"
     class="container mx-auto px-4 py-12">
    <!-- Header remains the same -->
    <div class="text-center mb-12 fade-in">
        <h1 class="menu-heading text-4xl md:text-6xl font-bold mb-2">Nuestro Menú</h1>
        <div class="h-1 w-24 bg-amber-400 mx-auto my-4"></div>
        <p class="text-gray-600 max-w-2xl mx-auto">Descubre nuestra selección de platos preparados con ingredientes
            frescos y locales, inspirados en la tradición con un toque moderno.</p>
    </div>

    <!-- Dynamic categories navigation -->
    <div class="flex justify-center mb-10 overflow-x-auto scrollbar-hide">
        <div class="flex space-x-6 py-2">
            <template x-for="category in categories" :key="category">
                <button
                    @click="activeCategory = category"
                    :class="{'active': activeCategory === category, 'text-amber-600 font-bold': activeCategory === category}"
                    class="category-tab px-4 py-2 text-lg capitalize hover:text-amber-600 transition-colors duration-300"
                    x-text="category === 'all' ? 'Todos' : category">
                </button>
            </template>
        </div>
    </div>

    <!-- Menu Items -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 px-4">
        @foreach($products as $key => $product)
            <div
                x-show="activeCategory === 'all' || activeCategory === '{{ $product->categoria }}'"
                x-transition:enter="transition ease-out duration-500"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100"
                style="animation-delay: {{ $key * 0.1 }}s;"
                class="card-item bg-white rounded-lg overflow-hidden fade-in shadow-md hover:shadow-xl transition-shadow duration-300">
                <!-- Increased image height from h-48 to h-64 and improved object fitting -->
                <div class="h-64 overflow-hidden">
                    <img src="{{ $product->imagen }}" alt="{{ $product->nombre_producto }}"
                         class="w-full h-full object-cover transition-transform duration-500 hover:scale-105 food-image">
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="font-semibold text-xl">{{ $product->nombre_producto }}</h3>
                        <span class="font-bold text-amber-600">{{ $product->precio }}€</span>
                    </div>
                    <p class="text-gray-600 text-sm mb-3">{{ $product->description }}</p>
                    <div class="flex flex-wrap gap-2">
                        @if($product->stock <= 5 && $product->stock > 0)
                            <span class="tag">Últimas unidades</span>
                        @elseif($product->stock > 10)
                            <span class="tag">Disponible</span>
                        @elseif($product->stock <= 0)
                            <span class="tag bg-red-100 text-red-800">Agotado</span>
                        @endif
                        <span class="tag">{{ $product->categoria }}</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Footer  -->
    <div class="mt-16 text-center fade-in">
        <p class="text-gray-500 text-sm">Todos nuestros platos están elaborados con ingredientes de primera calidad.</p>
        <p class="text-gray-500 text-sm">Si tiene alguna alergia o restricción dietética, consulte con nuestro
            personal.</p>
    </div>
</div>

@vite('resources/js/menu/menu.js')
</body>
</html>

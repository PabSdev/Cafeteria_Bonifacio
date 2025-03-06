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
<div x-data="{ activeCategory: 'all', categories: ['all', 'entrantes', 'principales', 'postres', 'bebidas'] }"
     class="container mx-auto px-4 py-12">
    <!-- Header -->
    <div class="text-center mb-12 fade-in">
        <h1 class="menu-heading text-4xl md:text-6xl font-bold mb-2">Nuestro Menú</h1>
        <div class="h-1 w-24 bg-amber-400 mx-auto my-4"></div>
        <p class="text-gray-600 max-w-2xl mx-auto">Descubre nuestra selección de platos preparados con ingredientes
            frescos y locales, inspirados en la tradición con un toque moderno.</p>
    </div>

    <!-- Navegacion entre categorias -->
    <div class="flex justify-center mb-10 overflow-x-auto scrollbar-hide">
        <div class="flex space-x-6 py-2">
            <template x-for="category in categories" :key="category">
                <button
                    @click="activeCategory = category"
                    :class="{'active': activeCategory === category}"
                    class="category-tab px-4 py-2 text-lg capitalize hover:text-amber-600"
                    x-text="category === 'all' ? 'Todos' : category">
                </button>
            </template>
        </div>
    </div>

    <!-- Menu Items -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 px-4">
        <!-- Este template es para datos estáticos, pero deberías reemplazarlo con datos dinámicos de tu base de datos -->
        @foreach([
            ['name' => 'Patatas Bravas', 'price' => '6.50', 'description' => 'Crujientes patatas caseras cubiertas con nuestra salsa brava especial.', 'image' => 'https://source.unsplash.com/random/300x200/?patatas-bravas', 'category' => 'entrantes', 'tags' => ['Vegano', 'Popular']],
            ['name' => 'Croquetas de Jamón', 'price' => '7.50', 'description' => 'Cremosas por dentro y crujientes por fuera, hechas con jamón ibérico.', 'image' => 'https://source.unsplash.com/random/300x200/?croquettes', 'category' => 'entrantes', 'tags' => ['Popular']],
            ['name' => 'Paella Valenciana', 'price' => '16.90', 'description' => 'Auténtica paella con arroz, pollo, conejo y verduras de temporada.', 'image' => 'https://source.unsplash.com/random/300x200/?paella', 'category' => 'principales', 'tags' => ['Clásico']],
            ['name' => 'Lomo de Bacalao', 'price' => '18.50', 'description' => 'Bacalao confitado con crema de patata y aceite de pimentón.', 'image' => 'https://source.unsplash.com/random/300x200/?codfish', 'category' => 'principales', 'tags' => []],
            ['name' => 'Flan de Caramelo', 'price' => '5.90', 'description' => 'Suave y cremoso flan casero con caramelo líquido.', 'image' => 'https://source.unsplash.com/random/300x200/?flan', 'category' => 'postres', 'tags' => ['Casero']],
            ['name' => 'Sangría Casera', 'price' => '6.50', 'description' => 'Refrescante sangría preparada con vino tinto y frutas frescas.', 'image' => 'https://source.unsplash.com/random/300x200/?sangria', 'category' => 'bebidas', 'tags' => ['Recomendado']]
        ] as $key => $item)
            <div
                x-show="activeCategory === 'all' || activeCategory === '{{ $item['category'] }}'"
                x-transition:enter="transition ease-out duration-500"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100"
                style="animation-delay: {{ $key * 0.1 }}s;"
                class="card-item bg-white rounded-lg overflow-hidden fade-in">
                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-full food-image">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="font-semibold text-xl">{{ $item['name'] }}</h3>
                        <span class="font-bold text-amber-600">{{ $item['price'] }}€</span>
                    </div>
                    <p class="text-gray-600 text-sm mb-3">{{ $item['description'] }}</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach($item['tags'] as $tag)
                            <span class="tag">{{ $tag }}</span>
                        @endforeach
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

@vite('resources/js/menu.js')
</body>
</html>

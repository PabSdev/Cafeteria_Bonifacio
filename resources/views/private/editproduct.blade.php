@php use App\Models\Productos; @endphp
    <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir nuevo producto</title>
    @vite('resources/css/app.css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
<div class="min-h-screen flex flex-col">
    <!-- Header para el móvil -->
    <div class="lg:hidden bg-gray-800 text-white p-4 flex justify-between items-center">
        <h1 class="text-xl font-semibold">Panel de Administración</h1>
        <button id="mobile-menu-button" class="text-white">
            <i class="fas fa-bars text-xl"></i>
        </button>
    </div>

    <div class="flex flex-1">
        <!-- Sidebar - oculto en móvil por defecto -->
        <aside id="sidebar"
               class="w-64 bg-gray-800 text-white fixed h-full z-20 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
            <div class="p-6">
                <h1 class="text-2xl font-semibold">Panel de Administración</h1>
            </div>
            <nav class="mt-6">
                <div class="px-4 py-2 text-gray-300">
                    <p class="text-xs uppercase font-bold">Gestión</p>
                </div>
                <a href="{{ route('admin') }}"
                   class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    <span>Dashboard</span>
                </a>
                <a href="#users"
                   class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white">
                    <i class="fas fa-users mr-3"></i>
                    <span>Usuarios</span>
                </a>
                <a href="#products"
                   class="flex items-center px-6 py-3 text-white bg-gray-700">
                    <i class="fas fa-box mr-3"></i>
                    <span>Productos</span>
                </a>
                <div class="mt-auto px-4 py-2 text-gray-300">
                    <p class="text-xs uppercase font-bold">Cuenta</p>
                </div>
                <form action="{{ route('logout') }}" method="POST"
                      class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white">
                    @csrf
                    <i class="fas fa-sign-out-alt mr-3"></i>
                    <button type="submit">Cerrar sesión</button>
                </form>
            </nav>
        </aside>

        <!-- Contenido Principal -->
        <main class="flex-1 w-full lg:ml-64 p-4 lg:p-8">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-xl lg:text-3xl font-semibold text-gray-800">Editar Producto</h2>
                <div>
                    <a href="{{ route('admin') }}" class="text-blue-500 hover:text-blue-700">
                        <i class="fas fa-arrow-left mr-2"></i>Volver al Dashboard
                    </a>
                </div>
            </div>

            <!-- Formulario de Producto -->
            <section class="mb-12">
                <div class="bg-white rounded-lg shadow p-4 lg:p-6">
                    @if(session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                            <p>{{ session('success') }}</p>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('products.update', $product->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-6 mb-6">
                            <div>
                                <label for="nombre_producto"
                                       class="block text-xs lg:text-sm font-medium text-gray-700 mb-1">
                                    Nombre del Producto
                                </label>
                                <input type="text" name="nombre_producto" id="nombre_producto" required
                                       class="w-full p-2 border border-gray-300 rounded-md text-sm"
                                       value="{{ old('nombre_producto', $product->nombre_producto) }}" maxlength="50">
                                <p class="text-xs text-gray-500 mt-1">Máximo 50 caracteres</p>
                            </div>

                            <div>
                                <label for="precio" class="block text-xs lg:text-sm font-medium text-gray-700 mb-1">
                                    Precio
                                </label>
                                <input type="number" name="precio" id="precio" step="0.01" required
                                       class="w-full p-2 border border-gray-300 rounded-md text-sm"
                                       value="{{ old('precio', $product->precio) }}">
                                <p class="text-xs text-gray-500 mt-1">En euros (€)</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-6 mb-6">
                            <div>
                                <label for="stock" class="block text-xs lg:text-sm font-medium text-gray-700 mb-1">
                                    Stock
                                </label>
                                <input type="number" name="stock" id="stock" required
                                       class="w-full p-2 border border-gray-300 rounded-md text-sm"
                                       value="{{ old('stock', $product->stock) }}">
                                <p class="text-xs text-gray-500 mt-1">Cantidad disponible</p>
                            </div>

                            <div>
                                <label for="categoria" class="block text-xs lg:text-sm font-medium text-gray-700 mb-1">
                                    Categoría
                                </label>
                                <input type="text" name="categoria" id="categoria" required
                                       class="w-full p-2 border border-gray-300 rounded-md text-sm"
                                       value="{{ old('categoria', $product->categoria) }}">
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="imagen" class="block text-xs lg:text-sm font-medium text-gray-700 mb-1">
                                URL de la Imagen
                            </label>
                            <input type="text" name="imagen" id="imagen" required
                                   class="w-full p-2 border border-gray-300 rounded-md text-sm"
                                   value="{{ old('imagen', $product->imagen) }}">
                            <p class="text-xs text-gray-500 mt-1">URL única de la imagen</p>
                        </div>
                        <div class="flex items-center justify-between">
                            <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-sm lg:text-base">
                                <i class="fas fa-save mr-2"></i> Actualizar Producto
                            </button>
                            <a href="{{ route('admin') }}" class="text-gray-500 hover:text-gray-700 text-sm">
                                Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </section>
        </main>
    </div>
</div>

@vite("resources/js/porduct/responsiveaddproduct.js")
</body>
</html>

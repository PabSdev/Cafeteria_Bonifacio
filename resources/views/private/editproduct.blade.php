@php use App\Models\Productos; @endphp
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product</title>
    @vite('resources/css/app.css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
<div class="min-h-screen flex flex-col">
    <!-- Mobile Header -->
    <div class="lg:hidden bg-gray-800 text-white p-4 flex justify-between items-center">
        <h1 class="text-xl font-semibold">Admin Panel</h1>
        <button id="mobile-menu-button" class="text-white">
            <i class="fas fa-bars text-xl"></i>
        </button>
    </div>

    <div class="flex flex-1">
        <!-- Sidebar - hidden on mobile by default -->
        <aside id="sidebar"
               class="w-64 bg-gray-800 text-white fixed h-full z-20 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
            <div class="p-6">
                <h1 class="text-2xl font-semibold">Admin Panel</h1>
            </div>
            <nav class="mt-6">
                <div class="px-4 py-2 text-gray-300">
                    <p class="text-xs uppercase font-bold">Management</p>
                </div>
                <a href="{{ route('admin') }}"
                   class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    <span>Dashboard</span>
                </a>
                <a href="#users"
                   class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white">
                    <i class="fas fa-users mr-3"></i>
                    <span>Users</span>
                </a>
                <a href="#products"
                   class="flex items-center px-6 py-3 text-white bg-gray-700">
                    <i class="fas fa-box mr-3"></i>
                    <span>Products</span>
                </a>
                <div class="mt-auto px-4 py-2 text-gray-300">
                    <p class="text-xs uppercase font-bold">Account</p>
                </div>
                <form action="{{ route('logout') }}" method="POST"
                      class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white">
                    @csrf
                    <i class="fas fa-sign-out-alt mr-3"></i>
                    <button type="submit">Logout</button>
                </form>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 w-full lg:ml-64 p-4 lg:p-8">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-xl lg:text-3xl font-semibold text-gray-800">Add New Product</h2>
                <div>
                    <a href="{{ route('admin') }}" class="text-blue-500 hover:text-blue-700">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
                    </a>
                </div>
            </div>

            <!-- Product Form -->
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

                    <form action="{{ route('products.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-6 mb-6">
                            <div>
                                <label for="nombre_producto"
                                       class="block text-xs lg:text-sm font-medium text-gray-700 mb-1">Product
                                    Name</label>
                                <input type="text" name="nombre_producto" id="nombre_producto" required
                                       class="w-full p-2 border border-gray-300 rounded-md text-sm"
                                       value="{{ old('nombre_producto', $product -> nombre_producto) }}" maxlength="50">
                                <p class="text-xs text-gray-500 mt-1">Max 50 characters</p>
                            </div>
                            <div>
                                <label for="precio"
                                       class="block text-xs lg:text-sm font-medium text-gray-700 mb-1">Price</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">$</span>
                                    </div>
                                    <input type="number" name="precio" id="precio" required min="0" step="0.01"
                                           class="w-full p-2 pl-7 border border-gray-300 rounded-md text-sm"
                                           value="{{ old('precio', $product -> precio) }}">
                                </div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="stock"
                                   class="block text-xs lg:text-sm font-medium text-gray-700 mb-1">Stock</label>
                            <input type="number" name="stock" id="stock" required min="0"
                                   class="w-full p-2 border border-gray-300 rounded-md text-sm"
                                   value="{{ old('stock', $product -> stock) }}">
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-sm lg:text-base">
                                <i class="fas fa-plus mr-2"></i> Add Product
                            </button>
                            <a href="{{ route('admin') }}" class="text-gray-500 hover:text-gray-700 text-sm">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </section>
        </main>
    </div>
</div>

@vite("resources/js/responsiveaddproduct.js")
</body>
</html>

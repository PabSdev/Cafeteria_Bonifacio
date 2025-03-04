@php use App\Models\User, App\Models\Productos; @endphp
    <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
                <a href="{{ route('admin') }}" class="flex items-center px-6 py-3 text-white bg-gray-700">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    <span>Dashboard</span>
                </a>
                <a href="#users" class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white">
                    <i class="fas fa-users mr-3"></i>
                    <span>Users</span>
                </a>
                <a href="#products"
                   class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white">
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
                <h2 class="text-xl lg:text-3xl font-semibold text-gray-800">Dashboard</h2>
                <div>
                    <span class="text-gray-600 text-sm lg:text-base">Welcome, {{ Auth::user()->name }}</span>
                </div>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6 mb-8">
                <div class="bg-white rounded-lg shadow p-4 lg:p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500 text-xs lg:text-sm">Total Users</p>
                            <h3 class="text-xl lg:text-3xl font-bold">{{ User::count() }}</h3>
                        </div>
                        <div class="bg-blue-100 p-2 lg:p-3 rounded-full">
                            <i class="fas fa-users text-blue-500"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-4 lg:p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500 text-xs lg:text-sm">Total Products</p>
                            <h3 class="text-xl lg:text-3xl font-bold">0</h3>
                        </div>
                        <div class="bg-green-100 p-2 lg:p-3 rounded-full">
                            <i class="fas fa-box text-green-500"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-4 lg:p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500 text-xs lg:text-sm">Admins</p>
                            <h3 class="text-xl lg:text-3xl font-bold">{{ User::where('rol', 1)->count() }}</h3>
                        </div>
                        <div class="bg-purple-100 p-2 lg:p-3 rounded-full">
                            <i class="fas fa-user-shield text-purple-500"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Users Table -->
            <section id="users" class="mb-12">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg lg:text-2xl font-semibold text-gray-800">Users</h3>
                    <a href="{{ route('users.create') }}"
                       class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 lg:px-4 lg:py-2 rounded text-sm lg:text-base">
                        <i class="fas fa-plus mr-1 lg:mr-2"></i> Add User
                    </a></div>
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name
                                </th>
                                <th scope="col"
                                    class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">
                                    Email
                                </th>
                                <th scope="col"
                                    class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Role
                                </th>
                                <th scope="col"
                                    class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                                    Registered
                                </th>
                                <th scope="col"
                                    class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @foreach(User::all() as $user)
                                <tr>
                                    <td class="px-4 lg:px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="flex-shrink-0 h-8 w-8 lg:h-10 lg:w-10 bg-gray-200 rounded-full flex items-center justify-center">
                                                <i class="fas fa-user text-gray-500"></i>
                                            </div>
                                            <div class="ml-3 lg:ml-4">
                                                <div
                                                    class="text-xs lg:text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                                <div class="text-xs text-gray-500 sm:hidden">{{ $user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 lg:px-6 py-4 whitespace-nowrap hidden sm:table-cell">
                                        <div class="text-xs lg:text-sm text-gray-900">{{ $user->email }}</div>
                                    </td>
                                    <td class="px-4 lg:px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->rol == 1 ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' }}">
                                            {{ $user->rol == 1 ? 'Admin' : 'User' }}
                                        </span>
                                    </td>
                                    <td class="px-4 lg:px-6 py-4 whitespace-nowrap text-xs lg:text-sm text-gray-500 hidden md:table-cell">
                                        {{ $user->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-4 lg:px-6 py-4 whitespace-nowrap text-xs lg:text-sm font-medium">
                                        <a href="{{ route('users.edit', $user->id) }}" class="text-blue-600 hover:text-blue-900 mr-2 lg:mr-3">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                              onsubmit="return confirm('Are you sure you want to delete this user?');"
                                              style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900"><i
                                                    class="fas fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- Product Information -->
            <section id="products" class="mb-12">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg lg:text-2xl font-semibold text-gray-800">Products</h3>
                    <a href="{{ route("products.create") }}"
                       class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 lg:px-4 lg:py-2 rounded text-sm lg:text-base">
                        <i class="fas fa-plus mr-1 lg:mr-2"></i> Add Product
                    </a>
                </div>
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Product Name
                                </th>
                                <th scope="col"
                                    class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">
                                    Price
                                </th>
                                <th scope="col"
                                    class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Stock
                                </th>
                                <th scope="col"
                                    class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @php $productos = Productos::all(); @endphp
                            @if(count($productos) > 0)
                                @foreach($productos as $product)
                                    <tr>
                                        <td class="px-4 lg:px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-8 w-8 lg:h-10 lg:w-10 bg-gray-100 rounded flex items-center justify-center">
                                                    <i class="fas fa-box text-gray-500"></i>
                                                </div>
                                                <div class="ml-3 lg:ml-4">
                                                    <div class="text-xs lg:text-sm font-medium text-gray-900">{{ $product->nombre_producto }}</div>
                                                    <div class="text-xs text-gray-500 sm:hidden">${{ $product->precio }}</div>
                                                    <div class="text-xs text-gray-400">Added: {{ $product->created_at->format('M d, Y H:i') }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 lg:px-6 py-4 whitespace-nowrap hidden sm:table-cell">
                                            <div class="text-xs lg:text-sm text-gray-900">${{ number_format($product->precio, 2) }}</div>
                                        </td>
                                        <td class="px-4 lg:px-6 py-4 whitespace-nowrap">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                    {{ $product->stock > 10 ? 'bg-green-100 text-green-800' :
                      ($product->stock > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                    {{ $product->stock }}
                </span>
                                        </td>
                                        <td class="px-4 lg:px-6 py-4 whitespace-nowrap text-xs lg:text-sm font-medium">
                                            <a href="" class="text-blue-600 hover:text-blue-900 mr-2 lg:mr-3">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="" method="POST"
                                                  onsubmit="return confirm('Are you sure you want to delete this product?');"
                                                  style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </main>
    </div>
</div>

@vite("resources/js/responsivedashboard.js")
</body>
</html>

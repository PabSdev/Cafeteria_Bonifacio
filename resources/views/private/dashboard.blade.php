@php use App\Models\User, App\Models\Productos, App\Models\Order; @endphp
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
    <!-- Header para movil -->
    <div class="lg:hidden bg-gray-800 text-white p-4 flex justify-between items-center">
        <h1 class="text-xl font-semibold">Panel de Administrador</h1>
        <button id="mobile-menu-button" class="text-white">
            <i class="fas fa-bars text-xl"></i>
        </button>
    </div>

    <div class="flex flex-1">
        <!-- Barra de navegacion -->
        <aside id="sidebar"
               class="w-64 bg-gray-800 text-white fixed h-full z-20 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
            <div class="p-6">
                <h1 class="text-2xl font-semibold">Panel de Administrador</h1>
            </div>
            <nav class="mt-6">
                <div class="px-4 py-2 text-gray-300">
                    <p class="text-xs uppercase font-bold">Opciones</p>
                </div>
                <a href="{{ route('admin') }}" class="flex items-center px-6 py-3 text-white bg-gray-700">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    <span>Panel de Control</span>
                </a>
                <a href="#users" class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white">
                    <i class="fas fa-users mr-3"></i>
                    <span>Usuarios</span>
                </a>
                <a href="#products"
                   class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white">
                    <i class="fas fa-box mr-3"></i>
                    <span>Productos</span>
                </a>
                <a href="#orders" class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white">
                    <i class="fas fa-receipt mr-3"></i>
                    <span>Pedidos</span>
                </a>
                <div class="mt-auto px-4 py-2 text-gray-300">
                    <p class="text-xs uppercase font-bold">Cuenta</p>
                </div>
                <form action="{{ route('logout') }}" method="POST"
                      class="flex items-center px-6 py-3 text-gray-300 hover:bg-gray-700 hover:text-white">
                    @csrf
                    <i class="fas fa-sign-out-alt mr-3"></i>
                    <button type="submit">Cerrar Sesion</button>
                </form>
            </nav>
        </aside>

        <!-- Contenido Principal -->
        <main class="flex-1 w-full lg:ml-64 p-4 lg:p-8">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-xl lg:text-3xl font-semibold text-gray-800">Panel de control</h2>
                <div>
                    <span class="text-gray-600 text-sm lg:text-base">Bienvenido, {{ Auth::user()->name }}</span>
                </div>
            </div>

            <!-- Estadisticas -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6 mb-8">
                <div class="bg-white rounded-lg shadow p-4 lg:p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500 text-xs lg:text-sm">Usuarios Totales</p>
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
                            <p class="text-gray-500 text-xs lg:text-sm">Productos Totales</p>
                            <h3 class="text-xl lg:text-3xl font-bold">{{ Productos::count() }}</h3>
                        </div>
                        <div class="bg-green-100 p-2 lg:p-3 rounded-full">
                            <i class="fas fa-box text-green-500"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow p-4 lg:p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-gray-500 text-xs lg:text-sm">Administradores</p>
                            <h3 class="text-xl lg:text-3xl font-bold">{{ User::where('rol', 1)->count() }}</h3>
                        </div>
                        <div class="bg-purple-100 p-2 lg:p-3 rounded-full">
                            <i class="fas fa-user-shield text-purple-500"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla Usuarios -->
            <section id="users" class="mb-12">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg lg:text-2xl font-semibold text-gray-800">Usuarios</h3>
                    <a href="{{ route('users.create') }}"
                       class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 lg:px-4 lg:py-2 rounded text-sm lg:text-base">
                        <i class="fas fa-plus mr-1 lg:mr-2"></i> Añadir Usuario
                    </a></div>
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nombre
                                </th>
                                <th scope="col"
                                    class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">
                                    Correo Electrónico
                                </th>
                                <th scope="col"
                                    class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Rol
                                </th>
                                <th scope="col"
                                    class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                                    Fecha de Registro
                                </th>
                                <th scope="col"
                                    class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Opciones
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @php $users = User::all(); @endphp
                            @if(count($users) > 0)
                                @foreach($users as $user)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-4 lg:px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div
                                                    class="flex-shrink-0 h-8 w-8 lg:h-10 lg:w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                                    <i class="fas fa-user text-blue-500"></i>
                                                </div>
                                                <div class="ml-3 lg:ml-4">
                                                    <div
                                                        class="text-xs lg:text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                                    <div class="text-xs text-gray-500 sm:hidden">{{ $user->email }}</div>
                                                    <div class="text-xs text-gray-400 flex items-center">
                                                        <i class="far fa-calendar-alt mr-1 text-gray-400"></i>
                                                        {{ $user->created_at->format('M d, Y') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 lg:px-6 py-4 whitespace-nowrap hidden sm:table-cell">
                                            <div class="text-xs lg:text-sm text-gray-900">{{ $user->email }}</div>
                                        </td>
                                        <td class="px-4 lg:px-6 py-4 whitespace-nowrap">
                                            @php
                                                $roleClass = $user->rol == 1 
                                                    ? 'bg-purple-100 text-purple-800 border border-purple-200' 
                                                    : 'bg-green-100 text-green-800 border border-green-200';
                                                $roleIcon = $user->rol == 1 
                                                    ? 'fas fa-user-shield text-purple-600 mr-1' 
                                                    : 'fas fa-user text-green-600 mr-1';
                                            @endphp
                                            <span class="px-2 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full {{ $roleClass }}">
                                                <i class="{{ $roleIcon }}"></i>
                                                {{ $user->rol == 1 ? 'Admin' : 'User' }}
                                            </span>
                                        </td>
                                        <td class="px-4 lg:px-6 py-4 whitespace-nowrap text-xs lg:text-sm text-gray-500 hidden md:table-cell">
                                            <div class="flex items-center">
                                                <i class="far fa-calendar-alt mr-1 text-gray-400"></i>
                                                {{ $user->created_at->format('M d, Y') }}
                                                <span class="mx-1 text-gray-300">|</span>
                                                <i class="far fa-clock mr-1 text-gray-400"></i>
                                                {{ $user->created_at->format('H:i') }}
                                            </div>
                                        </td>
                                        <td class="px-4 lg:px-6 py-4 whitespace-nowrap text-xs lg:text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('users.edit', $user->id) }}"
                                                    class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 p-1.5 rounded-md transition-colors">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                        onsubmit="return confirm('¿Está seguro de que desea eliminar este usuario?');"
                                                        style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 p-1.5 rounded-md transition-colors">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="px-4 lg:px-6 py-8 text-center text-gray-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <i class="fas fa-users text-gray-300 text-3xl mb-2"></i>
                                            <p>No hay usuarios registrados.</p>
                                            <a href="{{ route('users.create') }}" class="mt-2 text-blue-600 hover:text-blue-800 text-sm">
                                                <i class="fas fa-plus-circle mr-1"></i> Añadir el primer usuario
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- Informacion del producto -->
            <section id="products" class="mb-12">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg lg:text-2xl font-semibold text-gray-800">Productos</h3>
                    <a href="{{ route("products.create") }}"
                       class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 lg:px-4 lg:py-2 rounded text-sm lg:text-base">
                        <i class="fas fa-plus mr-1 lg:mr-2"></i> Añadir Producto
                    </a>
                </div>
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nombre del Producto
                                </th>
                                <th scope="col"
                                    class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">
                                    Precio
                                </th>
                                <th scope="col"
                                    class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Stock
                                </th>
                                <th scope="col"
                                    class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                                    Categoría
                                </th>
                                <th scope="col"
                                    class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                                    Imagen
                                </th>
                                <th scope="col"
                                    class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Opciones
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @php $productos = Productos::all(); @endphp
                            @if(count($productos) > 0)
                                @foreach($productos as $product)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-4 lg:px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div
                                                    class="flex-shrink-0 h-8 w-8 lg:h-10 lg:w-10 bg-blue-100 rounded flex items-center justify-center">
                                                    <i class="fas fa-box text-blue-500"></i>
                                                </div>
                                                <div class="ml-3 lg:ml-4">
                                                    <div
                                                        class="text-xs lg:text-sm font-medium text-gray-900">{{ $product->nombre_producto }}</div>
                                                    <div class="text-xs text-gray-500 sm:hidden">{{ number_format($product->precio, 2) }}
                                                        €
                                                    </div>
                                                    <div class="text-xs text-gray-400 flex items-center">
                                                        <i class="far fa-calendar-alt mr-1 text-gray-400"></i>
                                                        {{ $product->created_at->format('M d, Y') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 lg:px-6 py-4 whitespace-nowrap hidden sm:table-cell">
                                            <div
                                                class="text-xs lg:text-sm font-medium text-gray-900">{{ number_format($product->precio, 2) }}
                                                €
                                            </div>
                                        </td>
                                        <td class="px-4 lg:px-6 py-4 whitespace-nowrap">
                                            @php
                                                $stockClass = '';
                                                $stockIcon = '';
                                                if ($product->stock > 20) {
                                                    $stockClass = 'bg-green-100 text-green-800 border border-green-200';
                                                    $stockIcon = 'fas fa-check-circle text-green-600 mr-1';
                                                } elseif ($product->stock > 10) {
                                                    $stockClass = 'bg-blue-100 text-blue-800 border border-blue-200';
                                                    $stockIcon = 'fas fa-info-circle text-blue-600 mr-1';
                                                } elseif ($product->stock > 0) {
                                                    $stockClass = 'bg-yellow-100 text-yellow-800 border border-yellow-200';
                                                    $stockIcon = 'fas fa-exclamation-circle text-yellow-600 mr-1';
                                                } else {
                                                    $stockClass = 'bg-red-100 text-red-800 border border-red-200';
                                                    $stockIcon = 'fas fa-times-circle text-red-600 mr-1';
                                                }
                                            @endphp
                                            <span class="px-2 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full {{ $stockClass }}">
                                                <i class="{{ $stockIcon }}"></i>
                                                {{ $product->stock }} unid.
                                            </span>
                                        </td>
                                        <td class="px-4 lg:px-6 py-4 whitespace-nowrap text-xs lg:text-sm text-gray-900 hidden md:table-cell">
                                            <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs">
                                                {{ $product->categoria }}
                                            </span>
                                        </td>
                                        <td class="px-4 lg:px-6 py-4 whitespace-nowrap text-xs lg:text-sm text-gray-900 hidden md:table-cell">
                                            @if($product->imagen)
                                                <img src="{{ $product->imagen }}" alt="{{ $product->nombre_producto }}"
                                                     class="h-10 w-10 object-cover rounded-lg shadow-sm border border-gray-200">
                                            @else
                                                <div class="h-10 w-10 rounded-lg bg-gray-100 flex items-center justify-center">
                                                    <i class="fas fa-image text-gray-400"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-4 lg:px-6 py-4 whitespace-nowrap text-xs lg:text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('products.edit', $product->id) }}"
                                                   class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 p-1.5 rounded-md transition-colors">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                                      onsubmit="return confirm('¿Está seguro de que desea eliminar este producto?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 p-1.5 rounded-md transition-colors">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="px-4 lg:px-6 py-8 text-center text-gray-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <i class="fas fa-box-open text-gray-300 text-3xl mb-2"></i>
                                            <p>No hay productos registrados.</p>
                                            <a href="{{ route('products.create') }}" class="mt-2 text-blue-600 hover:text-blue-800 text-sm">
                                                <i class="fas fa-plus-circle mr-1"></i> Añadir el primer producto
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

           <!-- Gestión de Pedidos -->
            <section id="orders" class="mb-12">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg lg:text-2xl font-semibold text-gray-800">Gestión de Pedidos</h3>
                </div>
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ID Pedido
                                </th>
                                <th scope="col" class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Info Cliente
                                </th>
                                <th scope="col" class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Estado
                                </th>
                                <th scope="col" class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">
                                    Total
                                </th>
                                <th scope="col" class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                                    Fecha de Pedido
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @php
                                // Obtener pedidos directamente. Es mejor pasar esto desde el controlador.
                                $orders = App\Models\Order::orderBy('created_at', 'desc')->get();
                            @endphp
                            @if(count($orders) > 0)
                                @foreach($orders as $order)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-4 lg:px-6 py-4 whitespace-nowrap">
                                            <div class="text-xs lg:text-sm font-medium text-gray-900">#{{ $order->id }}</div>
                                        </td>
                                        <td class="px-4 lg:px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-8 w-8 bg-blue-100 rounded-full flex items-center justify-center">
                                                    <i class="fas fa-user text-blue-500"></i>
                                                </div>
                                                <div class="ml-3 lg:ml-4">
                                                    <div class="text-xs lg:text-sm font-medium text-gray-900">
                                                        @if(isset($order->user_id))
                                                            ID Usuario: {{ $order->user_id }}
                                                        @elseif(isset($order->customer_name))
                                                            {{ $order->customer_name }}
                                                        @else
                                                            N/A
                                                        @endif
                                                    </div>
                                                    @if(isset($order->customer_email))
                                                    <div class="text-xs text-gray-500">
                                                        {{ $order->customer_email }}
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 lg:px-6 py-4 whitespace-nowrap">
                                            @php
                                                $statusClass = '';
                                                $iconClass = '';
                                                switch (strtolower($order->status)) {
                                                    case 'pendiente':
                                                        $statusClass = 'bg-yellow-100 text-yellow-800 border border-yellow-200';
                                                        $iconClass = 'fas fa-clock text-yellow-600 mr-1';
                                                        break;
                                                    case 'procesando':
                                                        $statusClass = 'bg-blue-100 text-blue-800 border border-blue-200';
                                                        $iconClass = 'fas fa-spinner fa-spin text-blue-600 mr-1';
                                                        break;
                                                    case 'completado':
                                                        $statusClass = 'bg-green-100 text-green-800 border border-green-200';
                                                        $iconClass = 'fas fa-check text-green-600 mr-1';
                                                        break;
                                                    case 'cancelado':
                                                        $statusClass = 'bg-red-100 text-red-800 border border-red-200';
                                                        $iconClass = 'fas fa-times text-red-600 mr-1';
                                                        break;
                                                    default:
                                                        $statusClass = 'bg-gray-100 text-gray-800 border border-gray-200';
                                                        $iconClass = 'fas fa-question text-gray-600 mr-1';
                                                }
                                            @endphp
                                            <span class="px-2 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                                <i class="{{ $iconClass }}"></i>
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td class="px-4 lg:px-6 py-4 whitespace-nowrap hidden sm:table-cell">
                                            <div class="text-xs lg:text-sm font-medium text-gray-900">{{ number_format($order->total, 2) }} €</div>
                                        </td>
                                        <td class="px-4 lg:px-6 py-4 whitespace-nowrap text-xs lg:text-sm text-gray-500 hidden md:table-cell">
                                            <div class="flex items-center">
                                                <i class="far fa-calendar-alt mr-1 text-gray-400"></i>
                                                {{ $order->created_at->format('M d, Y') }}
                                                <span class="mx-1 text-gray-300">|</span>
                                                <i class="far fa-clock mr-1 text-gray-400"></i>
                                                {{ $order->created_at->format('H:i') }}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="px-4 lg:px-6 py-8 text-center text-gray-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <i class="fas fa-shopping-cart text-gray-300 text-3xl mb-2"></i>
                                            <p>No hay pedidos registrados.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

        </main>
    </div>
</div>
<script>
    // Script para el menú móvil
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const sidebar = document.getElementById('sidebar');

    if (mobileMenuButton && sidebar) {
        mobileMenuButton.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            sidebar.classList.toggle('translate-x-0');
        });
    }

    // Script para cerrar el menú lateral al hacer clic en un enlace (opcional)
    document.querySelectorAll('#sidebar nav a').forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth < 1024) { // Solo para pantallas pequeñas (lg breakpoint de Tailwind)
                sidebar.classList.add('-translate-x-full');
                sidebar.classList.remove('translate-x-0');
            }
        });
    });
</script>
</body>
</html>
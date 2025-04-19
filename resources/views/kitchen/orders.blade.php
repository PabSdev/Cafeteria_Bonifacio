<!-- filepath: c:\tfg\Cafeteria_Bonifacio\resources\views\kitchen\orders.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="reverb-key" content="{{ env('REVERB_APP_KEY') }}">
    <meta name="reverb-host" content="{{ env('REVERB_HOST') }}">
    <meta name="reverb-port" content="{{ env('REVERB_PORT') }}">
    <meta name="reverb-scheme" content="{{ env('REVERB_SCHEME') }}">
    <title>Pedidos - Cocina</title>
    <link href="https://cdn.tailwindcss.com" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/orders.js'])
    
    <!-- Indicador de conexión -->
    <div id="connection-status" class="fixed top-4 right-4 px-3 py-1 rounded text-white bg-gray-500">
        Conectando...
    </div>
    
    <style>
        @keyframes highlightNew {
            0% { background-color: #fef3c7; }
            100% { background-color: white; }
        }

        .highlight-new {
            animation: highlightNew 2s ease-out;
        }

        .loading {
            opacity: 0.7;
            pointer-events: none;
        }
    </style>
</head>
<body class="bg-gray-100 p-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Pedidos en Cocina</h1>
    
    <!-- Tabs para estados de pedidos -->
    <div class="mb-6 border-b border-gray-200">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center">
            <li class="mr-2">
                <a href="#pending" class="inline-block p-4 border-b-2 border-amber-500 rounded-t-lg active tab-button" 
                   data-target="pending-orders">Pendientes</a>
            </li>
            <li class="mr-2">
                <a href="#preparation" class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:border-gray-300 tab-button" 
                   data-target="preparation-orders">En Preparación</a>
            </li>
            <li class="mr-2">
                <a href="#completed" class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:border-gray-300 tab-button" 
                   data-target="completed-orders">Completados</a>
            </li>
        </ul>
    </div>

    <!-- Contenedor de pedidos pendientes (visible por defecto) -->
    <div id="pending-orders" class="tab-content grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($orders as $order)
            @if($order->status == 'pendiente')
                <div class="bg-white shadow-md rounded-lg p-4" id="order-{{ $order->id }}">
                    <h2 class="text-lg font-bold text-gray-800">Pedido #{{ $order->id }}</h2>
                    <p class="text-gray-600">Cliente: {{ $order->customer_name }}</p>
                    <p class="text-gray-600">Total: {{ number_format($order->total, 2) }}€</p>
                    <p class="text-gray-600">Estado: <span class="font-bold">{{ ucfirst($order->status) }}</span></p>
                    
                    <form action="{{ route('order.update', $order->id) }}" method="POST" class="mt-4">
                        @csrf
                        @method('PUT')
                        <select name="status" class="border rounded px-2 py-1">
                            <option value="pendiente" selected>Pendiente</option>
                            <option value="en preparación">En preparación</option>
                            <option value="completado">Completado</option>
                        </select>
                        <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Actualizar</button>
                    </form>
                </div>
            @endif
        @endforeach
    </div>

    <!-- Contenedor de pedidos en preparación (oculto inicialmente) -->
    <div id="preparation-orders" class="tab-content hidden grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($orders as $order)
            @if($order->status == 'en preparación')
                <div class="bg-white shadow-md rounded-lg p-4" id="order-{{ $order->id }}">
                    <h2 class="text-lg font-bold text-gray-800">Pedido #{{ $order->id }}</h2>
                    <p class="text-gray-600">Cliente: {{ $order->customer_name }}</p>
                    <p class="text-gray-600">Total: {{ number_format($order->total, 2) }}€</p>
                    <p class="text-gray-600">Estado: <span class="font-bold">{{ ucfirst($order->status) }}</span></p>
                    
                    <form action="{{ route('order.update', $order->id) }}" method="POST" class="mt-4">
                        @csrf
                        @method('PUT')
                        <select name="status" class="border rounded px-2 py-1">
                            <option value="pendiente">Pendiente</option>
                            <option value="en preparación" selected>En preparación</option>
                            <option value="completado">Completado</option>
                        </select>
                        <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Actualizar</button>
                    </form>
                </div>
            @endif
        @endforeach
    </div>

    <!-- Contenedor de pedidos completados (oculto inicialmente) -->
    <div id="completed-orders" class="tab-content hidden grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($orders as $order)
            @if($order->status == 'completado')
                <div class="bg-white shadow-md rounded-lg p-4" id="order-{{ $order->id }}">
                    <h2 class="text-lg font-bold text-gray-800">Pedido #{{ $order->id }}</h2>
                    <p class="text-gray-600">Cliente: {{ $order->customer_name }}</p>
                    <p class="text-gray-600">Total: {{ number_format($order->total, 2) }}€</p>
                    <p class="text-gray-600">Estado: <span class="font-bold text-green-600">{{ ucfirst($order->status) }}</span></p>
                    <p class="text-xs text-gray-500 mt-2">Este pedido ha sido completado y no puede modificarse</p>
                </div>
            @endif
        @endforeach
    </div>
</body>
</html>
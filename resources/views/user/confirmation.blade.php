<!-- filepath: c:\tfg\Cafeteria_Bonifacio\resources\views\user\confirmation.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Pedido</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md text-center">
        <h1 class="text-2xl font-bold text-amber-600 mb-4">¡Gracias por tu pedido!</h1>
        <p class="text-gray-700 mb-4">Tu ID de pedido es:</p>
        <span class="text-xl font-bold text-gray-900">{{ $order->id }}</span>
        <p class="text-gray-500 mt-4">Por favor, guarda este ID para identificar tu pedido.</p>
    </div>
</body>
</html>
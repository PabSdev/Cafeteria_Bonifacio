<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Events\OrderCreated;
use App\Events\OrderStatusUpdated;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
        ]);

        // Crear el pedido en la base de datos
        $order = Order::create([
            'customer_name' => $request->customer_name,
            'total' => $request->input('cart_total', 0),
            'status' => 'pendiente',
        ]);

        // Emitir el evento
        event(new OrderCreated($order));

        return redirect()->route('user.confirmation', ['id' => $order->id]);
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        // Verificar si el pedido ya está completado
        if ($order->status === 'completado') {
            return redirect()->route('kitchen.orders')
                ->with('error', 'Los pedidos completados no pueden ser modificados.');
        }

        // Actualizar el estado del pedido
        $order->update([
            'status' => $request->status,
        ]);

        // Emitir el evento para notificar en tiempo real
        event(new OrderStatusUpdated($order));

        return redirect()->route('kitchen.orders')
            ->with('success', 'Estado actualizado correctamente.');
    }

    /**
     * Muestra la página de pedidos para la cocina.
     */
    public function kitchen()
    {
        $orders = Order::orderBy('created_at', 'desc')->get();
        return view('kitchen.orders', compact('orders'));
    }

    /**
     * Muestra la página de confirmación de pedido para el usuario.
     */
    public function confirmation($id)
    {
        $order = Order::findOrFail($id);
        return view('user.confirmation', compact('order'));
    }
}

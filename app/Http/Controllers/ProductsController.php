<?php

namespace App\Http\Controllers;

use App\Models\Productos;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function create()
    {
        return view('private.addproduct');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_producto' => 'required|max:50',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categoria' => 'required|string|max:255',
            'imagen' => 'required|string|max:255|unique:productos,imagen,',
            'description' => 'nullable|string',
        ]);

        Productos::create($validated);

        return redirect()->route('products.create')->with('success', 'Product added successfully');
    }

    public function update(Request $request, $id)
    {

        $product = Productos::findOrFail($id);

        $validated = $request->validate([
            'nombre_producto' => 'required|max:50',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categoria' => 'required|string|max:255',
            'imagen' => 'required|string|max:255|unique:productos,imagen,' . $id,
            'description' => 'nullable|string',
        ]);

        $product->update($validated);

        return redirect()->route('admin')->with('success', 'Producto actualizado correctamente');
    }

    public function destroy($id)
    {
        $product = Productos::findOrFail($id);
        $product->delete();

        return redirect()->route('admin')->with('success', 'Product deleted successfully');
    }

    public function edit($id)
    {
        $product = Productos::findOrFail($id);
        return view('private.editproduct', compact('product'));
    }

    public function showMenu()
    {
        $products = Productos::where('stock', '>', 0)->get();
        return view('menu', compact('products'));
    }

    public function shopping()
    {
        // Fetch all products from the database
        $products = Productos::all();

        // Pass the products to the view
        return view('user.products', compact('products'));
    }
}

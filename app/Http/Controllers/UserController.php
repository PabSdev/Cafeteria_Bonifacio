<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return view('logados');
    }

    public function create()
    {
        return view('private.adduser');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'rol' => 'required|integer|in:0,1',
        ]);

        $product = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'rol' => $validated['rol'],
            'email_verified_at' => now(),
            'remember_token' => \Str::random(10),
        ]);

        return redirect()->route('admin')->with('success', 'User created successfully');
    }

    public function destroy($id)
    {

        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin')->with('success', 'User deleted successfully');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('private.edituser', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'rol' => 'required|integer|in:0,1',
        ];

        // Only validate password if it's provided
        if ($request->filled('password')) {
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        $validated = $request->validate($rules);

        // Update the basic info
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->rol = $validated['rol'];

        // Update password only if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('admin')->with('success', 'User updated successfully');
    }
}

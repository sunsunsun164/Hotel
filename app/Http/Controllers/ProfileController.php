<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $bookings = $user->bookings()
            ->with(['room.hotel'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        $reviews = $user->reviews()
            ->with('hotel')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('profile.index', compact('user', 'bookings', 'reviews'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|string|min:6|confirmed',
            ]);
            $user->password = Hash::make($request->password);
        }
        
        $user->save();
        
        return redirect()->route('profile.index')->with('success', 'Профиль обновлён!');
    }
}
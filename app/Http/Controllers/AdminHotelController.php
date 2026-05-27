<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminHotelController extends Controller
{
    private function authorizeAdmin(): void
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            abort(403, 'Доступ запрещён');
        }
    }

    public function create(): 
        \Illuminate\Http\Response|\Illuminate\Contracts\View\View
    {
        $this->authorizeAdmin();

        $organizations = Organization::query()
            ->orderBy('id', 'desc')
            ->get(['id', 'name']);

        return view('admin.hotels.create', compact('organizations'));
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $data = $request->validate([
            'organization_id' => 'required|exists:organizations,id',
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'nullable|string|max:255',
            'address' => 'required|string|max:255',
            'description' => 'nullable|string',
            'stars' => 'required|integer|min:1|max:5',
            'price_per_night' => 'required|numeric|min:0',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'image' => 'nullable|string|max:255',
            'image_picture' => 'nullable|string|max:255',
            'image_file' => 'nullable',
            'is_available' => 'required|boolean',
        ]);

        $data['image'] = $request->filled('image_picture')
            ? ('/pictures/' . $request->input('image_picture'))
            : ($request->input('image') ?? null);

        unset($data['image_picture'], $data['image_file']);


        Hotel::query()->create($data);


        return redirect()->route('admin.hotels.create')
            ->with('success', 'Отель создан и прикреплён к организации');
    }
}


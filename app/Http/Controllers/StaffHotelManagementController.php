<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffHotelManagementController extends Controller
{
    public function showEdit($id)
    {
        $user = Auth::user();

        $hotelQuery = Hotel::query()->with('rooms');

        if (!$user->is_admin) {
            $hotelQuery->where('organization_id', $user->organization_id);
        }

        $hotel = $hotelQuery->findOrFail($id);

        return view('staff.hotels.edit', compact('hotel'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();

        $hotelQuery = Hotel::query();

        if (!$user->is_admin) {
            $hotelQuery->where('organization_id', $user->organization_id);
        }

        $hotel = $hotelQuery->findOrFail($id);

        $data = $request->validate([
            'organization_id' => $user->is_admin ? 'nullable|exists:organizations,id' : 'prohibited',

            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'nullable|string|max:255',
            'address' => 'required|string|max:255',
            'description' => 'nullable|string',
            'stars' => 'required|integer|min:1|max:5',
            'price_per_night' => 'required|numeric|min:0',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'is_available' => 'required|boolean',
        ]);

        $hotel->update($data);

        return redirect()->route('staff.hotels.edit', $hotel->id)
            ->with('success', 'Отель обновлён');
    }

    public function storeRoom(Request $request, $hotelId)
    {
        $user = Auth::user();

        $hotelQuery = Hotel::query();
        if (!$user->is_admin) {
            $hotelQuery->where('organization_id', $user->organization_id);
        }

        $hotel = $hotelQuery->findOrFail($hotelId);

        $data = $request->validate([
            'room_number' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'price_per_night' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'is_available' => 'required|boolean',
            'image' => 'nullable|string|max:255',
        ]);

        $room = new Room($data);
        $room->hotel_id = $hotel->id;
        $room->save();

        return redirect()->route('staff.hotels.edit', $hotel->id)
            ->with('success', 'Комната добавлена');
    }
}



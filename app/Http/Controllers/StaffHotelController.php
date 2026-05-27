<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffHotelController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $hotelsQuery = Hotel::query()->orderBy('id', 'desc');

        if (!$user->is_admin) {
            $hotelsQuery->where('organization_id', $user->organization_id);
        }

        $hotels = $hotelsQuery->paginate(12);

        return view('staff.hotels.index', compact('hotels'));
    }


    public function show($id)
    {
        $user = Auth::user();

        $hotelQuery = Hotel::query()->with('rooms');

        if (!$user->is_admin) {
            $hotelQuery->where('organization_id', $user->organization_id);
        }

        $hotel = $hotelQuery->findOrFail($id);

        return view('staff.hotels.show', compact('hotel'));
    }
}


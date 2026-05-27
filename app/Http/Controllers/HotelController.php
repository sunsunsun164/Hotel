<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{ 
    
    public function index(Request $request)
    {
        $query = Hotel::query();
        
        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }
        
        if ($request->filled('stars')) {
            $query->where('stars', $request->stars);
        }
        
        if ($request->filled('price_from')) {
            $query->where('price_per_night', '>=', $request->price_from);
        }
        
        if ($request->filled('price_to')) {
            $query->where('price_per_night', '<=', $request->price_to);
        }
        
        $sort = $request->get('sort', 'id');
        $direction = $request->get('direction', 'desc');
        
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price_per_night', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price_per_night', 'desc');
                break;
            case 'stars_desc':
                $query->orderBy('stars', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            default:
                $query->orderBy('id', 'desc');
                break;
        }
        
        $hotels = $query->paginate(12)->withQueryString();
        
        $cities = Hotel::select('city')->distinct()->pluck('city');
        
        return view('hotels.index', compact('hotels', 'cities'));
    }

    public function show($id)
    {
        $hotel = Hotel::with('rooms', 'reviews.user')->findOrFail($id);
        
        $userReview = null;
        if (auth()->check()) {
            $userReview = \App\Models\Review::where('user_id', auth()->id())
                ->where('hotel_id', $id)
                ->first();
        }
        
        return view('hotels.show', compact('hotel', 'userReview'));
    }
}
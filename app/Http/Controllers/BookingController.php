<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $bookings = Auth::user()->bookings()
            ->with(['room.hotel'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('bookings.index', compact('bookings'));
    }

    public function create($roomId)
    {
        $room = Room::with('hotel')->findOrFail($roomId);
        return view('bookings.create', compact('room'));
    }

    public function store(Request $request, $roomId)
    {
        $room = Room::findOrFail($roomId);
        
        $request->validate([
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'guests' => 'required|integer|min:1|max:' . $room->capacity,
        ]);

        $checkIn = $request->check_in;
        $checkOut = $request->check_out;
        
        $existingBooking = Booking::where('room_id', $roomId)
            ->where('status', 'confirmed')
            ->where(function($query) use ($checkIn, $checkOut) {
                $query->whereBetween('check_in', [$checkIn, $checkOut])
                      ->orWhereBetween('check_out', [$checkIn, $checkOut])
                      ->orWhere(function($q) use ($checkIn, $checkOut) {
                          $q->where('check_in', '<=', $checkIn)
                            ->where('check_out', '>=', $checkOut);
                      });
            })
            ->exists();
        
        if ($existingBooking) {
            return back()->with('error', 'Номер уже забронирован на выбранные даты!');
        }

        $nights = (strtotime($checkOut) - strtotime($checkIn)) / 86400;
        $totalPrice = $room->price_per_night * $nights;

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'room_id' => $roomId,
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'guests' => $request->guests,
            'total_price' => $totalPrice,
            'status' => 'confirmed',
            'special_requests' => $request->special_requests,
        ]);

        return redirect()->route('bookings.index')
            ->with('success', 'Бронирование успешно создано!');
    }

    public function cancel($id)
    {
        $booking = Booking::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
        
        $booking->status = 'cancelled';
        $booking->save();
        
        return redirect()->route('bookings.index')
            ->with('success', 'Бронирование отменено');
    }
}
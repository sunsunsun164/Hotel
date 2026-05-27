<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, $hotelId)
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Войдите чтобы оставить отзыв');
        }
        
        $hotel = Hotel::find($hotelId);
        if (!$hotel) {
            return redirect()->back()->with('error', 'Отель не найден');
        }
        
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:5|max:1000',
        ]);

        $existingReview = Review::where('user_id', Auth::id())
            ->where('hotel_id', $hotelId)
            ->exists();
        
        if ($existingReview) {
            return redirect()->back()->with('error', 'Вы уже оставляли отзыв на этот отель!');
        }

        Review::create([
            'user_id' => Auth::id(),
            'hotel_id' => $hotelId,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => false,
        ]);

        return redirect()->route('hotels.show', $hotelId)
            ->with('success', 'Спасибо за отзыв! Он будет опубликован после проверки модератором.');
    }

    public function destroy($id)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }
        
        $review = Review::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();
        
        if (!$review && Auth::user()->is_admin) {
            $review = Review::find($id);
        }
        
        if (!$review) {
            return redirect()->back()->with('error', 'Отзыв не найден');
        }
        
        $hotelId = $review->hotel_id;
        $review->delete();
        
        return redirect()->route('hotels.show', $hotelId)
            ->with('success', 'Отзыв удалён');
    }
    
    public function adminIndex()
    {
        $this->authorizeAdmin();
        
        $reviews = Review::with(['user', 'hotel'])
            ->orderBy('is_approved', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('admin.reviews.index', compact('reviews'));
    }
    
    public function approve($id)
    {
        $this->authorizeAdmin();
        
        $review = Review::findOrFail($id);
        $review->is_approved = true;
        $review->save();
        
        return redirect()->back()->with('success', 'Отзыв одобрен и опубликован');
    }
    
    public function reject($id)
    {
        $this->authorizeAdmin();
        
        $review = Review::findOrFail($id);
        $review->delete();
        
        return redirect()->back()->with('success', 'Отзыв отклонён и удалён');
    }
    
    private function authorizeAdmin()
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            abort(403, 'Доступ запрещён');
        }
    }
}
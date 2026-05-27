<?php

namespace App\Http\Controllers;

use App\Services\TempHotelService;

class HomeController extends Controller
{
    protected $hotelService;

    public function __construct(TempHotelService $hotelService)
    {
        $this->hotelService = $hotelService;
    }

    public function index()
    {
        $popularHotels = $this->hotelService->getPopularHotels();
        return view('home', compact('popularHotels'));
    }
}
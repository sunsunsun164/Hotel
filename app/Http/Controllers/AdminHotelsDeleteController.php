<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminHotelsDeleteController extends Controller
{
    private function authorizeAdmin(): void
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            abort(403, 'Доступ запрещён');
        }
    }

    public function destroy(Request $request, Hotel $hotel)
    {
        $this->authorizeAdmin();

        $hotel->delete();

        return back()->with('success', 'Отель удалён');
    }
}


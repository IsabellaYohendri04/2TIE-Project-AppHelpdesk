<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;

class DashboardController extends Controller
{
  
public function index()
{
    $totalTickets = Ticket::count();

    $ticketsThisMonth = Ticket::whereMonth('created_at', now()->month)
                              ->whereYear('created_at', now()->year)
                              ->count();

    $ticketsThisYear = Ticket::whereYear('created_at', now()->year)->count();

    $completedTickets = Ticket::where('status', 'selesai')->count();

    // ✔ SPATIE ROLE (FIX ERROR)
    $totalStaff = User::role('staff')->count();

    $latestTickets = Ticket::with('category')
    ->latest()
    ->take(5)
    ->get();

    return view('dashboard', compact(
    'totalTickets',
    'ticketsThisMonth',
    'ticketsThisYear',
    'completedTickets',
    'totalStaff',
    'latestTickets'
    ));
}

}

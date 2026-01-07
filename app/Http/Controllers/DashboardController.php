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

    
    $totalStaff = User::role('staff')->count();

    $latestTickets = Ticket::with('category')
    ->latest()
    ->take(10)
    ->get();

    // Monthly ticket counts by status for current year
    $monthlyTickets = [
        'baru' => [],
        'proses' => [],
        'selesai' => [],
        'ditolak' => []
    ];

    $currentYear = now()->year;
    for ($month = 1; $month <= 12; $month++) {
        $monthlyTickets['baru'][] = Ticket::where('status', 'baru')
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $currentYear)
            ->count();
        $monthlyTickets['proses'][] = Ticket::where('status', 'proses')
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $currentYear)
            ->count();
        $monthlyTickets['selesai'][] = Ticket::where('status', 'selesai')
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $currentYear)
            ->count();
        $monthlyTickets['ditolak'][] = Ticket::where('status', 'ditolak')
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $currentYear)
            ->count();
    }

    return view('dashboard', compact(
    'totalTickets',
    'ticketsThisMonth',
    'ticketsThisYear',
    'completedTickets',
    'totalStaff',
    'latestTickets',
    'monthlyTickets'
    ));
}

}

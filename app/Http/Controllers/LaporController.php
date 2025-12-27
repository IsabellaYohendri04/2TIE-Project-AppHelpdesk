<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporController extends Controller
{
    public function index()
    {
        return view('user.lapor');
    }

    public function store(Request $request)
    {
        return back()->with('success', 'Laporan terkirim');
    }
}

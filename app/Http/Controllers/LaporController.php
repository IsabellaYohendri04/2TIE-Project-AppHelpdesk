<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Ticket;
use Illuminate\Http\Request;

class LaporController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('name')->get();
        $tickets = Ticket::with(['staff', 'category'])
            ->latest()
            ->paginate(10);

        return view('user.lapor', [
            'categories' => $categories,
            'tickets' => $tickets,
            'statusLabels' => Ticket::daftarStatus(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nim' => ['nullable', 'string', 'max:50'],
            'nama_mahasiswa' => ['nullable', 'string', 'max:191'],
            'judul' => ['required', 'string', 'max:191'],
            'category_id' => ['required', 'exists:categories,id'],
            'deskripsi' => ['nullable', 'string'],
        ]);

        Ticket::create([
            'nim' => $request->nim,
            'nama_mahasiswa' => $request->nama_mahasiswa,
            'judul' => $request->judul,
            'category_id' => $request->category_id,
            'deskripsi' => $request->deskripsi,
            'status' => Ticket::STATUS_BARU, // Default status baru untuk guest
        ]);

        return back()->with('success', 'Laporan berhasil dikirim! Terima kasih telah melaporkan masalah Anda.');
    }
}

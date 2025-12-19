<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Tampilkan daftar tiket helpdesk (Admin).
     */
    public function index()
    {
        $tickets = Ticket::with('staff')->latest()->paginate(10);

        return view('admin.ticket.index', [
            'tickets' => $tickets,
        ]);
    }

    /**
     * Form tambah tiket baru.
     */
    public function create()
    {
        $statusList = Ticket::daftarStatus();
        $kategoriList = Ticket::daftarKategori();
        $staffList = User::role('staff')->get();

        return view('admin.ticket.create', compact('statusList', 'kategoriList', 'staffList'));
    }

    /**
     * Simpan tiket baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nim' => ['nullable', 'string', 'max:50'],
            'nama_mahasiswa' => ['nullable', 'string', 'max:191'],
            'judul' => ['required', 'string', 'max:191'],
            'kategori' => ['required', 'string'],
            'deskripsi' => ['nullable', 'string'],
            'status' => ['required', 'string'],
            'assigned_to' => ['nullable', 'exists:users,id'],
        ]);

        Ticket::create($request->all());

        return redirect()
            ->route('admin.ticket.index')
            ->with('success', 'Tiket helpdesk berhasil dibuat.');
    }

    /**
     * Form edit tiket.
     */
    public function edit(Ticket $ticket)
    {
        $statusList = Ticket::daftarStatus();
        $kategoriList = Ticket::daftarKategori();
        $staffList = User::role('staff')->get();

        return view('admin.ticket.edit', compact('ticket', 'statusList', 'kategoriList', 'staffList'));
    }

    /**
     * Update tiket.
     */
    public function update(Request $request, Ticket $ticket)
    {
        $request->validate([
            'nim' => ['nullable', 'string', 'max:50'],
            'nama_mahasiswa' => ['nullable', 'string', 'max:191'],
            'judul' => ['required', 'string', 'max:191'],
            'kategori' => ['required', 'string'],
            'deskripsi' => ['nullable', 'string'],
            'status' => ['required', 'string'],
            'assigned_to' => ['nullable', 'exists:users,id'],
        ]);

        $ticket->update($request->all());

        return redirect()
            ->route('admin.ticket.index')
            ->with('success', 'Tiket helpdesk berhasil diperbarui.');
    }

    /**
     * Hapus tiket.
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        return redirect()
            ->route('admin.ticket.index')
            ->with('success', 'Tiket helpdesk berhasil dihapus.');
    }
}



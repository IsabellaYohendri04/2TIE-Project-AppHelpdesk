<?php

namespace App\Http\Controllers;

use App\Models\Category;
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
        $tickets = Ticket::with(['staff', 'category'])->latest()->paginate(10);

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
        $staffList = User::role('staff')->with('categories')->get();
        $categories = Category::orderBy('name')->get();

        return view('admin.ticket.create', compact('statusList', 'staffList', 'categories'));
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
            'category_id' => ['required', 'exists:categories,id'],
            'deskripsi' => ['nullable', 'string'],
            'status' => ['required', 'string'],
            'assigned_to' => ['nullable', 'exists:users,id', function ($attribute, $value, $fail) use ($request) {
                if ($value && $request->category_id) {
                    $staff = User::find($value);
                    if (! $staff->categories()->where('category_id', $request->category_id)->exists()) {
                        $fail('Staf yang dipilih tidak memiliki kategori yang sesuai dengan tiket.');
                    }
                }
            }],
        ]);

        Ticket::create([
            'nim' => $request->nim,
            'nama_mahasiswa' => $request->nama_mahasiswa,
            'category_id' => $request->category_id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'status' => $request->status,
            'assigned_to' => $request->assigned_to,
        ]);

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
        $staffList = User::role('staff')->with('categories')->get();
        $categories = Category::orderBy('name')->get();

        return view('admin.ticket.edit', compact('ticket', 'statusList', 'staffList', 'categories'));
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
            'category_id' => ['required', 'exists:categories,id'],
            'deskripsi' => ['nullable', 'string'],
            'status' => ['required', 'string'],
            'assigned_to' => [
                'nullable',
                'exists:users,id',
                function ($attribute, $value, $fail) use ($request) {

                    if (! $value) {
                        return;
                    }

                    $staff = User::with('categories:id')->find($value);

                    if (! $staff) {
                        $fail('Staf tidak ditemukan.');

                        return;
                    }

                    // ambil ID kategori staf
                    $staffCategoryIds = $staff->categories->pluck('id')->toArray();

                    if (! in_array((int) $request->category_id, $staffCategoryIds)) {
                        $fail('Staf yang dipilih tidak memiliki kategori yang sesuai dengan tiket.');
                    }
                },
            ],
        ]);

        $ticket->update([
            'nim' => $request->nim,
            'nama_mahasiswa' => $request->nama_mahasiswa,
            'category_id' => $request->category_id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'status' => $request->status,
            'assigned_to' => $request->assigned_to,
        ]);

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

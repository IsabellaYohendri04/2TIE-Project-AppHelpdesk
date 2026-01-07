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
    public function index(Request $request)
    {
        $query = Ticket::with(['staff', 'category']);

        // Apply search keyword filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_mahasiswa', 'LIKE', '%' . $search . '%')
                  ->orWhere('judul', 'LIKE', '%' . $search . '%')
                  ->orWhereHas('category', function ($subQ) use ($search) {
                      $subQ->where('name', 'LIKE', '%' . $search . '%');
                  })
                  ->orWhere('status', 'LIKE', '%' . $search . '%')
                  ->orWhereHas('staff', function ($subQ) use ($search) {
                      $subQ->where('name', 'LIKE', '%' . $search . '%');
                  });
            });
        }

        // Apply category filter
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Apply status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Apply staff filter
        if ($request->filled('assigned_to')) {
            $query->where('assigned_to', $request->assigned_to);
        }

        $tickets = $query->latest()->paginate(10)->appends($request->query());

        $statusList = Ticket::daftarStatus();
        $staffList = User::role('staff')->with('categories')->get();
        $categories = Category::orderBy('name')->get();

        return view('admin.ticket.index', [
            'tickets' => $tickets,
            'statusList' => $statusList,
            'staffList' => $staffList,
            'categories' => $categories,
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

    /**
     * Tampilkan daftar tiket untuk staff (hanya kategori yang sesuai).
     */
    public function staffIndex(Request $request)
    {
        $user = auth()->user();
        $staffCategoryIds = $user->categories->pluck('id')->toArray();

        $query = Ticket::with(['staff', 'category']);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_mahasiswa', 'LIKE', '%' . $search . '%')
                  ->orWhere('judul', 'LIKE', '%' . $search . '%')
                  ->orWhereHas('category', function ($subQ) use ($search) {
                      $subQ->where('name', 'LIKE', '%' . $search . '%');
                  })
                  ->orWhere('status', 'LIKE', '%' . $search . '%')
                  ->orWhereHas('staff', function ($subQ) use ($search) {
                      $subQ->where('name', 'LIKE', '%' . $search . '%');
                  });
            });
        }

        // Category filter
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Prioritaskan status proses, lalu lainnya berdasarkan created_at terbaru
        $query->orderByRaw("FIELD(status, 'proses', 'baru', 'selesai', 'ditolak')");
        $query->latest();

        $tickets = $query->paginate(12)->appends($request->query());

        $statusList = Ticket::daftarStatus();
        $categories = Category::orderBy('name')->get();

        return view('staff.ticket.index', [
            'tickets' => $tickets,
            'statusList' => $statusList,
            'categories' => $categories,
            'staffCategoryIds' => $staffCategoryIds,
            'isAssignedView' => false,
        ]);
    }

    /**
     * Daftar tiket yang ditugaskan ke staff (assigned_to = user).
     */
    public function staffAssigned(Request $request)
    {
        $user = auth()->user();
        $staffCategoryIds = $user->categories->pluck('id')->toArray();

        $query = Ticket::with(['staff', 'category'])
            ->where('assigned_to', $user->id);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_mahasiswa', 'LIKE', '%' . $search . '%')
                  ->orWhere('judul', 'LIKE', '%' . $search . '%')
                  ->orWhereHas('category', function ($subQ) use ($search) {
                      $subQ->where('name', 'LIKE', '%' . $search . '%');
                  })
                  ->orWhere('status', 'LIKE', '%' . $search . '%');
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $query->orderByRaw("FIELD(status, 'proses', 'baru', 'selesai', 'ditolak')");
        $query->latest();

        $tickets = $query->paginate(12)->appends($request->query());

        $statusList = Ticket::daftarStatus();
        $categories = Category::orderBy('name')->get();

        return view('staff.ticket.index', [
            'tickets' => $tickets,
            'statusList' => $statusList,
            'categories' => $categories,
            'staffCategoryIds' => $staffCategoryIds,
            'isAssignedView' => true,
        ]);
    }

    /**
     * Form tambah tiket baru untuk staff.
     */
    public function staffCreate()
    {
        $user = auth()->user();
        $statusList = Ticket::daftarStatus();
        
        // Load categories - gunakan collection untuk memastikan relasi ter-load
        $categories = $user->categories;
        
        if ($categories->isEmpty()) {
            return redirect()
                ->route('staff.ticket.index')
                ->with('error', 'Anda belum memiliki kategori yang ditugaskan. Silakan hubungi admin.');
        }
        
        // Sort categories by name
        $categories = $categories->sortBy('name')->values();

        return view('staff.ticket.create', compact('statusList', 'categories'));
    }

    /**
     * Simpan tiket baru untuk staff.
     */
    public function staffStore(Request $request)
    {
        $user = auth()->user();
        // Load categories dulu untuk memastikan relasi ter-load
        $userCategoryIds = $user->categories->pluck('id')->toArray();

        $request->validate([
            'nim' => ['nullable', 'string', 'max:50'],
            'nama_mahasiswa' => ['nullable', 'string', 'max:191'],
            'judul' => ['required', 'string', 'max:191'],
            'category_id' => [
                'required',
                'exists:categories,id',
                function ($attribute, $value, $fail) use ($userCategoryIds) {
                    if (!in_array((int)$value, $userCategoryIds)) {
                        $fail('Kategori yang dipilih tidak sesuai dengan kategori Anda.');
                    }
                }
            ],
            'deskripsi' => ['nullable', 'string'],
            'status' => ['required', 'string'],
        ]);

        Ticket::create([
            'nim' => $request->nim,
            'nama_mahasiswa' => $request->nama_mahasiswa,
            'category_id' => $request->category_id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'status' => $request->status,
            'assigned_to' => $user->id, // Auto assign ke staff yang membuat
        ]);

        return redirect()
            ->route('staff.ticket.index')
            ->with('success', 'Tiket helpdesk berhasil dibuat.');
    }

    /**
     * Form edit tiket untuk staff.
     */
    public function staffEdit(Ticket $ticket)
    {
        $user = auth()->user();
        // Load categories dulu untuk memastikan relasi ter-load
        $userCategoryIds = $user->categories->pluck('id')->toArray();

        // Pastikan tiket memiliki kategori yang sesuai dengan staff
        if (!in_array((int)$ticket->category_id, $userCategoryIds)) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit tiket ini.');
        }

        $statusList = Ticket::daftarStatus();
        // Gunakan collection yang sudah di-load dan sort
        $categories = $user->categories->sortBy('name')->values();

        return view('staff.ticket.edit', compact('ticket', 'statusList', 'categories'));
    }

    /**
     * Update tiket untuk staff.
     */
    public function staffUpdate(Request $request, Ticket $ticket)
    {
        $user = auth()->user();
        // Load categories dulu untuk memastikan relasi ter-load
        $userCategoryIds = $user->categories->pluck('id')->toArray();

        // Pastikan tiket memiliki kategori yang sesuai dengan staff
        if (!in_array((int)$ticket->category_id, $userCategoryIds)) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit tiket ini.');
        }

        $request->validate([
            'nim' => ['nullable', 'string', 'max:50'],
            'nama_mahasiswa' => ['nullable', 'string', 'max:191'],
            'judul' => ['required', 'string', 'max:191'],
            'category_id' => [
                'required',
                'exists:categories,id',
                function ($attribute, $value, $fail) use ($userCategoryIds) {
                    if (!in_array((int)$value, $userCategoryIds)) {
                        $fail('Kategori yang dipilih tidak sesuai dengan kategori Anda.');
                    }
                }
            ],
            'deskripsi' => ['nullable', 'string'],
            'status' => ['required', 'string'],
        ]);

        $ticket->update([
            'nim' => $request->nim,
            'nama_mahasiswa' => $request->nama_mahasiswa,
            'category_id' => $request->category_id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'status' => $request->status,
            'assigned_to' => $user->id, // Update assigned_to ke staff yang mengupdate
        ]);

        return redirect()
            ->route('staff.ticket.index')
            ->with('success', 'Tiket helpdesk berhasil diperbarui.');
    }
}

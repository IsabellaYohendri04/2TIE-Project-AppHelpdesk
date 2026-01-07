<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class StaffUserController extends Controller
{
    /**
     * Tampilkan daftar user dengan role staf.
     */
    public function index(Request $request)
    {
        $query = User::role('staff')
            ->withCount('ticketsHandled')
            ->with('categories');

        // Apply search keyword filter on name (username)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'LIKE', '%'.$search.'%');
        }

        // Apply category filter
        if ($request->filled('category_id')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->category_id);
            });
        }

        $staffUsers = $query->orderBy('name')->paginate(10)->appends($request->query());

        $categories = Category::orderBy('name')->get();

        return view('admin.staff.index', compact('staffUsers', 'categories'));
    }

    /**
     * Form tambah user staf.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.staff.create', compact('categories'));
    }

    /**
     * Simpan user staf baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'string', 'email', 'max:191', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'category_id' => ['nullable', 'exists:categories,id'],
        ]);

        $user = User::create($validated);
        $user->assignRole('staff');
        $user->categories()->sync($validated['category_id'] ? [$validated['category_id']] : []);

        return redirect()
            ->route('admin.staff.index')
            ->with('success', 'User staf berhasil dibuat.');
    }

    /**
     * Form edit user staf.
     */
    public function edit(User $staff)
    {
        // Pastikan hanya user dengan role staff
        if (! $staff->hasRole('staff')) {
            abort(404);
        }

        $categories = Category::orderBy('name')->get();

        return view('admin.staff.edit', compact('staff', 'categories'));
    }

    /**
     * Update data user staf.
     */
    public function update(Request $request, User $staff)
    {
        if (! $staff->hasRole('staff')) {
            abort(404);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'string', 'email', 'max:191', 'unique:users,email,'.$staff->id],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
            'category_id' => ['nullable', 'exists:categories,id'],
        ]);

        $staff->name = $validated['name'];
        $staff->email = $validated['email'];

        if (! empty($validated['password'])) {
            $staff->password = $validated['password']; // akan di-hash oleh cast
        }

        $staff->save();
        $staff->categories()->sync($validated['category_id'] ? [$validated['category_id']] : []);

        return redirect()
            ->route('admin.staff.index')
            ->with('success', 'User staf berhasil diperbarui.');
    }

    /**
     * Hapus user staf.
     */
    public function destroy(User $staff)
    {
        if (! $staff->hasRole('staff')) {
            abort(404);
        }

        $staff->delete();

        return redirect()
            ->route('admin.staff.index')
            ->with('success', 'User staf berhasil dihapus.');
    }
}

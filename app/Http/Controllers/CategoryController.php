<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::withCount(['users', 'tickets']);

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            if (is_numeric($search)) {
                // If search is numeric, filter by exact count matches
                $query->where(function ($q) use ($search) {
                    $q->where('users_count', $search)
                        ->orWhere('tickets_count', $search);
                });
            } else {
                // If search is text, filter by category name
                $query->where('name', 'LIKE', '%'.$search.'%');
            }
        }

        $categories = $query->orderBy('name')
            ->paginate(10)
            ->appends($request->query());

        return view('admin.category.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:191', 'unique:categories,name'],
            'description' => ['nullable', 'string'],
        ]);

        Category::create($validated);

        return redirect()->route('admin.category.index')->with('success', 'Kategori berhasil dibuat.');
    }

    public function edit(Category $category)
    {
        return view('admin.category.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:191', 'unique:categories,name,'.$category->id],
            'description' => ['nullable', 'string'],
        ]);

        $category->update($validated);

        return redirect()->route('admin.category.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.category.index')->with('success', 'Kategori berhasil dihapus.');
    }
}

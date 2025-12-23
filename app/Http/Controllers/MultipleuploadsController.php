<?php

namespace App\Http\Controllers;

use App\Models\Multipleuploads;
use Illuminate\Http\Request;

class MultipleuploadsController extends Controller
{

    public function index()
    {
        return view('profile.multipleuploads');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'filename' => 'required',
            'filename.*' => 'mimes:jpg,jpeg,png,pdf,docx|max:2048'
        ]);

       
        if ($request->hasfile('filename')) {
            foreach ($request->file('filename') as $file) {
                // Membuat nama unik untuk setiap file
                $name = time() . rand(1, 100) . '.' . $file->extension();

                // Memindahkan file ke folder public/uploads
                $file->move(public_path('uploads'), $name);

                // Menyimpan nama file ke database menggunakan Model
                Multipleuploads::create([
                    'filename' => $name
                ]);
            }
        }

        return back()->with('success', 'File berhasil diunggah!');
    }
    public function show(Multipleuploads $multipleuploads)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Multipleuploads $multipleuploads)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Multipleuploads $multipleuploads)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Multipleuploads $multipleuploads)
    {
        //
    }
}

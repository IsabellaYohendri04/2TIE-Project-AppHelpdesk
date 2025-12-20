<?php

use Illuminate\Http\Request;
use App\Models\Multipleuploads;
use App\Http\Controllers\Controller;
class MultipleuploadsController extends Controller
{
public function index()
    {
        return view('multipleuploads');
    }

    public function store(Request $request)
    {
        $request->validate([
            'filename' => 'required',
            'filename.*' => 'mimes:doc,docx,PDF,pdf,jpg,jpeg,png|max:2000'
        ]);
        if ($request->hasfile('filename')) { 
            $files = [];
            foreach ($request->file('filename') as $file) {
                if ($file->isValid()) {
                    $filename = round(microtime(true) * 1000).'-'.str_replace(' ','-',$file->getClientOriginalName());
                    $file->move(public_path('images'), $filename);                    
                    $files[] = [
                        'filename' => $filename,
                    ];
                }
            }
            Multipleuploads::insert($files);            
            echo'Success';
        }else{
            echo'Gagal';
        }
    }}
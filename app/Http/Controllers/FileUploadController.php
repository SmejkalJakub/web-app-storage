<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function upload_file(Request $request)
    {
        $request->validate([
            'file' => 'required',
        ]);

        $fileName = time().'.'.$request->file->extension();
        error_log($fileName);


        $request->file->move(public_path('files'), $fileName);

        return back()
            ->with('success','You have successfully upload file.')
            ->with('file',$fileName);

    }
}

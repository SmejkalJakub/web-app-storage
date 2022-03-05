<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use Illuminate\Support\Str;
use DateTime;


class FileUploadController extends Controller
{
    public function upload_file(Request $request)
    {
        $request->validate([
            'file' => 'required',
        ]);

        $randomNameString = Str::random(30);
        $randomAdminString = Str::random(15);

        $fileName = $randomNameString.'.'.$request->file->extension();

        $file = new File();
        $file->file_link = $randomNameString;
        $file->admin_link = $randomAdminString;
        $file->file_storage_path = $fileName;
        $file->original_name = $request->file->getClientOriginalName();
        $file->extension = $request->file->extension();
        $file->number_of_downloads = 0;
        $file->delete_date = new DateTime('now');


        $request->file->move(public_path('files'), $fileName);
        $file->save();

        return back()
            ->with('success','You have successfully upload file.')
            ->with('file',$fileName);

    }
}

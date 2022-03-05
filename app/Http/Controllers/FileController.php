<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use Illuminate\Support\Str;
use DateTime;
use Storage;
use Session;

class FileController extends Controller
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
        $file->delete_date = $request->delete_date;

        $request->file->move(storage_path('files'), $fileName);
        $file->save();

        Session::flash('message', 'File succesfuly uploaded');
        return redirect()->route('file.view.admin', [$file->file_link, $file->admin_link]);
    }

    public function delete_file($file_link)
    {
        $file = File::where('file_link', '=', $file_link)->first();
        if(File::exists(storage_path('files/'.$file->file_storage_path)) )
        {
            unlink(storage_path('files/'.$file->file_storage_path));
        }
        File::where('file_link', '=', $file_link)->delete();

        Session::flash('message', 'File succesfuly deleted');
        return redirect()->route('home');
    }
}

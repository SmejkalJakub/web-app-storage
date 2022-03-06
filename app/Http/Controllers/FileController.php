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
        $this->delete_file_from_server($file_link, $file->file_storage_path);

        Session::flash('message', 'File succesfuly deleted');
        return redirect()->route('home');
    }

    public function delete_expired_files()
    {
        $files = File::all();

        $date_now = new DateTime();
        foreach ($files as $file)
        {
            $delete_date = new DateTime($file->delete_date);
            if($date_now > $delete_date)
            {
                $this->delete_file_from_server($file->file_link, $file->file_storage_path);
            }
        }
    }

    private function delete_file_from_server($file_link, $file_path)
    {
        if(File::exists(storage_path('files/'.$file_path)) )
        {
            unlink(storage_path('files/'.$file_path));
        }
        File::where('file_link', '=', $file_link)->delete();
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use Illuminate\Support\Str;
use DateTime;
use Storage;
use Session;

class FileEditController extends Controller
{
    // Saves all
    public function save_edit(Request $request)
    {
        $request->validate([
            'delete_date' => 'required',
        ]);

        $file = File::where('file_link', '=', $request->file_link)->first();

        $file->delete_date = $request->delete_date;
        $file->save();

        Session::flash('message', 'File succesfuly updated');
        return redirect()->route('file.view.admin', [$request->file_link, $request->admin_link]);
    }

    // Generates the new link for users and redirects to it
    public function new_link($file_link, $admin_link)
    {
        $randomString = Str::random(30);

        $file = File::where('file_link', '=', $file_link)->first();

        rename(storage_path('files/'.$file_link.'.'.$file->extension), storage_path('files/'.$randomString.'.'.$file->extension));

        $file->file_link = $randomString;
        $file->file_storage_path = $randomString.'.'.$file->extension;
        $file->save();

        return redirect()->route('file.view.admin', [$file->file_link, $file->admin_link]);
    }

    // Generates new admin link and redirects to it
    public function new_admin_link($file_link, $admin_link)
    {
        $file = File::where('file_link', '=', $file_link)->first();

        $file->admin_link = Str::random(15);
        $file->save();

        return redirect()->route('file.view.admin', [$file->file_link, $file->admin_link]);
    }
}

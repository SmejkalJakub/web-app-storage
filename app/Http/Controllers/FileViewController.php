<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use Illuminate\Support\Str;
use DateTime;
use DB;

/*
    Autorský soubor
    Autor: Jakub Smejkal, Klára Formánková
*/

class FileViewController extends Controller
{
    // Redirects to the user view of the file upload
    public function view_file($file_link)
    {
        $file = File::where('file_link', '=', $file_link)->first();
        return view('file_view', compact('file'));
    }

    // Redirects to the admin view of the file upload
    public function view_file_admin($file_link, $admin_link)
    {
        $file = DB::table('files')
                ->where('file_link', '=', $file_link)
                ->where('admin_link', '=', $admin_link)
                ->first();

        return view('file_admin_view', compact('file'));
    }
}

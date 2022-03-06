<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use Illuminate\Support\Str;
use DateTime;
use DB;


class FileViewController extends Controller
{
    public function view_file($file_link)
    {
        $file = File::where('file_link', '=', $file_link)->first();
        return view('file_view', compact('file'));
    }

    public function view_file_admin($file_link, $admin_link)
    {
        $file = DB::table('files')
                ->where('file_link', '=', $file_link)
                ->where('admin_link', '=', $admin_link)
                ->first();

        return view('file_admin_view', compact('file'));
    }
}

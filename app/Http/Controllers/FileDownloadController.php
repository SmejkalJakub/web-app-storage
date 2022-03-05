<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use Storage;
use Response;

class FileDownloadController extends Controller
{
    public function download($file_link) {
        $file = File::where('file_link', '=', $file_link)->first();

        $path = storage_path().'/'.'files/'.$file->file_storage_path;
        if (file_exists($path)) {
            error_log($path);
            return Response::download($path, $file->original_name);
        }
    }
}

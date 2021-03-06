<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use Storage;
use Response;

/*
    Autorský soubor
    Autor: Jakub Smejkal, Klára Formánková
*/

class FileDownloadController extends Controller
{
    // Takes care of downloading the file from storage with original name and extension
    public function download($file_link) {
        $file = File::where('file_link', '=', $file_link)->first();

        $path = storage_path().'/'.'files/'.$file->file_storage_path;
        if (file_exists($path)) {
            $file->number_of_downloads = $file->number_of_downloads + 1;
            $file->save();
            return Response::download($path, $file->original_name);
        }
    }
}

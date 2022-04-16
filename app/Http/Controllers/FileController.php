<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;
use Illuminate\Support\Str;
use DateTime;
use Storage;
use Session;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\AbstractHandler;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

class FileController extends Controller
{
    /*public function upload_file(Request $request)
    {
        /*$request->validate([
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
    }*/

    public function upload_file(FileReceiver $receiver)
    {
        error_log('Some message here.');
        // check if the upload is success, throw exception or return response you need
        if ($receiver->isUploaded() === false) {
            throw new UploadMissingFileException();
        }
        // receive the file
        $save = $receiver->receive();

        // check if the upload has finished (in chunk mode it will send smaller files)
        if ($save->isFinished()) {
            $randomNameString = Str::random(30);
            $randomAdminString = Str::random(15);

            $wholeFile = $save->getFile();
            $fileName = $randomNameString.'.'.$wholeFile->extension();

            $file = new File();
            $file->file_link = $randomNameString;
            $file->admin_link = $randomAdminString;
            $file->file_storage_path = $fileName;
            $file->original_name = $wholeFile->getClientOriginalName();
            $file->extension = $wholeFile->extension();
            $file->number_of_downloads = 0;
            $file->delete_date = new DateTime((now()->addDays(30))->toDateTimeString());
            $wholeFile->move(storage_path('files'), $fileName);
            $file->save();

            return response()->json([
                "file_link" => $randomNameString,
                "admin_link" => $randomAdminString
            ]);
        }


        $handler = $save->handler();
        return response()->json([
            "done" => $handler->getPercentageDone()
        ]);
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

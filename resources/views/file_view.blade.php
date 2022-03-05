<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>File</title>

    </head>
    <body>
        <div>
            FILE
        </div>

        <div>
            {{$file->original_name}}
        </div>
        <div>
            Staženo: {{$file->number_of_downloads}}x
        </div>

        <a href="{{ route('file.download', $file->file_link) }}"
            class="btn btn-sm btn-primary">Download</a>

    </body>
</html>

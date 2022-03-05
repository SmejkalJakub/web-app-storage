<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>File Admin</title>

    </head>
    <body>
        <div>
            FILE ADMIN
        </div>

        <div class="row">
            <div class="col">
                @if(Session::has('message'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                        {{ Session('message') }}
                    </div>
                @endif

                @if(Session::has('delete-message'))
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                        {{ Session('delete-message') }}
                    </div>
                @endif
            </div>
        </div>

        <div>
            {{$file->original_name}}
        </div>
        <div>
            Staženo: {{$file->number_of_downloads}}x
        </div>
        <div>
            Datum smazání: {{$file->delete_date}}
        </div>
        <div>
            Odkaz pro sdílení: {{URL::to('/')}}/{{$file->file_link}}
        </div>
        <div>
            Odkaz pro vás(úpravy a mazání): {{URL::to('/')}}/{{$file->file_link}}/{{$file->admin_link}}
        </div>

        <a href="{{ route('file.download', $file->file_link) }}"
            class="btn btn-sm btn-primary">Download</a>

        <a href="{{ route('file.delete', $file->file_link) }}"
            class="btn btn-sm btn-primary">Delete</a>

    </body>
</html>

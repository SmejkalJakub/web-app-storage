<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>File</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    </head>
    <body>
        <div class="container">
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

            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h1>File</h1>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                {{$file->original_name}}
                            </div>
                            <div class="row">
                                Staženo: {{$file->number_of_downloads}}x
                            </div>

                            <div class="row">
                                <a href="{{ route('file.download', $file->file_link) }}"
                                    class="btn btn-sm btn-primary">Stáhnout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

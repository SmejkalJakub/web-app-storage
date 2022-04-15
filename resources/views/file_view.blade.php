<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Zásilka</title>
        <link rel="stylesheet" type="text/css" href="{{ url('/css/style.css') }}" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
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
                            <h1 class="zasilkarna">Zásilkárna</h1>
                        </div>
                        <div class="card-body">
                            <h5>Vaše zásilka</h5>
                            <div class="row filename">
                                <span class="file">
                                    <i class="bi bi-file-earmark-richtext"></i>
                                    {{$file->original_name}}
                                </span>
                                <span class="icons">
                                    <button class="btn btn-sm btn-info">
                                        <a href="{{ route('file.download', $file->file_link) }}"
                                            class="btn btn-sm btn-link btn-download">
                                            <i class="bi bi-download" data-toggle="tooltip" title="Stáhnout"></i>
                                        </a>
                                    </button>
                                </span>
                            </div>
                            <div class="row downloads">
                                <span class="text-downloads">Staženo: {{$file->number_of_downloads}}x</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

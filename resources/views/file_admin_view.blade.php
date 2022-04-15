<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Zásilka</title>
        <link rel="stylesheet" type="text/css" href="{{ url('/css/style.css') }}" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

        <script type="text/javascript" src="{{URL::asset('js/copyToClipboard.js')}}"></script>

    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col">
                    @if(Session::has('message'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            {{ Session('message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
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
                            <h5>Zásilka úspěšně odeslána!</h5>
                            <div class="row filename">
                                <span class="file">
                                    <i class="bi bi-file-earmark-richtext"></i>
                                    {{$file->original_name}}
                                </span>
                                <span class="icons">
                                    <a href="{{ route('file.download', $file->file_link) }}"
                                        class="btn btn-sm btn-link btn-download">
                                        <i class="bi bi-download" data-toggle="tooltip" title="Stáhnout"></i>
                                    </a>
                                    <a href="{{ route('file.delete', $file->file_link) }}"
                                        class="btn btn-sm btn-link btn-trash" data-toggle="tooltip" title="Odstranit">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </span>
                            </div>
                            <div class="row downloads">
                                <span class="text-downloads">Staženo: {{$file->number_of_downloads}}x</span>
                            </div>
                            <hr>
                            <form action="{{ route('file.edit.save') }}" method="POST">
                                {{ csrf_field() }}
                                <input type="hidden" name="file_link" value={{$file->file_link}}>
                                <input type="hidden" name="admin_link" value={{$file->admin_link}}>
                                <div class="row">
                                    <div class="form-group">
                                        <label for="delete_date">Uloženo do:</label>
                                        <input type="date" id="delete_date" name="delete_date" value="{{$file->delete_date}}">
                                        <button type="submit" class="btn btn-sm btn-info">Uložit</button>
                                    </div>
                                </div>
                            </form>
                            <hr>
                            <div>
                                <div class="link-header">
                                    Odkaz pro sdílení:
                                </div>
                                <div class="url">
                                    <span id="file-link">{{URL::to('/')}}/{{$file->file_link}}</span>
                                    <i id="file-link-icon" class="bi bi-clipboard" onclick="CopyToClipboard('file-link')"></i>
                                </div>
                                <div class="new-link">
                                    <a href="{{ route('file.new.link', [$file->file_link, $file->admin_link]) }}"
                                        class="btn btn-sm btn-info new-link-button">Nový odkaz</a>
                                </div>
                            </div>
                            <div>
                                <div class="link-header">
                                    Administrátorský odkaz:
                                </div>
                                <div class="url">
                                <span id="file-admin-link">{{URL::to('/')}}/{{$file->file_link}}/{{$file->admin_link}}</span>
                                    <i id="file-admin-link-icon" class="bi bi-clipboard" onclick="CopyToClipboard('file-admin-link')"></i>
                                </div>
                                <div class="new-link">
                                    <a href="{{ route('file.new.admin.link', [$file->file_link, $file->admin_link]) }}"
                                        class="btn btn-sm btn-info new-link-button">Nový admin odkaz</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

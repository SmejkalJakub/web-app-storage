<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>File Admin</title>
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
                            <h1>File Admin</h1>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                {{$file->original_name}}
                            </div>
                            <div class="row">
                                Staženo: {{$file->number_of_downloads}}x
                            </div>
                            <form action="{{ route('file.edit.save') }}" method="POST">
                                {{ csrf_field() }}
                                <input type="hidden" name="file_link" value={{$file->file_link}}>
                                <input type="hidden" name="admin_link" value={{$file->admin_link}}>
                                <div class="row">
                                    <div class="p-3">
                                        <div class="form-group">
                                            <label for="delete_date">Datum smazání:</label>
                                            <input type="date" id="delete_date" name="delete_date" value="{{$file->delete_date}}">
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success">Uložit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="row">
                                Odkaz pro sdílení: {{URL::to('/')}}/{{$file->file_link}}
                                <a href="{{ route('file.new.link', [$file->file_link, $file->admin_link]) }}"
                                    class="btn btn-sm btn-primary">Nový link</a>
                            </div>
                            <div class="row">
                                Odkaz pro vás(úpravy a mazání): {{URL::to('/')}}/{{$file->file_link}}/{{$file->admin_link}}
                                <a href="{{ route('file.new.admin.link', [$file->file_link, $file->admin_link]) }}"
                                    class="btn btn-sm btn-primary">Nový admin link</a>
                            </div>

                            <div class="row">
                                <a href="{{ route('file.download', $file->file_link) }}"
                                    class="btn btn-sm btn-primary">Stáhnout</a>
                                <a href="{{ route('file.delete', $file->file_link) }}"
                                class="btn btn-sm btn-danger">Smazat</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

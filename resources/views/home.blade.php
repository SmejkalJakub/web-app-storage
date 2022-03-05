<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Home</title>

    </head>
    <body>
        <div>
            HOME
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

        <form action="{{ route('upload.file') }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">

                <div class="col-md-6">
                    <input type="file" name="file" class="form-control">
                </div>

                <div class="col-md-6">
                    <input type="date" value={{(now()->addDays(30))->toDateTimeString()}} name="delete_date" class="form-control">
                </div>

                <div class="col-md-6">
                    <button type="submit" class="btn btn-success">Upload</button>
                </div>

            </div>
        </form>
    </body>
</html>

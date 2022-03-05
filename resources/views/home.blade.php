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

        <form action="{{ route('upload.file') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">

                <div class="col-md-6">
                    <input type="file" name="file" class="form-control">
                </div>

                <div class="col-md-6">
                    <button type="submit" class="btn btn-success">Upload</button>
                </div>

            </div>
        </form>
    </body>
</html>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Zásilkárna</title>
        <link href="/css/style.css" rel="stylesheet">
        <link href="/css/home.css" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

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
                            <h5 id="fileName">
                            </h5>

                            <!-- drag and drop inspiration source: 
                            Joseph Zimmerman 2018, How To Make A Drag-and-Drop File Uploader With Vanilla JavaScript, 
                            Smashing Magazine, accessed 8.4.2022, 
                            https://www.smashingmagazine.com/2018/01/drag-drop-file-uploader-vanilla-js/ -->
                            <div id="drop-area">
                                <form class="drop-area-form">
                                    <p>Přetáhněte soubor do čárkované oblasti nebo vyberte pomocí tlačítka</p>
                                    <input type="file" id="fileElem" onchange="handleFile(this.files)">
                                    <button type="button" class="btn btn-info" aria-label="Add file" id="addFileButton">
                                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Vybrat soubor
                                    </button>
                                </form>
                            </div>
                            <div class="send-btn-area">
                                <button type="button" class="btn btn-info" style="display: none" aria-label="Add file" id="sendFileButton">
                                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Odeslat
                                </button>
                            </div>
                            <div class="progress hide" id="upload-progress">
                                <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" style="width: 0%">
                                    <span class="sr-only"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript" src="{{URL::asset('js/resumable.js')}}"></script>

        <script type="text/javascript">
            let route = '{{ route('upload.file') }}';
            let token = '{{ csrf_token() }}';
        </script>

        <script type="text/javascript" src="{{URL::asset('js/resumableCallbacks.js')}}"></script>
        <script type="text/javascript" src="{{URL::asset('js/dropArea.js')}}"></script>

    </body>
</html>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Zásilkárna</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>

        <style>
            * {
                font-family: Arial, Helvetica, sans-serif;
            }
            .card {
                max-width: 700px;
                margin: 60px auto;
            }
            .card-body {
                align-items: left;
            }
            .zasilkarna {
                font-size: 25px;
                margin: auto;
            }
            .row {
                margin: auto;
            }

            #fileName {
                margin-bottom: 1rem;
            }
        </style>
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
                            <h5 id="fileName">Sdílejte něco</h5>

                            <form class="box" method="post" action="" enctype="multipart/form-data">
                                <div class="box__input">
                                    <input class="box__file" type="file" name="files[]" id="file" data-multiple-caption="{count} files selected" multiple />
                                    <label for="file"><strong>Choose a file</strong><span class="box__dragndrop"> or drag it here</span>.</label>
                                    <button class="box__button" type="submit">Upload</button>
                                </div>
                                <div class="box__uploading">Uploading…</div>
                                <div class="box__success">Done!</div>
                                <div class="box__error">Error! <span></span>.</div>
                            </form>




                            <!-- <button type="button" class="btn btn-success" aria-label="Add file" id="add-btn">
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Vybrat soubor
                            </button> -->

                            <button type="button" class="btn btn-info" aria-label="Add file" id="send-btn">
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Odeslat
                            </button>

                            <p>
                                <div class="progress hide" id="upload-progress">
                                    <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" style="width: 0%">
                                        <span class="sr-only"></span>
                                    </div>
                                </div>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript" src="{{URL::asset('js/resumable.js')}}"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

        <script>
            let progress = $('.progress');

            progress.hide();

            let browseFile = $('#add-btn');
            let resumable = new Resumable({
                target: '{{ route('upload.file') }}',
                query:{_token:'{{ csrf_token() }}'} ,
                chunkSize: 1*1024*1024,
                headers: {
                    'Accept' : 'application/json'
                },
                testChunks: true,
                maxChunkRetries: 1000,
                chunkRetryInterval: 2000,
                throttleProgressCallbacks: 1,
            });

            resumable.assignBrowse(browseFile[0]);

            resumable.on('fileAdded', function (file) {
                document.getElementById("fileName").innerHTML = file.file.name;
            });

            $('#send-btn').click(function(){
                resumable.upload();
            });

            resumable.on('fileProgress', function (file) {
                showProgress();
                if(navigator.onLine === true){
                    // trigger when file progress update
                    updateProgress(Math.floor(file.progress() * 100));
                }
                else{
                    alert('no Internet');
                }
            });

            resumable.on('fileSuccess', function (file, response) { // trigger when file upload complete
                responseJSON = JSON.parse(response);
                let baseUrl = "/";
                let finalUrl = baseUrl.concat(responseJSON.file_link, "/", responseJSON.admin_link);;
                window.location = finalUrl;
            });

            resumable.on('fileError', function (file, response) { // trigger when there is any error
                    console.log(response);
            });

            function showProgress() {
                progress.find('.progress-bar').css('width', '0%');
                progress.find('.progress-bar').html('0%');
                progress.find('.progress-bar').removeClass('bg-success');
                progress.show();
            }

            function updateProgress(value) {
                progress.find('.progress-bar').css('width', `${value}%`)
                progress.find('.progress-bar').html(`${value}%`)
            }

            function hideProgress() {
                progress.hide();
            }
        </script>
    </body>
</html>

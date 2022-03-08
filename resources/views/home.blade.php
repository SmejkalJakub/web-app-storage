<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Home</title>
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
                            <h1>Home</h1>
                        </div>
                        <div class="card-body">
                            <h3 id="fileName">
                                Žádný soubor...
                            </h3>

                            <button type="button" class="btn btn-success" aria-label="Add file" id="add-btn">
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Vybrat Soubor
                            </button>

                            <button type="button" class="btn btn-primary" aria-label="Add file" id="send-btn">
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

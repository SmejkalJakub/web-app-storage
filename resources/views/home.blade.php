<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Zásilkárna</title>
        <link href="/css/style.css" rel="stylesheet">
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

                            <div id="drop-area">
                                <form class="my-form">
                                    <p>Přetáhněte soubor do čárkované oblasti nebo vyberte pomocí tlačítka</p>
                                    <input type="file" id="fileElem" onchange="handleFile(this.files)">
                                    <button type="button" class="btn btn-info" aria-label="Add file" id="add-btn">
                                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Vybrat soubor
                                    </button>
                                </form>
                            </div>
                            <div class="send-btn-area">
                                <button type="button" class="btn btn-info" aria-label="Add file" id="send-btn">
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

        <script>
            let browseFile = $('#add-btn');
            let progress = $('.progress');
            let lastAddedFile = undefined;

            progress.hide();

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
                if(lastAddedFile !== undefined)
                {
                    resumable.files.shift();
                }
                console.log(resumable.files);

                lastAddedFile = browseFile[0];
                document.getElementById("fileName").innerHTML = file.file.name;
                document.getElementById("send-btn").style.display = "block";
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

            let dropArea = document.getElementById('drop-area')

            ;['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, preventDefaults, false);
            })

            function preventDefaults (e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ;['dragenter', 'dragover'].forEach(eventName => {
                dropArea.addEventListener(eventName, highlight, false);
            })

            ;['dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, unhighlight, false);
            })

            function highlight(e) {
                dropArea.classList.add('highlight');
            }

            function unhighlight(e) {
                dropArea.classList.remove('highlight');
            }

            dropArea.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                let dt = e.dataTransfer;
                let files = dt.files;

                handleFile(files);
            }

            function handleFile(files) {
                if (files.length > 1) {
                    alert('Můžete vložit pouze 1 soubor');
                }
                else {
                    browseFile = files;
                    resumable.addFile(browseFile[0]);
                }
            }

        </script>
    </body>
</html>

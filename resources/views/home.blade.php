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
                                    <button type="button" class="btn btn-info" aria-label="Add file" id="addFileButton">
                                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Vybrat soubor
                                    </button>
                                </form>
                            </div>
                            <div class="send-btn-area">
                                <button type="button" class="btn btn-info" aria-label="Add file" id="sendFileButton">
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
            // File browse button
            let browseFile = $('#addFileButton');

            // Progress bar
            let progress = $('.progress');

            // Last file that was added, is used to pop it out of the array of added files
            let lastAddedFile = undefined;

            // We will hide the progress bar at the begining
            progress.hide();

            // Instance of the resumable js library. Some crucial settings are defined here.
            // Most notable is the 'target' that selects what Controller function should be called
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

            // This function will bind the resumable instance to the 'browse file' button. Any action on that button will be then registered
            resumable.assignBrowse(browseFile[0]);

            // Function that is called when a file is added to the resumable instance. Either by browse file button or by the drag and drop system
            resumable.on('fileAdded', function (file) {

                // If any file was selected before, we will delete it
                if(lastAddedFile !== undefined)
                {
                    resumable.files.shift();
                }

                // Register current selected file as last added
                lastAddedFile = browseFile[0];

                // Show the data to the user and enable the send button
                document.getElementById("fileName").innerHTML = file.file.name;
                document.getElementById("sendFileButton").style.display = "block";
            });

            // Click event for the send button to upload the file
            $('#sendFileButton').click(function(){
                resumable.upload();
            });

            //
            resumable.on('fileProgress', function (file) {
                showProgress();
                if(navigator.onLine === true){
                    updateProgress(Math.floor(file.progress() * 100));
                }
            });

            // Function that runs when the file is succesfully uploaded to the server
            resumable.on('fileSuccess', function (file, response) {
                responseJSON = JSON.parse(response);
                let baseUrl = "/";
                let finalUrl = baseUrl.concat(responseJSON.file_link, "/", responseJSON.admin_link);;
                window.location = finalUrl;
            });

            // Simple function that adds css parameters so the progress bar is shown and empty at the beggining of the upload
            function showProgress() {
                progress.find('.progress-bar').css('width', '0%');
                progress.find('.progress-bar').html('0%');
                progress.find('.progress-bar').removeClass('bg-success');
                progress.show();
            }

            // Fill the progress bar based on the current upload progress
            function updateProgress(value) {
                progress.find('.progress-bar').css('width', `${value}%`)
                progress.find('.progress-bar').html(`${value}%`)
            }

            // Define the element as a drop area
            let dropArea = document.getElementById('drop-area')


            ;['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, preventDefaults, false);
            })

            //
            function preventDefaults (e) {
                e.preventDefault();
                e.stopPropagation();
            }

            // Add event listeners for drag enter and dragover
            ;['dragenter', 'dragover'].forEach(eventName => {
                dropArea.addEventListener(eventName, highlight, false);
            })

            // Add event listeners for drag leave and drop
            ;['dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, unhighlight, false);
            })

            // Highlight the drop area
            function highlight(e) {
                dropArea.classList.add('highlight');
            }

            // Remove the highlight of the drop area
            function unhighlight(e) {
                dropArea.classList.remove('highlight');
            }

            dropArea.addEventListener('drop', handleDrop, false);

            // Ïf file is dropped at the drop area
            function handleDrop(e) {
                let dt = e.dataTransfer;
                let files = dt.files;

                handleFile(files);
            }

            // Function that takes care of adding the dropped file into the resumable
            function handleFile(files) {
                if (files.length > 1) {                     // If there are more than one file, we will not allow it
                    alert('Můžete vložit pouze 1 soubor');
                }
                else {                                      // Otherwise we will add it to the resumable. 'fileAdded' callback for resumable will be executed
                    browseFile = files;
                    resumable.addFile(browseFile[0]);
                }
            }

        </script>
    </body>
</html>

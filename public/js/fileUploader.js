let browseFile = $('#add-btn');
let progress = $('.progress');
let lastAddedFile = undefined;

progress.hide();

let resumable = new Resumable({
    target: targetRoute,
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
        if(lastAddedFile !== undefined)
        {
            resumable.files.pop();
        }
        resumable.addFile(browseFile[0]);
        lastAddedFile = browseFile[0];
    }
}

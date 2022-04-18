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
    target: route,
    query:{_token:  token} ,
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

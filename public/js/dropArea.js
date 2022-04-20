// drag and drop inspiration source: 
// Joseph Zimmerman 2018, How To Make A Drag-and-Drop File Uploader With Vanilla JavaScript, 
// Smashing Magazine, accessed 8.4.2022, 
// https://www.smashingmagazine.com/2018/01/drag-drop-file-uploader-vanilla-js/

// Define the element as a drop area
let dropArea = document.getElementById('drop-area')

// Add listeners on drop area events to prevent their default behavior
;['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    dropArea.addEventListener(eventName, preventDefaults, false);
})

// Prevent default behavior and stop propagation
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

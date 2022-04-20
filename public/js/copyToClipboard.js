function CopyToClipboard(id)
{
    // copy to clipboard
    // TODO: vzykouset
    let link = document.getElementById(id).innerText;
    navigator.clipboard.writeText(link);

    // change icon (clipboard to check mark)
    var element = document.getElementById(id + "-icon");
    element.classList.remove("bi-clipboard");
    element.classList.add("bi-check2");
    // check mark to clipboard icon after 1.5s
    setTimeout(function() {
        element.classList.remove("bi-check2");
        element.classList.add("bi-clipboard");
    }, 1500);
}

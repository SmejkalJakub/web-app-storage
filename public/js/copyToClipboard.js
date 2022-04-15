function CopyToClipboard(id)
{
    // copy to clipboard
    // https://www.arclab.com/en/kb/htmlcss/how-to-copy-text-from-html-element-to-clipboard.html
    let r = document.createRange();
    r.selectNode(document.getElementById(id));
    window.getSelection().removeAllRanges();
    window.getSelection().addRange(r);
    document.execCommand('copy');
    window.getSelection().removeAllRanges();

    // change icon
    var element = document.getElementById(id + "-icon");
    element.classList.remove("bi-clipboard");
    element.classList.add("bi-check2");

    setTimeout(function() {
        element.classList.remove("bi-check2");
        element.classList.add("bi-clipboard");
    }, 1500);
}

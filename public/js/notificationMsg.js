/*[Start::MSG-Interface]*/
jQuery('.close').click(function () {
    jQuery('.alert').slideUp();
    jQuery('.msg_div').html("");
});
setTimeout(function () {
    jQuery('.alert').slideUp();
    jQuery('.msg_div').html("");
}, 5000);
/*[End::MSG-Interface]*/

function showSuccessMsg(msg) {
    var mm = '<div class="err-msg2" style="position: absolute;right: : 5px;bottom: 1px;z-index: 1; display:block ">\n\
                            <div class = "alert alert-success">\n\
                            <a href = "#" class = "close" aria-label = "close" style = "text-decoration: none;position: absolute;top: 1px;right: 6px;opacity: 0.4;" > &times; </a>\n\
                           <strong> Success! </strong> ' + msg + '</div></div>';
    jQuery('.msg_div').show();
    jQuery('.msg_div').html(mm);
    hideMessage();
    jQuery('.close').click(function () {
        jQuery('.alert').slideUp();
        jQuery('.msg_div').html("");
    });

}

function showErroMsg(msg) {
    var mm = '<div class="err-msg2" style="position: absolute;right: : 5px;bottom: 1px;z-index: 1; display:block ">\n\
                            <div class = "alert alert-danger">\n\
                            <a href = "#" class = "close" aria-label = "close" style = "text-decoration: none;position: absolute;top: 1px;right: 6px;opacity: 0.4;" > &times; </a>\n\
                           <strong> Error! </strong> ' + msg + '</div></div>';
    jQuery('.msg_div').show();
    jQuery('.msg_div').html(mm);
    hideMessage();
    jQuery('.close').click(function () {
        jQuery('.alert').slideUp();
        jQuery('.msg_div').html("");
    });

}

function hideMessage() {
    setTimeout(function () {
        jQuery('.alert').slideUp();
        jQuery('.msg_div').html("");
    }, 5000);
}
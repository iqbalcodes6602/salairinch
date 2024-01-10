/* Image Preview */

$(document).on('click', '.imagepreview', function() {
    var url = "../../../olivrweb/platform/" + $(this).attr('data-path');
    $("#impreview").remove();
    h = screen.height;
    w = h * 1.777;
    popupWidth = w / 2;
    popupHeight = h / 2;
    type = $(this).attr('data-type');
    switch (type) {
        case "image":
            $("body").append(`<div id="impreview" style="width: ` + popupWidth + `px; height: ` + popupHeight + `px;">
                                     <span class="close">X</span>
                                     <img width="100%" height="100%" src="` + url + `"/>
                                 </div>`);
            break;
        case "pdf":
            $("body").append(`<div id="impreview" style="width: ` + popupWidth + `px; height: ` + popupHeight + `px;">
                         <span class="close">X</span>
                         <iframe src="` + url + `" frameborder="0" allow="autoplay; fullscreen; geolocation; microphone; camera " allowfullscreen></iframe>
                     </div>`);
            break;
        case "video":
            $("body").append(`<div id="impreview" style="width: ` + popupWidth + `px; height: ` + popupHeight + `px;">
                         <span class="close">X</span>
                         <video width="100%" height="100%" src="` + url + `" controls/>
                     </div>`);
            break;
        default:
            $("body").append(`<div id="impreview" style="width: ` + popupWidth + `px; height: ` + popupHeight + `px;">
                         <span class="close">X</span>
                         <img width="100%" height="100%" src="` + url + `"/>
                     </div>`);
            break;
    }

    //<iframe src="`+url+`" frameborder="0" allow="autoplay; fullscreen; geolocation; microphone; camera " allowfullscreen></iframe>
})

$(document).on('click', '#impreview .close', function() {
    $("#impreview").remove();
})
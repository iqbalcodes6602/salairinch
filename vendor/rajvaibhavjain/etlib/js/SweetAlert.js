function sweetalert(title, text, icon, button, locationurl) {
    swal({
        title: title,
        text: text,
        icon: icon,
        button: button,
    }).then((value) => {
        //swal(`The returned value is: ${value}`);
        if (locationurl == "reload") {
            location.reload();
        } else if (locationurl != "") {
            location.href = locationurl;
        }
    });
}
//Admin Login


//appLogin
$(document).on('submit',"#loginform", function (e) {
    e.preventDefault();
    var form = new FormData(this);
    $.ajax({
        url: "Api.php/login",  //login, otplogin
        type: "POST",
        processData: false,
        contentType: false,
        cache: false,
        data: form,
        success: function (data) {
            var obj = JSON.parse(data);
            if (obj.response == true) {
                location.href = "../dashboard/dashboardmanager.php";
            } else {
                sweetalert("Error", obj.message, "error", "OK", "")
            }
        }
    })
})
// $('#loginbtn').on('click', function() {
//     $.ajax({
//         url: "Api.php/login",
//         type: "POST",
//         data: {
//             mobile: $('#mobile').val(),
//             password: $('#password').val()
//         },
//         success: function(data) {
//             obj = JSON.parse(data);
//             if (obj.response == true) {
//                 location.href = "../dashboard/dashboardmanager.php";
//             } else {
//                 sweetalert("Error", obj.message, "error", "OK", "")
//             }
//         }
//     })
// })
//******************************************************************************************Ready List *******************************************************************************/
user_data = "";
$(document).ready(function() {

    getAllLoginUser();
    getAllRegisteredUser();
    getAllActiveUser();
    setInterval(() => {
        getAllLoginUser();
        getAllRegisteredUser();
        getAllActiveUser();
    }, 5000);

    $("#btn_register").click(function() {
        getregisterfromadmin();
    })
})

/***********************************************************************************************Admin ***************************************************************************** */

//User Register
function getregisterfromadmin() {
    var fname = $('#r_name').val();
    var email = $('#r_email').val();
    var mobile = $('#r_mobile').val();
    $.ajax({
        url: "olivrweb/user/ApiAdmin.php/userRegisterFromAdmin",
        type: "POST",
        data: {
            fname: fname,
            email: email,
            mobile: mobile,
        },
        success: function(data) {
            obj = JSON.parse(data);
            if (obj.status === true) {
                $("#alert_div").html(obj.message);
                $("#alert_div").show();
                $('#r_name').val('');
                $('#r_email').val('');
                $('#r_mobile').val('');
                setTimeout(function() {
                    $("#alert_div").hide();
                    getAllRegisteredUser();
                }, 3000);
            } else {
                $("#alert_div").html(obj.message);
                $("#alert_div").show();
                setTimeout(function() {
                    $("#alert_div").hide();
                }, 3000);
            }
        }
    })
}

//Register
$("#admin_email_register").on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: "olivrweb/user/ApiAdmin.php/userRegisterFromAdmin",
        type: "POST",
        processData: false,
        contentType: false,
        cache: false,
        data: new FormData(this),
        success: function(data) {
            obj = JSON.parse(data);
            if (obj.status === true) {
                $("#alert_div").html(obj.message);
                $("#alert_div").show();
                $('#r_name').val('');
                $('#r_email').val('');
                $('#r_mobile').val('');
                setTimeout(function() {
                    $("#alert_div").hide();
                    getAllRegisteredUser();
                }, 3000);
            } else {
                $("#alert_div").html(obj.message);
                $("#alert_div").show();
                setTimeout(function() {
                    $("#alert_div").hide();
                }, 3000);
            }
        }
    })
})


//Get All User detected Registered today
function getAllRegisteredUser() {
    $.ajax({
        url: "olivrweb/user/ApiAdmin.php/getAllRegisteredUser",
        type: "POST",
        data: {},
        success: function(data) {
            obj = JSON.parse(data);
            if (obj.status === true) {
                var allRegisteredUser = obj.data;
                userLoginDiv = "";
                $("#tCount").html("Count: " + obj.data.length);
                $("#register_count").val("Total Register User: " + obj.data.length);
                for (i = 0; i < allRegisteredUser.length; i++) {
                    if (allRegisteredUser[i].status == 1) {
                        userLoginDiv += ("<tr style=\"background-color: white;\"><td>" + allRegisteredUser[i].fname +
                            "</td><td>" + allRegisteredUser[i].lname +
                            "</td><td>" + allRegisteredUser[i].email +
                            "</td><td>" + allRegisteredUser[i].mobile +
                            "</td><td>" + allRegisteredUser[i].registration_time +
                            "</td><td><i onclick='fn_blockUser( " + allRegisteredUser[i].id + " )' class='fas fa-user-lock'></i>" +
                            "</td><td><i onclick='fn_deleteUser( " + allRegisteredUser[i].id + " )' class='fas fa-trash-alt'></i></td></tr>");
                    } else {
                        userLoginDiv += ("<tr style=\"background-color: antiquewhite;\"><td>" + allRegisteredUser[i].fname +
                            "</td><td>" + allRegisteredUser[i].lname +
                            "</td><td>" + allRegisteredUser[i].email +
                            "</td><td>" + allRegisteredUser[i].mobile +
                            "</td><td>" + allRegisteredUser[i].registration_time +
                            "</td><td><i onclick='fn_blockUser( " + allRegisteredUser[i].id + " )' class='fas fa-user-lock'></i>" +
                            "</td><td><i onclick='fn_deleteUser( " + allRegisteredUser[i].id + " )' class='fas fa-trash-alt'></i></td></tr>");
                    }
                }
                $("#total_users").html(' ');
                $("#total_users").html(userLoginDiv);
            } else {
                $("#total_users").html(' ');
                $("#register_count").val("Total Register User: " + obj.message);
            }
        }
    })
}

//Get All User detected login today
function getAllLoginUser() {
    $.ajax({
        url: "olivrweb/user/ApiAdmin.php/getAllLoginUser",
        type: "POST",
        data: {},
        success: function(data) {
            obj = JSON.parse(data);
            if (obj.status === true) {
                allLoginUser = obj.data;
                userLoginDiv = "";
                $("#loginCount").html("Total login: " + obj.data.length);
                $("#login_count").val("Total Login User: " + obj.data.length);
                for (i = 0; i < allLoginUser.length; i++) {
                    userLoginDiv += (`<tr><td>` + allLoginUser[i].fname + `</td>
										<td>` + allLoginUser[i].lname + `</td>
										<td>` + allLoginUser[i].email + `</td>
										<td>` + allLoginUser[i].mobile + `</td>
										<td>` + allLoginUser[i].first_login_time + `</td>
										<td>` + allLoginUser[i].last_login_time + `</td>
                                        <td>` + allLoginUser[i].last_seen_time + `</td></tr>`);
                }
                $("#login_users").html(' ');
                $("#login_users").html(userLoginDiv);
            } else {
                $("#login_users").html(' ');
                $("#login_count").val("Total Login User: " + obj.message);
            }
        }
    })
}

//Get All Login User
function getAllActiveUser() {
    $.ajax({
        url: "olivrweb/user/ApiAdmin.php/getAllActiveUser",
        type: "POST",
        data: {},
        success: function(data) {
            obj = JSON.parse(data);
            if (obj.status === true) {
                userActiveDiv = "";
                if (obj.data.length > 0) {
                    obj.data.forEach(element => {
                        // userActiveDiv += ("<div class='item' id=" + element.userId + "><span>" + element.firstName + "(" + element.email + ")" + "</span></div>");
                        userActiveDiv += `<tr><td>` + element.fname + `</td>
                                                <td>` + element.mobile + `</td>
                                                <td>` + element.email + `</td>
                                                <td>` + element.first_login_time + `</td>
                                                <td>` + element.last_login_time + `</td>
                                                <td>` + element.last_seen_time + `</td></tr>`;
                    });
                    $("#active_user").html(' ');
                    $("#active_user").html(userActiveDiv);
                } else {
                    $("#active_user").html(' ');
                }
                $("#active_count").val("Total Active User: " + obj.data.length);
            } else {
                $("#active_user").html(' ');
                $("#active_count").val("Total Active User: " + obj.message);
            }
        }
    })

}


//Delete Single User
function fn_deleteUser(_xuid) {
    $.confirm({
        title: 'Do You Want to delete!',
        content: 'Please confirm!',
        buttons: {
            confirm: function() {
                $.ajax({
                    url: "olivrweb/user/ApiAdmin.php/deleteSingleUser",
                    type: "POST",
                    data: {
                        uid: _xuid,
                    },
                    success: function(data) {
                        obj = JSON.parse(data);
                        if (obj.status === true) {
                            $("#alert_div").html(obj.message);
                            $("#alert_div").show();
                            getAllRegisteredUser();
                            setTimeout(function() {
                                $("#alert_div").hide();
                            }, 3000);
                        } else {
                            $("#alert_div").html(obj.message);
                            $("#alert_div").show();
                            getAllRegisteredUser();
                            setTimeout(function() {
                                $("#alert_div").hide();
                            }, 3000);
                        }
                    }
                })
            },
            cancel: function() {
                $.alert('Canceled!');
            },
        }
    });

    
}

//Delete All User
function fn_deleteAllUsers() {
    $.confirm({
        title: 'Do You Want to delete!',
        content: 'Please confirm!',
        buttons: {
            confirm: function() {
                $.ajax({
                    url: "olivrweb/user/ApiAdmin.php/deleteAllUser",
                    type: "POST",
                    data: {},
                    success: function(data) {
                        obj = JSON.parse(data);
                        if (obj.status === true) {
                            $("#alert_div").html(obj.message);
                            $("#alert_div").show();
                            setTimeout(function() {
                                $("#alert_div").hide();
                                getAllRegisteredUser();
                                getAllLoginUser();
                            }, 3000);
                        } else {
                            $("#alert_div").html(obj.message);
                            $("#alert_div").show();
                            setTimeout(function() {
                                $("#alert_div").hide();
                            }, 3000);
                        }
                    }
                })
            },
            cancel: function() {
                $.alert('Canceled!');
            },
        }
    });

    
}

//Block User
function fn_blockUser(_xuid) {
    $.ajax({
        url: "olivrweb/user/ApiAdmin.php/blockUser",
        type: "POST",
        data: {
            uid: _xuid,
        },
        success: function(data) {
            obj = JSON.parse(data);
            if (obj.status === true) {
                $("#alert_div").html(obj.message);
                $("#alert_div").show();
                getAllRegisteredUser();
                setTimeout(function() {
                    $("#alert_div").hide();
                }, 3000);
            } else {
                $("#alert_div").html(obj.message);
                $("#alert_div").show();
                getAllRegisteredUser();
                setTimeout(function() {
                    $("#alert_div").hide();
                }, 3000);
            }
        }
    })
}



//Logout All User
function fn_logoutAllUser() {
    $.ajax({
        url: "olivrweb/user/ApiAdmin.php/logoutAllUser",
        type: "POST",
        data: {},
        success: function(data) {
            obj = JSON.parse(data);
            if (obj.status === true) {
                $("#alert_div").html(obj.message);
                $("#alert_div").show();
                getAllLoginUser();
                setTimeout(function() {
                    $("#alert_div").hide();
                }, 3000);
            } else {
                $("#alert_div").html(obj.message);
                $("#alert_div").show();
                getAllLoginUser();
                setTimeout(function() {
                    $("#alert_div").hide();
                }, 3000);
            }
        }
    })
}

//Logout
function logout() {
    localStorage.clear();
}



/**********************************************************************************************Download List *************************************************************************/

//Get All User Registered
function DownloadRegisteredUser() {
    window.location.href = "olivrweb/analytics/DownloadApi.php/singledownload?id=1";
}

//Get All Login User today
function DownloadLoginUser() {
    window.location.href = "olivrweb/analytics/DownloadApi.php/singledownload?id=2";
}

//Get All Active User
function DownloadActiveUser() {
    window.location.href = "olivrweb/analytics/DownloadApi.php/singledownload?id=3";
}
/***********************************************************************************************Site List ****************************************************************************/
$(document).ready(function () {

    //Login Validation
    if (window.location.pathname.split("/").pop() != "login") {
        // MyProfile();
        // Update_My_Current_Login_Status();
        // setInterval(function () {
        //     MyProfile();
        //     Update_My_Current_Login_Status();
        // }, 10000);
    }
    
    // if (window.location.pathname.split("/").pop() == "lobby.html") {
    //     getJoinedUserProfile();
    //     setInterval(function () {
    //         getJoinedUserProfile();
    //     }, 5000);
    // }


    var email = new URL(location.href).searchParams.get("email");
    if (email != null && email != "") {
        $.ajax({
            url: "olivrweb/user/Api.php/login",
            type: "POST",
            data: {
                email: email
            },
            success: function(data) {
                var obj = JSON.parse(data);
                user_data = obj.data;
                if (obj.status === true) {
                    //Direct Login
                    localStorage.setItem("token", obj.token); //Local Storage
                    localStorage.setItem("userid", obj.userid); //Local Storage
                    localStorage.setItem("ismember", "false");
                    localStorage.setItem("memberid", "");

                    play_lobby_video("lobby.html","video/logintolobby.mp4");
                } else {
                    sweetalert("Error", obj.message, "error", "OK", "")
                }
            }
        })
    }



    //Login
    $("#login").on('submit', function (e) {
        $("#loader").show();
        e.preventDefault();
        var form=new FormData(this);
        if(form.get('password')!=""){
            form.set('password',btoa(form.get('password')))
        }
        form.set('slug',new URL(location.href).searchParams.get("s"))

        $.ajax({
            url: "olivrweb/user/Api.php/login",
            type: "POST",
            processData: false,
            contentType: false,
            cache: false,
            data: form,
            success: function (data) {
                $("#loader").hide();
                var obj = JSON.parse(data);
                if (obj.status == true) {

                    //Direct Login
                    localStorage.setItem("token", obj.token); //Local Storage
                    localStorage.setItem("userid", obj.userid); //Local Storage
                    // window.location.href = "lobby.html";
            
                    // MyProfile();
                    //Before Live
                    //sweetalert("Success", obj.message, "success", "OK", "")
                } else {
                    sweetalert("Error", obj.message, "error", "OK", "")
                }
            }
        })
    })

    //Register
    $("#register").on('submit', function (e) {
        e.preventDefault();
        var form=new FormData(this);
        form.set('slug',new URL(location.href).searchParams.get("s"))
        if(form.get('password')!=""){
            form.set('password',btoa(form.get('password')))
        }
        
        
        $.ajax({
            url: "olivrweb/user/Api.php/register",
            type: "POST",
            processData: false,
            contentType: false,
            cache: false,
            data: form,
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.status == true) {
                    localStorage.setItem("token", obj.user.token); //Local Storage
                    localStorage.setItem("userid", obj.user.userid); //Local Storage
                    sweetalert("Success", obj.message, "success", "OK", "reload")
                } else {
                    sweetalert("Error", obj.message, "error", "OK", "")
                }
            }
        })
    })

    //OTP Login
    $("#otplogin").on('submit', function (e) {
        $("#loader").show();
        e.preventDefault();

        var form=new FormData(this);
        form.set('slug',new URL(location.href).searchParams.get("s"))
        if(form.get('password')!=""){
            form.set('password',btoa(form.get('password')))
        }

        $.ajax({
            url: "olivrweb/user/Api.php/otplogin",
            type: "POST",
            processData: false,
            contentType: false,
            cache: false,
            data: form,
            success: function (data) {
                $("#loader").hide();
                var obj = JSON.parse(data);
                if (obj.status == true) {
                    //OTP Login
                    $("#otplogin").addClass('d-none');
                    $("#verifyotp").removeClass('d-none');
                    $('#verifyotp input[name="fname"]').val($('#otplogin input[name="fname"]').val());
                    $('#verifyotp input[name="email"]').val($('#otplogin input[name="email"]').val());

                    //Before Live
                    //sweetalert("Success", obj.message, "success", "OK", "")
                } else {
                    sweetalert("Error", obj.message, "error", "OK", "")
                }
            }
        })
    })

    //Verifyotp
    $("#verifyotp").on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: "olivrweb/user/Api.php/verifyotp",
            type: "POST",
            processData: false,
            contentType: false,
            cache: false,
            data: new FormData(this),
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.status == true) {
                    localStorage.setItem("token", obj.token); //Local Storage
                    localStorage.setItem("userid", obj.userid); //Local Storage
                    window.location.href = "lobby.html";
                    
                    //Lobby Video Show
                    /* $('.lobby-video').show();
                    $('.lobby-video video').trigger('play');
                    $('.lobby-video video').bind('ended', function () {
                        window.location.href = "lobby.html";
                    });*/

                    //Before Live
                    //sweetalert("Success", obj.message, "success", "OK", "")
                } else {
                    sweetalert("Error", obj.message, "error", "OK", "")
                }
            }
        })
    })

});

//Update My Current Login Status
function Update_My_Current_Login_Status() {
    $.ajax({
        url: "olivrweb/user/Api.php/updateloginstatus",
        type: "POST",
        data: {
            token: localStorage.getItem("token"), //Local Storage
        },
        success: function (data) {
            obj = JSON.parse(data);
            user_data = obj.data;
            if (obj.status === true) {

            } else {
                $("#alert_div").html(obj.message);
                $("#alert_div").show();

                setTimeout(function () {
                    logoutSession();
                }, 5000);
            }
        }
    })
}


function MyProfile() {
    var token = localStorage.getItem("token");
    if (token == "" || token == null) {
        logoutSession();
    } else {
        $.ajax({
            url: "olivrweb/user/Api.php/getuser",
            type: "POST",
            data: {
                token: token,
            },
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.status === true) {

                    var html=`<tr>
                                <th scope="row">1</th>
                                <td class="partner_fname">${obj.user.fname}</td>
                                <td class="theme-text">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    Partner</td>
                                <td class="text-right">
                                    <button type="button" class="btn btn-success pl-4 pr-4 rounded-0" onclick="play_lobby_video()">Login</button>
                                </td>
                            </tr>`;
                    if(obj.member.length>0){
                        var count=2;
                        obj.member.forEach(element => {
                            html +=   `<tr>
                                        <th scope="row">${count}</th>
                                        <td>${element.fname}</td>
                                        <td>${element.type}</td>
                                        <td class="text-right">
                                            <form class="member_login" action="#" method="post">
                                                <input type="hidden" name="memberid" value="${element.memberid}">
                                                <button type="submit" class="btn btn-success pl-4 pr-4 rounded-0">Login</button>
                                            </form>
                                            
                                        </td>
                                    </tr>`;
                            count++;
                        });
                        
                    }
                    $('.partner_member').html(html);
                    $('.totalpoints').html(obj.user.points);
                    // $(".partner_fname").html(obj.user.fname);
                } else {
                    logoutSession();
                }
            }
        })
    }
}


/* Joined Users Profile */
function getJoinedUserProfile() {
    $.ajax({
        url: "olivrweb/user/Api.php/getjoineduserprofile",
        type: "POST",
        data: {
            token: localStorage.getItem("token")
        },
        success: function (data) {
            var obj = JSON.parse(data);
            var html = ``;
            if (obj.status === true) {
                if (obj.data.length > 0) {
                    obj.data.forEach(element => {
                        html += element.image != "" ? `<li><img src="./olivrweb/user/${element.image}" class="img-fluid"></li>` : '';
                    });
                }
            }
            $(".joineduserprofiletotal").html(obj.total);
            $(".joineduserprofile").html(html);
        }
    })

}



/***********************************************************  UI Changes *******************************************/
function logoutSession() {
    localStorage.clear();
    window.location.href = "login.html";
}


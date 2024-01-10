/******************************************************* Function Scripts ****************************************** */
$(document).ready(function() {
    analatics();
    setInterval(() => {
        analatics();
    }, 5000);
})

function analatics() {
    $.ajax({
        url: "Api.php/getanalatics",
        method: "POST",
        data: {},
        success: function(data) {
            var obj = JSON.parse(data);
            if (obj.response == true) {

                $(".totaluser").html(obj.totaluser);
                $(".newuser").html(obj.newuser);
                $(".totalordertoday").html(obj.totalordertoday);
                $(".totalwintoday").html(obj.totalwintoday);


                $(".totalfriendrequest").html(obj.totalfriendrequest);
                $(".todayfriendrequest").html(obj.todayfriendrequest);
                $(".connections").html(obj.connections);
                $(".todayconnections").html(obj.todayconnections);
                $(".totalfeedback").html(obj.totalfeedback);
                $(".todayfeedback").html(obj.todayfeedback);
                $(".totalqna").html(obj.totalqna);
                $(".todayqna").html(obj.todayqna);

                $(".totalpersonalmeet").html(obj.totalpersonalmeet);
                $(".todaypersonalmeet").html(obj.todaypersonalmeet);
                $(".totalcoffeemeet").html(obj.totalcoffeemeet);
                $(".todaycoffeemeet").html(obj.todaycoffeemeet);
                $(".activepersonalmeet").html(obj.activepersonalmeet);
                $(".activecoffeemeet").html(obj.activecoffeemeet);

                $(".totaldownload").html(obj.totaldownload);
                $(".todaydownload").html(obj.todaydownload);
                $(".uniquedownload").html(obj.uniquedownload);
                $(".todayuniquedownload").html(obj.todayuniquedownload);
                $(".totalview").html(obj.totalview);
                $(".todayview").html(obj.todayview);
                $(".uniqueview").html(obj.uniqueview);
                $(".todayuniqueview").html(obj.todayuniqueview);
            } else {
                $('#grid').html("No Record Found.");
            }
        }
    })
}
/******************************************************* Function Scripts ****************************************** */
var filter = false;
var parms = {
    "response": "true",
    "title": {
        'userloginid': '#ID',
        'mobile': 'mobile',
        'time': 'Time',
    },
    "rows": [],
    "pagination": { //For Pagination
        "ispagination": true,
        "totalrows": 99,
        "currentpage": 1,
        "showdatalimit": 10,
        "isselect": true,
        "selectoption": [10, 20, 50, 100]
    },
    "option": {
        "isoption": true,
        "optiontitle": "Option",
        "optionfields": ['#', '#'], //href, newtab, #
        "optionToolTip": ['Edit', 'Delete'],
        "optionKey": ['userloginid', 'userloginid'],
        "optionLink": ['', ''], //userloginedit.php?userloginid=
        "isFaFa": true, //true, false
        "optionFaFa": ['fas fa-edit', 'fas fa-trash'], //fas fa-trash, fas fa-key, fa fa-paper-plane
        "optionAdditionalClass": ['btn-primary userloginedit', 'btn-danger userlogindelete'], //AdditionalClass Two or more (d-none)
    }
    //btn-primary btn-secondary btn-success btn-danger btn-warning btn-info btn-light btn-dark btn-link
}


/***************************************************************** Filter Section *********************************************/

var mobile = '';
var domain = '';
var type = '';

function filter_val() {
    mobile = $("#filter_mobile").val();
}

$(document).on('click', '.apply_filter', function () {
    filter_val();
    DocumentGrid();
})
$(document).on('click', '.clear_filter', function () {
    $('#filter')[0].reset();
    filter_val();
    DocumentGrid();
})

/***************************************************************** Filter Section END *********************************************/



function DocumentGrid() {
    $.ajax({
        url: "Api.php/getuserlogins",
        method: "POST",
        data: {
            currentpage: parms['pagination']['currentpage'],
            showdatalimit: parms['pagination']['showdatalimit'],
            mobile: mobile,
            domain: domain,
            type: type,
        },
        success: function (data) {
            var obj = JSON.parse(data);
            if (obj.response == true) {
                parms['rows'] = obj.userlogin;
                parms['pagination']['totalrows'] = obj.totalrows;
                console.log(parms);
                htmlGrid = Grid(parms);
                $('#grid').html(htmlGrid);

            } else {
                sweetalert("Error", obj.message, "error", "OK", "")
            }
        }
    })
}
$(document).on('click', '.pagenumber', function () {
    parms['pagination']['currentpage'] = $(this).data('pagenumber');
    DocumentGrid();
})
$(document).on('change', '.selectnumber', function () {
    parms['pagination']['showdatalimit'] = $(this).val();
    DocumentGrid();
})



/***********************************      Document Ready Scripts  ******************************************* */
$(document).ready(function () {
    DocumentGrid();
    /* Add Test */
    $("#adduserlogin").on("submit", function (e) {
        var t = $(".upload_btn");
        t.attr('disabled', true);
        e.preventDefault();

        var formdata = new FormData(this);
        var ajax = new XMLHttpRequest();
        ajax.upload.addEventListener("progress", function (event) {
            var percent = (event.loaded / event.total) * 100;
            var processPercent = Math.round(percent);
            $("#progressBar").val(processPercent);
        }, false);
        ajax.addEventListener("load", function (event) {
            t.attr('disabled', false);
            data = event.target.responseText;
            obj = JSON.parse(data);
            if (obj.response == true) {
                $("#progressBar").val(0);
                DocumentGrid();
                sweetalert("Uploded", obj.message, "success", "OK", "");
            } else {
                sweetalert("Error", obj.message, "error", "OK", "")
            }
        }, false);
        ajax.open("POST", "Api.php/setuserlogin");
        ajax.send(formdata);
    })

    /* Edit Document */
    $(document).on('click', '.userloginedit', function () {
        var userloginid = $(this).data('key');
        $("#editModal").modal('show');
        $.ajax({
            url: "Api.php/getuserlogin",
            method: "POST",
            data: {
                key: userloginid,
            },
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.response == true) {
                    $("#userloginupdate input[name=\"userloginid\"]").val(obj.userlogin.userloginid);
                    $("#userloginupdate input[name=\"mobile\"]").val(obj.userlogin.mobile);
                    $("#userloginupdate input[name=\"otp\"]").val(obj.userlogin.otp);
                    $("#userloginupdate select[name=\"otp_expiry\"]").val(obj.userlogin.otp_expiry).change().select2();
                    // $("#userloginmobile").html(obj.userlogin.mobile);
                    DocumentGrid();
                }
                $('#paginatialerton_data').html(data);
            }
        })
    })

    /* Update Test */
    $("#userloginupdate").on("submit", function (e) {
        var t = $(".update_btn");
        t.attr('disabled', true);
        e.preventDefault();

        var formdata = new FormData(this);
        var ajax = new XMLHttpRequest();
        ajax.upload.addEventListener("progress", function (event) {
            var percent = (event.loaded / event.total) * 100;
            var processPercent = Math.round(percent);
            $("#progressBarDocumentUpdate").val(processPercent);
        }, false);
        ajax.addEventListener("load", function (event) {
            t.attr('disabled', false);
            data = event.target.responseText;
            obj = JSON.parse(data);
            if (obj.response == true) {
                $("#progressBarDocumentUpdate").val(0);
                DocumentGrid();
                sweetalert("Uploded", obj.message, "success", "OK", "");
                GetDocument(id);
            } else {
                sweetalert("Error", obj.message, "error", "OK", "")
            }
        }, false);
        ajax.open("POST", "Api.php/setuserloginupdate");
        ajax.send(formdata);
    })


    /* Delete Test */
    $(document).on('click', '.userlogindelete', function () {
        var userloginid = $(this).data('key');
        $.confirm({
            title: 'Do You Want to delete!',
            content: 'Please confirm!',
            buttons: {
                confirm: function () {
                    $.ajax({
                        url: "Api.php/deleteuserlogin",
                        type: "POST",
                        data: {
                            key: userloginid
                        },
                        success: function (data) {
                            obj = JSON.parse(data);
                            if (obj.response == true) {
                                sweetalert("Delete", obj.message, "success", "OK", "");
                                DocumentGrid();
                            } else {
                                sweetalert("Error", obj.message, "error", "OK", "");
                            }
                        }
                    })
                },
                cancel: function () {
                    $.alert('Canceled!');
                },
            }
        });
    })
});
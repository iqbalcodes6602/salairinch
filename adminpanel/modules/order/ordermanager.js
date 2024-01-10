/******************************************************* Function Scripts ****************************************** */
var filter = false;
var parms = {
    "response": "true",
    "title": {
        'orderid': '#ID',
        'subcategory': 'Subcategory',
        'name': 'Name',
        'email' : 'Email',
        'mobile': 'Mobile',
        'address': 'Address',
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
        "optiontitle": "Options",
        "optionfields": ['#', '#'], //href, newtab, #
        "optionToolTip": ['Edit', 'Delete'],
        "optionKey": ['orderid', 'orderid'],
        "optionLink": ['', ''], //orderedit.php?orderid=
        "isFaFa": true, //true, false
        "optionFaFa": ['fas fa-edit', 'fas fa-trash'], //fas fa-trash, fas fa-key, fa fa-paper-plane
        "optionAdditionalClass": ['btn-primary orderedit', 'btn-danger orderdelete'], //AdditionalClass Two or more (d-none)
    }
    //btn-primary btn-secondary btn-success btn-danger btn-warning btn-info btn-light btn-dark btn-link
}


/***************************************************************** Filter Section *********************************************/

var name = '';
var domain = '';
var email='';
var mobile = '';
var type = '';

function filter_val() {
    name = $("#filter_name").val();
    email = $("#filter_email").val();
    mobile = $("#filter_mobile").val();
    status = $("#filter_status").val();
}

$(document).on('click', '.apply_filter', function() {
    filter_val();
    DocumentGrid();
})
$(document).on('click', '.clear_filter', function() {
    $('#filter')[0].reset();
    filter_val();
    DocumentGrid();
})

/***************************************************************** Filter Section END *********************************************/



function DocumentGrid() {
    $.ajax({
        url: "Api.php/getorders",
        method: "POST",
        data: {
            currentpage: parms['pagination']['currentpage'],
            showdatalimit: parms['pagination']['showdatalimit'],
            name: name,
            domain: domain,
            email: email,
            mobile: mobile,
            type: type,
        },
        success: function(data) {
            var obj = JSON.parse(data);
            if (obj.response == true) {
                parms['rows'] = obj.order;
                parms['pagination']['totalrows'] = obj.totalrows;
                console.log(parms);
                htmlGrid = Grid(parms);
                $('#grid').html(htmlGrid);
                $('#gridselect').select2();
            } else {
                sweetalert("Error", obj.message, "error", "OK", "")
            }
        }
    })
}
$(document).on('click', '.pagenumber', function() {
    parms['pagination']['currentpage'] = $(this).data('pagenumber');
    DocumentGrid();
})
$(document).on('change', '.selectnumber', function() {
    parms['pagination']['showdatalimit'] = $(this).val();
    DocumentGrid();
})



/***********************************      Document Ready Scripts  ******************************************* */
$(document).ready(function() {
    DocumentGrid();
    /* Add Order */
    $("#addorder").on("submit", function(e) {
        var t = $(".upload_btn");
        t.attr('disabled', true);
        e.preventDefault();

        var formdata = new FormData(this);
        var ajax = new XMLHttpRequest();
        ajax.upload.addEventListener("progress", function(event) {
            var percent = (event.loaded / event.total) * 100;
            var processPercent = Math.round(percent);
            $("#progressBar").val(processPercent);
        }, false);
        ajax.addEventListener("load", function(event) {
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
        ajax.open("POST", "Api.php/setorder");
        ajax.send(formdata);
    })

    /* Edit Document */
    $(document).on('click', '.orderedit', function() {
        var orderid = $(this).data('key');
        $("#editModal").modal('show');
        $.ajax({
            url: "Api.php/getorder",
            method: "POST",
            data: {
                key: orderid,
            },
            success: function(data) {
                var obj = JSON.parse(data);
                if (obj.response == true) {
                    $("#orderupdate input[name=\"orderid\"]").val(obj.order.orderid);
                    $("#orderupdate input[name=\"subcategory\"]").val(obj.order.subcategory);
                    $("#orderupdate input[name=\"name\"]").val(obj.order.name);
                    $("#orderupdate input[name=\"address\"]").val(obj.order.address);
                    $("#orderupdate input[name=\"mobile\"]").val(obj.order.mobile);
                    $("#orderupdate input[name=\"email\"]").val(obj.order.email);
                    $("#orderupdate select[name=\"status\"]").val(obj.order.status).change().select2();
                    // $("#ordername").html(obj.order.name);
                    DocumentGrid();
                }
                $('#paginatialerton_data').html(data);
            }
        })
    })

    /* Update Order */
    $("#orderupdate").on("submit", function(e) {
        var t = $(".update_btn");
        t.attr('disabled', true);
        e.preventDefault();

        var formdata = new FormData(this);
        var ajax = new XMLHttpRequest();
        ajax.upload.addEventListener("progress", function(event) {
            var percent = (event.loaded / event.total) * 100;
            var processPercent = Math.round(percent);
            $("#progressBarDocumentUpdate").val(processPercent);
        }, false);
        ajax.addEventListener("load", function(event) {
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
        ajax.open("POST", "Api.php/setorderupdate");
        ajax.send(formdata);
    })


    /* Delete Order */
    $(document).on('click', '.orderdelete', function() {
        var orderid = $(this).data('key');
        $.confirm({
            title: 'Do You Want to delete!',
            content: 'Please confirm!',
            buttons: {
                confirm: function() {
                    $.ajax({
                        url: "Api.php/deleteorder",
                        type: "POST",
                        data: {
                            key: orderid
                        },
                        success: function(data) {
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
                cancel: function() {
                    $.alert('Canceled!');
                },
            }
        });
    })
});
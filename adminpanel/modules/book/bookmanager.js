/******************************************************* Function Scripts ****************************************** */
var filter = false;
var parms = {
    "response": "true",
    "title": {
        'bookid': '#ID',
        'name': 'Name',
        'email' : 'Email',
        'mobile': 'Mobile',
        'subject': 'Subject',
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
        "optionKey": ['bookid', 'bookid'],
        "optionLink": ['', ''], //bookedit.php?bookid=
        "isFaFa": true, //true, false
        "optionFaFa": ['fas fa-edit', 'fas fa-trash'], //fas fa-trash, fas fa-key, fa fa-paper-plane
        "optionAdditionalClass": ['btn-primary bookedit', 'btn-danger bookdelete'], //AdditionalClass Two or more (d-none)
    }
    //btn-primary btn-secondary btn-success btn-danger btn-warning btn-info btn-light btn-dark btn-link
}


/***************************************************************** Filter Section *********************************************/

var name = '';
var domain = '';
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
        url: "Api.php/getbooks",
        method: "POST",
        data: {
            currentpage: parms['pagination']['currentpage'],
            showdatalimit: parms['pagination']['showdatalimit'],
            name: name,
            domain: domain,
            mobile: mobile,
            type: type,
        },
        success: function(data) {
            var obj = JSON.parse(data);
            if (obj.response == true) {
                parms['rows'] = obj.book;
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
    /* Add book */
    $("#addbook").on("submit", function(e) {
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
        ajax.open("POST", "Api.php/setbook");
        ajax.send(formdata);
    })

    /* Edit Document */
    $(document).on('click', '.bookedit', function() {
        var bookid = $(this).data('key');
        $("#editModal").modal('show');
        $.ajax({
            url: "Api.php/getbook",
            method: "POST",
            data: {
                key: bookid,
            },
            success: function(data) {
                var obj = JSON.parse(data);
                if (obj.response == true) {
                    $("#bookupdate input[name=\"bookid\"]").val(obj.book.bookid);
                    $("#bookupdate input[name=\"name\"]").val(obj.book.name);
                    $("#bookupdate input[name=\"mobile\"]").val(obj.book.mobile);
                    $("#bookupdate input[name=\"subject\"]").val(obj.book.subject);
                    $("#bookupdate input[name=\"email\"]").val(obj.book.email);
                    $("#bookupdate select[name=\"status\"]").val(obj.book.status).change().select2();
                    // $("#bookname").html(obj.book.name);
                    DocumentGrid();
                }
                $('#paginatialerton_data').html(data);
            }
        })
    })

    /* Update book */
    $("#bookupdate").on("submit", function(e) {
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
        ajax.open("POST", "Api.php/setbookupdate");
        ajax.send(formdata);
    })


    /* Delete book */
    $(document).on('click', '.bookdelete', function() {
        var bookid = $(this).data('key');
        $.confirm({
            title: 'Do You Want to delete!',
            content: 'Please confirm!',
            buttons: {
                confirm: function() {
                    $.ajax({
                        url: "Api.php/deletebook",
                        type: "POST",
                        data: {
                            key: bookid
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
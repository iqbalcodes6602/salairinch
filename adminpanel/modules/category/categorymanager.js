/******************************************************* Function Scripts ****************************************** */
var filter = false;
var parms = {
    "response": "true",
    "title": {
        'categoryid': '#ID',
        'title': 'Title',
        'description': 'Description',
        'status': 'Status',
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
        "optionfields": ['#', '#', "#"], //href, newtab, #
        "optionToolTip": ['Edit', 'Delete', "See Image"],
        "optionKey": ['categoryid', 'categoryid', 'image'],
        "optionLink": ['', '', ''], //categoryedit.php?categoryid=
        "isFaFa": true, //true, false
        "optionFaFa": ['fas fa-edit', 'fas fa-trash', 'fas fa-eye'], //fas fa-trash, fas fa-key, fa fa-paper-plane
        "optionAdditionalClass": ['btn-primary categoryedit', 'btn-danger categorydelete', 'btn-info categoryview'], //AdditionalClass Two or more (d-none)
    }
    //btn-primary btn-secondary btn-success btn-danger btn-warning btn-info btn-light btn-dark btn-link
}


/***************************************************************** Filter Section *********************************************/

var title = '';
var description = '';
var image = '';
var type = '';

function filter_val() {
    title = $("#filter_title").val();
    description = $("#filter_description").val();
    image = $("#filter_image").val();
    status = $("#filter_status").val();
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
        url: "Api.php/getcategorys",
        method: "POST",
        data: {
            currentpage: parms['pagination']['currentpage'],
            showdatalimit: parms['pagination']['showdatalimit'],
            title: title,
            description: description,
            image: image,
            type: type,
        },
        success: function (data) {
            var obj = JSON.parse(data);
            if (obj.response == true) {
                parms['rows'] = obj.category;
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
    /* Add category */
    $("#addcategory").on("submit", function (e) {
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
        ajax.open("POST", "Api.php/setcategory");
        ajax.send(formdata);
    })

    /* Edit Document */
    $(document).on('click', '.categoryedit', function () {
        var categoryid = $(this).data('key');
        $("#editModal").modal('show');
        $.ajax({
            url: "Api.php/getcategory",
            method: "POST",
            data: {
                key: categoryid,
            },
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.response == true) {
                    $("#categoryupdate input[name=\"categoryid\"]").val(obj.category.categoryid);
                    $("#categoryupdate input[name=\"title\"]").val(obj.category.title);
                    $("#categoryupdate input[name=\"description\"]").val(obj.category.description);
                    $("#categoryupdate input[name=\"image\"]").val(obj.category.image);
                    $("#categoryupdate select[name=\"status\"]").val(obj.category.status).change().select2();
                    DocumentGrid();
                }
                $('#paginatialerton_data').html(data);
            }
        })
    })

    /* Update category */
    $("#categoryupdate").on("submit", function (e) {
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
        ajax.open("POST", "Api.php/setcategoryupdate");
        ajax.send(formdata);
    })


    /* Delete category */
    $(document).on('click', '.categorydelete', function () {
        var categoryid = $(this).data('key');
        $.confirm({
            title: 'Do You Want to delete!',
            content: 'Please confirm!',
            buttons: {
                confirm: function () {
                    $.ajax({
                        url: "Api.php/deletecategory",
                        type: "POST",
                        data: {
                            key: categoryid
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

    
    /* View category */
    $(document).on('click', '.categoryview', function () {
        var image = $(this).data('key');
        $.confirm({
            title: 'View Image',
            content: '<img src="../../../assets/img/' + image + '" />',
            buttons: {
                close: function () {
                    return;
                },
            }
        });
    })
});
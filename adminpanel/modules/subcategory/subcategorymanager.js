/******************************************************* Function Scripts ****************************************** */
var filter = false;
var parms = {
    "response": "true",
    "title": {
        'subcategoryid': '#ID',
        'categroytitle': 'Category',
        'title': 'Title',
        'description': 'Description',
        'status': 'status',
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
        "optionfields": ['#', '#', '#'], //href, newtab, #
        "optionToolTip": ['Edit', 'Delete', 'View Image'],
        "optionKey": ['subcategoryid', 'subcategoryid', 'image'],
        "optionLink": ['', ''], //subcategoryedit.php?subcategoryid=
        "isFaFa": true, //true, false
        "optionFaFa": ['fas fa-edit', 'fas fa-trash', 'fas fa-eye'], //fas fa-trash, fas fa-key, fa fa-paper-plane
        "optionAdditionalClass": ['btn-primary subcategoryedit', 'btn-danger subcategorydelete', 'btn-info subcategoryview'], //AdditionalClass Two or more (d-none)
    }
    //btn-primary btn-secondary btn-success btn-danger btn-warning btn-info btn-light btn-dark btn-link
}


/***************************************************************** Filter Section *********************************************/

var categoryid = '';
var title = '';
var description = '';
var image = '';
var type = '';

function filter_val() {
    categoryid = $("#filter_categoryid").val();
    title = $("#filter_title").val();
    categoryid = $("#filter_categoryid").val();
    description = $("#filter_description").val();
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
        url: "Api.php/getsubcategorys",
        method: "POST",
        data: {
            currentpage: parms['pagination']['currentpage'],
            showdatalimit: parms['pagination']['showdatalimit'],
            categoryid: categoryid,
            title: title,
            categoryid: categoryid,
            description: description,
            image: image,
            type: type,
        },
        success: function (data) {
            var obj = JSON.parse(data);
            if (obj.response == true) {
                parms['rows'] = obj.subcategory;
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
    /* Add subcategory */
    $("#addsubcategory").on("submit", function (e) {
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
        ajax.open("POST", "Api.php/setsubcategory");
        ajax.send(formdata);
    })

    /* Edit Document */
    $(document).on('click', '.subcategoryedit', function () {
        var subcategoryid = $(this).data('key');
        $("#editModal").modal('show');
        $.ajax({
            url: "Api.php/getsubcategory",
            method: "POST",
            data: {
                key: subcategoryid,
            },
            success: function (data) {
                var obj = JSON.parse(data);
                if (obj.response == true) {
                    $("#subcategoryupdate input[name=\"subcategoryid\"]").val(obj.subcategory.subcategoryid);
                    $("#subcategoryupdate input[name=\"categoryid\"]").val(obj.subcategory.categoryid);
                    $("#subcategoryupdate input[name=\"title\"]").val(obj.subcategory.title);
                    $("#subcategoryupdate input[name=\"description\"]").val(obj.subcategory.description);
                    $("#subcategoryupdate input[name=\"image\"]").val(obj.subcategory.image);
                    $("#subcategoryupdate select[name=\"status\"]").val(obj.subcategory.status).change().select2();
                    DocumentGrid();
                }
                $('#paginatialerton_data').html(data);
            }
        })
    })

    /* Update subcategory */
    $("#subcategoryupdate").on("submit", function (e) {
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
        ajax.open("POST", "Api.php/setsubcategoryupdate");
        ajax.send(formdata);
    })


    /* Delete subcategory */
    $(document).on('click', '.subcategorydelete', function () {
        var subcategoryid = $(this).data('key');
        $.confirm({
            title: 'Do You Want to delete!',
            content: 'Please confirm!',
            buttons: {
                confirm: function () {
                    $.ajax({
                        url: "Api.php/deletesubcategory",
                        type: "POST",
                        data: {
                            key: subcategoryid
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

    /* View Sub category */
    $(document).on('click', '.subcategoryview', function () {
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
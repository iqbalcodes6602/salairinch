<?php
session_start();
include('../../../ETWeb/includes/config.php');
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="../../assets/images/favicon.png">
    <title>Admin | userlogin</title>
    <link rel="stylesheet" type="text/css" href="../../assets/extra-libs/multicheck/multicheck.css">
    <link href="../../assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../../assets/libs/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link href="../../dist/css/style.min.css" rel="stylesheet">

    <!-- JQUERY DATE Picker-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <!-- JQUERY DATE Picker End-->
    <style>
        .select-2-height .select2-selection {
            height: 100px !important;
        }

        .select-2-height .select2-container {
            height: 100px;
        }

        .select2-selection {
            overflow-y: scroll !important;
        }

        .select2-selection--multiple {
            height: 100px !important;
        }
    </style>
</head>

<body>
    <div id="main-wrapper">
        <?php include '../../header.php'; ?>
        <div class="page-wrapper">
            <div class="container-fluid">
                <!-- Filter Section --->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <form id="filter">
                                    <div class="form-row">
                                        <div class="form-group col-md-10">
                                            <h4 class="page-title">Registered userlogin</h4>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <button type="button" class="btn btn-primary w-100 d-none" data-toggle="modal" data-target="#exampleModal">Add userlogin</button>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputEmail4">mobile</label>
                                            <input type="text" class="form-control" id="filter_mobile" placeholder="mobile">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12 text-center">
                                            <button type="button" class="btn btn-primary apply_filter"><i class="mdi mdi-check"></i> Apply Filter</button>
                                            <button type="button" class="btn btn-dark clear_filter"><i class="mdi mdi-window-close"></i> Clear Filter</button>
                                        </div>
                                    </div>
                                </form>
                                <div class="mt-2" id="grid"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Filter Section End --->

            </div>
            <?php include '../../footer.php'; ?>
        </div>
    </div>


    <!-- Add Test -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add userlogin</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <form id="adduserlogin" method="post">
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="inputEmail4">mobile</label>
                                        <input type="text" class="form-control" name="mobile" placeholder="mobile" required>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <progress id="progressBar" value="0" max="100" style="width:100%;"></progress>
                                    </div>
                                    <div class="col-md-12 text-center">
                                        <button class="btn btn-primary upload_btn">Add userlogin</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-none">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Test -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit userlogin</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <form id="userloginupdate" method="post">
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="inputEmail4">mobile</label>
                                        <input type="hidden" name="userloginid" value="">
                                        <input type="text" class="form-control" name="mobile" placeholder="mobile">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <progress id="progressBarDocumentUpdate" value="0" max="100" style="width:100%;"></progress>
                                    </div>
                                    <div class="col-md-12 text-center">
                                        <button class="btn btn-primary update_btn">Update userlogin</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-none">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    
    <script>
        const otp = Math.floor(100000 + Math.random() * 900000);
        document.getElementById("otpInput").value = otp;
    </script>
    <script src="../../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../../assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="../../assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../../assets/libs/select2/dist/js/select2.full.min.js"></script>
    <script src="../../assets/libs/select2/dist/js/select2.min.js"></script>
    <script src="../../assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="../../assets/extra-libs/sparkline/sparkline.js"></script>
    <script src="../../dist/js/waves.js"></script>
    <script src="../../dist/js/sidebarmenu.js"></script>
    <script src="../../dist/js/custom.min.js"></script>
    <script src="../../assets/extra-libs/multicheck/datatable-checkbox-init.js"></script>
    <script src="../../assets/extra-libs/multicheck/jquery.multicheck.js"></script>
    <script src="../../assets/extra-libs/DataTables/datatables.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

    <script src="../../../vendor/rajvaibhavjain/etlib/js/SweetAlert.js"></script>
    <script src="../../../vendor/rajvaibhavjain/etlib/js/Grid.js"></script>
    <script src="usermanager.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $('#zero_config').DataTable();
        $('#filter_domain').select2();
        $('#adduserlogin select[name="otp_expiry"]').select2();
        $('#adduserlogin select[name="domain"]').select2();
        $('#adduserlogin select[name="type"]').select2();
        $('.select2').css('width', '100%');
        $("#userloginupdate select[name=\"stockids[]\"]").select2();
        $(document).ready(function() {
            $(".datepicker").datepicker({
                dateFormat: "dd/mm/yy"
            });
        })
    </script>
</body>

</html>
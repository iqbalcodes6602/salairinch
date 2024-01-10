
<?php 
    session_start();
    include('../../../ETWeb/includes/config.php'); 
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../../assets/images/favicon.png">
    <title>Admin</title>
    <!-- Custom CSS -->
    <link href="../../assets/libs/flot/css/float-chart.css" rel="stylesheet">
    <link href="../../dist/css/style.min.css" rel="stylesheet">
    
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <?php include '../../header.php';?>
        

        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 d-flex no-block align-items-center">
                        <h2 class="page-title">Dashboard</h2>
                    </div>
                </div>
            </div>

            
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->

            
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- Cards -->
                <div class="row">
                    <div class="col-12 d-flex no-block align-items-center">
                        <h4 class="page-title">Users</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card m-t-0">
                            <div class="row">
                                <div class="col-md-6 border-left text-center p-t-10">
                                    <h3 class="mb-0 font-weight-bold totaluser">...</h3>
                                    <span class="text-muted">Total Users</span>
                                    <div class="m-2">
                                        <a href="../user/usermanager.php" class="btn btn-primary">View</a>
                                    </div>
                                </div>
                                <div class="col-md-6 border-left text-center p-t-10">
                                    <h3 class="mb-0 font-weight-bold newuser">...</h3>
                                    <span class="text-muted">New Users</span>
                                    <div class="m-2">
                                        <a href="../user/usermanager.php" class="btn btn-primary">View</a>
                                    </div>
                                </div>
                                                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-md-4">
                        <div class="card m-t-0">
                            <div class="row">
                                <div class="col-md-6 border-left text-center p-t-10">
                                    <h3 class="mb-0 font-weight-bold totalfriendrequest">...</h3>
                                    <span class="text-muted">Total Friend Requests</span>
                                </div>
                                <div class="col-md-6 border-left text-center p-t-10">
                                    <h3 class="mb-0 font-weight-bold todayfriendrequest">...</h3>
                                    <span class="text-muted">Today's Friend Requests</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card m-t-0">
                            <div class="row">
                                <div class="col-md-6 border-left text-center p-t-10">
                                    <h3 class="mb-0 font-weight-bold connections">...</h3>
                                    <span class="text-muted">Total Connetions</span>
                                </div>
                                <div class="col-md-6 border-left text-center p-t-10">
                                    <h3 class="mb-0 font-weight-bold todayconnections">...</h3>
                                    <span class="text-muted">Today's Connetions</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card m-t-0">
                            <div class="row">
                                <div class="col-md-6 border-left text-center p-t-10">
                                    <h3 class="mb-0 font-weight-bold totalfeedback">...</h3>
                                    <span class="text-muted">Total Feedback</span>
                                </div>
                                <div class="col-md-6 border-left text-center p-t-10">
                                    <h3 class="mb-0 font-weight-bold todayfeedback">...</h3>
                                    <span class="text-muted">Today's Feedback</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card m-t-0">
                            <div class="row">
                                <div class="col-md-6 border-left text-center p-t-10">
                                    <h3 class="mb-0 font-weight-bold totalqna">...</h3>
                                    <span class="text-muted">Total Q & A</span>
                                </div>
                                <div class="col-md-6 border-left text-center p-t-10">
                                    <h3 class="mb-0 font-weight-bold todayqna">...</h3>
                                    <span class="text-muted">Today's Q & A</span>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
                <div class="row">
                    <div class="col-12 d-flex no-block align-items-center">
                        <h4 class="page-title">Order Amount</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card m-t-0">
                            <div class="row">
                                <div class="col-md-6 border-left text-center p-t-10">
                                    <h3 class="mb-0 font-weight-bold totalordertoday">...</h3>
                                    <span class="text-muted">Today Order Amount:</span>
                                </div>
                                <div class="col-md-6 border-left text-center p-t-10">
                                    <h3 class="mb-0 font-weight-bold totalwintoday">...</h3>
                                    <span class="text-muted">Today Win Order Amount</span>
                                </div>
                            </div>
                        </div>
                    </div>    
                     <div class="col-md-4 d-none">
                        <div class="card m-t-0">
                            <div class="row">
                                <div class="col-md-6 border-left text-center p-t-10">
                                    <h3 class="mb-0 font-weight-bold totalcoffeemeet">...</h3>
                                    <span class="text-muted">Total Coffee Meetings</span>
                                </div>
                                <div class="col-md-6 border-left text-center p-t-10">
                                    <h3 class="mb-0 font-weight-bold todaycoffeemeet">...</h3>
                                    <span class="text-muted">Today's Coffee Meetings</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 d-none">
                        <div class="card m-t-0">
                            <div class="row">
                                <div class="col-md-6 border-left text-center p-t-10">
                                    <h3 class="mb-0 font-weight-bold activepersonalmeet">...</h3>
                                    <span class="text-muted">Active Personal Meetings</span>
                                </div>
                                <div class="col-md-6 border-left text-center p-t-10">
                                    <h3 class="mb-0 font-weight-bold activecoffeemeet">...</h3>
                                    <span class="text-muted">Active Coffee Meetings</span>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
                <!-- <div class="row">
                    <div class="col-12 d-flex no-block align-items-center">
                        <h4 class="page-title">Stall</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card m-t-0">
                            <div class="row">
                                <div class="col-md-6 border-left text-center p-t-10">
                                    <h3 class="mb-0 font-weight-bold totaldownload">...</h3>
                                    <span class="text-muted">Total Download</span>
                                </div>
                                <div class="col-md-6 border-left text-center p-t-10">
                                    <h3 class="mb-0 font-weight-bold todaydownload">...</h3>
                                    <span class="text-muted">Today's Download</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card m-t-0">
                            <div class="row">
                                <div class="col-md-6 border-left text-center p-t-10">
                                    <h3 class="mb-0 font-weight-bold uniquedownload">...</h3>
                                    <span class="text-muted">Total Unique Download</span>
                                </div>
                                <div class="col-md-6 border-left text-center p-t-10">
                                    <h3 class="mb-0 font-weight-bold todayuniquedownload">...</h3>
                                    <span class="text-muted">Today's Unique Download</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card m-t-0">
                            <div class="row">
                                <div class="col-md-6 border-left text-center p-t-10">
                                    <h3 class="mb-0 font-weight-bold totalview">...</h3>
                                    <span class="text-muted">Total View</span>
                                </div>
                                <div class="col-md-6 border-left text-center p-t-10">
                                    <h3 class="mb-0 font-weight-bold todayview">...</h3>
                                    <span class="text-muted">Today's View</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card m-t-0">
                            <div class="row">
                                <div class="col-md-6 border-left text-center p-t-10">
                                    <h3 class="mb-0 font-weight-bold uniqueview">...</h3>
                                    <span class="text-muted">Total Unique View</span>
                                </div>
                                <div class="col-md-6 border-left text-center p-t-10">
                                    <h3 class="mb-0 font-weight-bold todayuniqueview">...</h3>
                                    <span class="text-muted">Today's Unique View</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
                <!-- End cards -->

                <!-- ============================================================== -->
                <!-- Chart-1 -->
                <!-- <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Real Time Chart</h5>
                                 <div id="real-time" style="height:400px;"></div>
                                <p>Time between updates:
                                    <input id="updateInterval" type="text" value="" style="text-align: right; width:5em"> milliseconds
                                </p>
                            </div>
                        </div>
                    </div>
                </div> -->
                <!-- ENd chart-1 -->
                <!-- Chart-2 -->
                <!-- <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Turning-series chart</h5>
                                <div id="placeholder" style="height: 400px;"></div>
                                <p id="choices" class="m-t-20"></p>
                            </div>
                        </div>
                    </div>
                </div> -->
                <!-- End Chart-2 -->
                
                <!-- Chart-3 -->
                <!-- <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Bar Chart</h5>
                                <div class="flot-chart">
                                    <div class="flot-chart-content" id="flot-line-chart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
                <!-- End chart-3 -->
                <!-- Charts -->
                <!-- <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Pie Chart</h5>
                                <div class="pie" style="height: 400px;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Line Chart</h5>
                                <div class="bars" style="height: 400px;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="data"></div> 
                </div> -->
                <!-- End Charts -->
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <?php include '../../footer.php';?>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="../../assets/libs/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="../../assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="../../assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="../../assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="../../assets/extra-libs/sparkline/sparkline.js"></script>
    <!--Wave Effects -->
    <script src="../../dist/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="../../dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="../../dist/js/custom.min.js"></script>
    <!-- this page js -->
    <script src="../../assets/libs/chart/matrix.interface.js"></script>
    <script src="../../assets/libs/chart/excanvas.min.js"></script>
    <script src="../../assets/libs/flot/jquery.flot.js"></script>
    <script src="../../assets/libs/flot/jquery.flot.pie.js"></script>
    <script src="../../assets/libs/flot/jquery.flot.time.js"></script>
    <script src="../../assets/libs/flot/jquery.flot.stack.js"></script>
    <script src="../../assets/libs/flot/jquery.flot.crosshair.js"></script>
    <script src="../../assets/libs/chart/jquery.peity.min.js"></script>
    <script src="../../assets/libs/chart/matrix.charts.js"></script>
    <script src="../../assets/libs/chart/jquery.flot.pie.min.js"></script>
    <script src="../../assets/libs/flot.tooltip/js/jquery.flot.tooltip.min.js"></script>
    <script src="../../assets/libs/chart/turning-series.js"></script>
    <script src="../../dist/js/pages/chart/chart-page-init.js"></script>


    

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../../vendor/rajvaibhavjain/etlib/js/SweetAlert.js"></script>
    <script src="dashboardmanager.js"></script>

</body>

</html>
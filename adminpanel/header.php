<?php
    // if(isset($_SESSION['type']) && $_SESSION['type']=="admin"){
    if(isset($_SESSION['type']) && ($_SESSION['type']=="supervisor" || $_SESSION['type']=="admin")){
    }else{
        error_reporting(0);
        echo '<script>window.location.href = "'.$GLOBALS['AppConfig']['AdminURL'].'";</script>';
        header('Location: '.$GLOBALS['AppConfig']['AdminURL']);
        die;
    }
?>
<header class="topbar" data-navbarbg="skin5">
    <nav class="navbarl navbar-expand-md navbar-dark" style="float:right;">
        <div class="navbar-header" data-logobg="skin5">
		<a class="navbar-brand mr-3 mt-3" href="<?=$GLOBALS['AppConfig']['AdminURL']?>/modules/login/Api.php/logout" style="float:right;">Logout</a>
        </div>
	</nav>
	<nav class="navbar top-navbar navbar-expand-md navbar-dark">
        <div class="navbar-header" data-logobg="skin5">
            <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
            <a class="navbar-brand" href="index.php">
                <b class="logo-icon p-l-10">
                    <img src="<?=$GLOBALS['AppConfig']['AdminURL']?>/assets/images/logo.png" width="120" alt="homepage" class="light-logo" />
                </b>
            </a>
        </div>
    </nav>
</header>
<aside class="left-sidebar" data-sidebarbg="skin5">
    <div class="scroll-sidebar">
        <nav class="sidebar-nav">
            <ul id="sidebarnav" class="p-t-30">
				
            <li class="sidebar-item"><a href="<?=$GLOBALS['AppConfig']['AdminURL']?>/modules/dashboard/dashboardmanager.php" class="sidebar-link"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Dashboard </span></a></li>
                <?php  if(isset($_SESSION['type']) &&  $_SESSION['type']=="admin"){ ?>
                    <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><span class="hide-menu">Category</span></a>
                        <ul aria-expanded="false" class="collapse  first-level">
                            <li class="sidebar-item"><a href="<?=$GLOBALS['AppConfig']['AdminURL']?>/modules/category/categorymanager.php" class="sidebar-link"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">category </span></a></li>
                            <li class="sidebar-item"><a href="<?=$GLOBALS['AppConfig']['AdminURL']?>/modules/subcategory/subcategorymanager.php" class="sidebar-link"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Sub category </span></a></li>
                        </ul>
                    </li>
                    <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><span class="hide-menu">Contact Us</span></a>
                        <ul aria-expanded="false" class="collapse  first-level">
                            <li class="sidebar-item"><a href="<?=$GLOBALS['AppConfig']['AdminURL']?>/modules/contactus/contactusmanager.php" class="sidebar-link"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Contact Us </span></a></li>
                            <li class="sidebar-item"><a href="<?=$GLOBALS['AppConfig']['AdminURL']?>/modules/book/bookmanager.php" class="sidebar-link"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Book Online </span></a></li>
                        </ul>
                    </li>
                    <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><span class="hide-menu">Order</span></a>
                        <ul aria-expanded="false" class="collapse  first-level">
                            <li class="sidebar-item"><a href="<?=$GLOBALS['AppConfig']['AdminURL']?>/modules/order/ordermanager.php" class="sidebar-link"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Order </span></a></li>
                        </ul>
                    </li>
                    <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><span class="hide-menu">User Login</span></a>
                        <ul aria-expanded="false" class="collapse  first-level">
                            <li class="sidebar-item"><a href="<?=$GLOBALS['AppConfig']['AdminURL']?>/modules/userlogin/usermanager.php" class="sidebar-link"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">User Login </span></a></li>
                        </ul>
                    </li>
                    <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><span class="hide-menu">Settings</span></a>
                        <ul aria-expanded="false" class="collapse  first-level">
                            <li class="sidebar-item"><a href="<?=$GLOBALS['AppConfig']['AdminURL']?>/modules/setting/settingmanager.php" class="sidebar-link"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Settings </span></a></li>
                        </ul>
                    </li>
                <?php }else{ ?>   
                    <li class="sidebar-item"><a href="<?=$GLOBALS['AppConfig']['AdminURL']?>/modules/dashboard/dashboardmanager.php" class="sidebar-link"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Dashboard </span></a></li>
                    
                <?php } ?>
                
                
				<!-- <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><span class="hide-menu">Due Balance</span></a>
					<ul aria-expanded="false" class="collapse  first-level">
						<li class="sidebar-item"><a href="<?=$GLOBALS['AppConfig']['AdminURL']?>/modules/duebalance/duebalancemanager.php" class="sidebar-link"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu"> Due Balance </span></a></li>
					</ul>
				</li> -->
            </ul>
        </nav>
    </div>
</aside>
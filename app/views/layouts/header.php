<?php
if (!session("user_id")) {
    session("notification", ["type" => "alert-danger", "message" => "You must login first!"]);

    header("location: /");

    exit();
} else {
    $database = new Database();

    $user_id = session("user_id");

    $user_data = $database->select_one("users", ["id" => $user_id]);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Boss Cafe Management System</title>

    <link href="./assets/plugins/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="./assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="./assets/plugins/nprogress/nprogress.css" rel="stylesheet">
    <link href="./assets/plugins/sweetalert2/css/sweetalert2.min.css" rel="stylesheet">
    <link href="./assets/plugins/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="./assets/css/custom.min.css" rel="stylesheet">
    <link href="./assets/css/main.css" rel="stylesheet">
</head>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="" class="site_title">
                            <img src="./assets/img/logo.png" alt="..." class="img-circle bg-white" style="width: 34px; height: 34px;">
                            <span>Boss Cafe MS</span>
                        </a>
                    </div>

                    <div class="clearfix"></div>

                    <div class="profile clearfix">
                        <div class="profile_pic">
                            <img src="./uploads/<?= $user_data["image"] ?>" alt="..." class="img-circle profile_img" style="width: 56px; height: 56px;">
                        </div>
                        <div class="profile_info">
                            <span>Welcome,</span>
                            <h2><?= $user_data["name"] ?></h2>
                        </div>
                    </div>

                    <br />

                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">
                            <h3>Overview</h3>
                            <ul class="nav side-menu">
                                <li><a href="dashboard"><i class="fa fa-dashboard"></i> Dashboard </a></li>
                            </ul>
                        </div>
                        <div class="menu_section">
                            <h3>Sales & Orders</h3>
                            <ul class="nav side-menu">
                                <li><a href="orders"><i class="fa fa-list-alt"></i> Orders </a></li>
                                <li><a href="sales_report"><i class="fa fa-line-chart"></i> Sales Report </a></li>
                            </ul>
                        </div>
                        <div class="menu_section">
                            <h3>Menu & Inventory</h3>
                            <ul class="nav side-menu">
                                <li><a href="menu_management"><i class="fa fa-cutlery"></i> Menu Management </a></li>
                                <li><a href="inventory"><i class="fa fa-archive"></i> Inventory </a></li>
                            </ul>
                        </div>
                        <div class="menu_section">
                            <h3>Reports & Analytics</h3>
                            <ul class="nav side-menu">
                                <li><a href="customer_reports"><i class="fa fa-file-text-o"></i> Customer Reports </a></li>
                            </ul>
                        </div>
                        <div class="menu_section">
                            <h3>Database</h3>
                            <ul class="nav side-menu">
                                <li><a href="backup_and_restore"><i class="fa fa-database"></i> Backup and Restore </a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="sidebar-footer hidden-small">
                        <a data-toggle="tooltip" data-placement="top" title="Account Settings" class="account_settings" href="javascript:void(0)">
                            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="About Us" class="about_us" href="javascript:void(0)">
                            <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="Backup" class="backup" href="javascript:void(0)">
                            <span class="glyphicon glyphicon-save" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="Logout" class="logout" href="javascript:void(0)">
                            <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="top_nav">
                <div class="nav_menu">
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>
                    <nav class="nav navbar-nav">
                        <ul class=" navbar-right">
                            <li class="nav-item dropdown open" style="padding-left: 15px;">
                                <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                                    <img src="./uploads/default-user-image.png" alt="User Image" class="border"><?= $user_data["name"] ?>
                                </a>
                                <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item account_settings" href="javascript:void(0)">Account Settings</a>
                                    <a class="dropdown-item about_us" href="javascript:void(0)">About Us</a>
                                    <a class="dropdown-item logout" href="javascript:void(0)"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                                </div>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
<?php
$database = new Database();

$sql = "SELECT SUM(total_price) AS total_sales FROM orders WHERE status = ?";
$result = $database->query($sql, ["completed"]);

$total_sales = $result[0]['total_sales'] ?? "0.00";
?>

<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Dashboard</h3>
            </div>
        </div>

        <div class="clearfix"></div>

        <!-- Top Cards -->
        <div class="row mb-3">
            <div class="col-md-3 col-sm-6">
                <div class="card text-center bg-primary text-white">
                    <div class="card-body">
                        <span class="count_top"><i class="fa fa-users"></i> Total Users</span>
                        <h3 class="count"><?= count($database->select_all("users")) ?></h3>
                        <p class="count_bottom text-light">Overview of total registered users</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card text-center bg-success text-white">
                    <div class="card-body">
                        <span class="count_top"><i class="fa fa-cube"></i> Total Items</span>
                        <h3 class="count"><?= count($database->select_many("items", ["status" => "Available"])) ?></h3>
                        <p class="count_bottom text-light">Total items available in inventory</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card text-center bg-warning text-white">
                    <div class="card-body">
                        <span class="count_top"><i class="fa fa-money"></i> Total Sales</span>
                        <h3 class="count">₱ <?= number_format($total_sales, 2) ?></h3>
                        <p class="count_bottom text-light">Total revenue generated</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="card text-center bg-danger text-white">
                    <div class="card-body">
                        <span class="count_top"><i class="fa fa-exclamation-triangle"></i> Out of Stock Items</span>
                        <h3 class="count"><?= count($database->select_many("inventories", ["stock_level" => "0"])) ?></h3>
                        <p class="count_bottom text-light">Total items with zero stock</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="row">
            <div class="col-lg-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Recent Activities</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="question-link"><i class="fa fa-question-circle"></i></a></li>
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="table-responsive">
                            <table id="datatable" class="table table-striped table-bordered">
                                <thead>
                                    <tr class="text-center">
                                        <th>Date & Time</th>
                                        <th>User Name</th>
                                        <th>Activity</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
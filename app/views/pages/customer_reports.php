<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Customer Reports</h3>
            </div>
            <div class="title_right text-right">
                <button class="btn btn-success" id="print_report">
                    <i class="fa fa-print"></i> Print Report
                </button>
                <button class="btn btn-primary" id="export_as_pdf">
                    <i class="fa fa-download"></i> Export as PDF
                </button>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Customer Insights</h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatable" class="table table-striped table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <!-- <th>Customer ID</th> -->
                                    <th>Name</th>
                                    <th>Total Orders</th>
                                    <th>Total Spend</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $database = new Database();

                                $sql = "SELECT o.customer_name, COUNT(o.id) AS total_orders, SUM(o.total_price) AS total_spend FROM orders o WHERE o.status = 'Completed' GROUP BY o.customer_name ORDER BY total_spend DESC;";
                                $rows = $database->query($sql);
                                ?>
                                <?php if ($rows): ?>
                                    <?php foreach ($rows as $row): ?>
                                        <tr class='text-center'>
                                            <td><?= $row['customer_name'] ?></td>
                                            <td><?= $row['total_orders'] ?></td>
                                            <td><i class="fa fa-peso"></i> <?= number_format($row['total_spend'], 2) ?></td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
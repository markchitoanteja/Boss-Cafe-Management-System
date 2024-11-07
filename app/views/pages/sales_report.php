<?php

/**
 * Generates an order ID with leading zeros, ensuring a fixed length of 5 digits.
 *
 * This function pads the input ID with leading zeros to reach a total length
 * of 5 characters. If the input ID is already 5 or more characters, it returns
 * the ID as-is.
 *
 * @param string $id The base ID to format as a 5-digit order ID.
 *                   Typically, this will be a numeric string or integer.
 * 
 * @return string The formatted order ID with leading zeros.
 * 
 * @example
 * echo create_order_id("1"); // Outputs: "00001"
 * echo create_order_id("23"); // Outputs: "00023"
 * echo create_order_id("12345"); // Outputs: "12345"
 * echo create_order_id("678901"); // Outputs: "678901"
 */
function create_order_id(string $id)
{
    return "#" . str_pad($id, 5, '0', STR_PAD_LEFT);
}

$database = new Database();

$sql = "SELECT SUM(total_price) AS total_sales FROM orders WHERE status = ?";
$result = $database->query($sql, ["completed"]);

$total_sales = $result[0]['total_sales'] ?? "0.00";

$sql_2 = "SELECT SUM(total_price) / COUNT(*) AS average_order_value FROM orders";
$result_2 = $database->query($sql_2);

$average_order_value = $result_2[0]["average_order_value"];

$sql_3 = "SELECT items.name, COUNT(orders.item_id) AS total_quantity FROM orders JOIN items ON orders.item_id = items.id GROUP BY items.id ORDER BY total_quantity DESC LIMIT 1";
$result_3 = $database->query($sql_3);

if ($result_3) {
    $top_product = $result_3[0]["name"];
} else {
    $top_product = "Not Yet Available";
}
?>

<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Sales Report</h3>
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
            <div class="col-lg-3">
                <div class="x_panel" style="background-color: #4caf50; color: white;">
                    <div class="x_title">
                        <h2>Total Sales</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <h3><i class="fa fa-peso"></i> <?= number_format($total_sales, 2) ?></h3>
                        <p>Total sales for all time period.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="x_panel" style="background-color: #ff9800; color: white;">
                    <div class="x_title">
                        <h2>Average Order Value</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <h3><i class="fa fa-peso"></i> <?= number_format($average_order_value, 2) ?></h3>
                        <p>Average sales per order.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="x_panel" style="background-color: #9c27b0; color: white;">
                    <div class="x_title">
                        <h2>Top Product</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <h3><?= $top_product ?></h3>
                        <p>Most ordered item.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Detailed Sales Report</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatable" class="table table-striped table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th>Date</th>
                                    <th>Order ID</th>
                                    <th>Customer Name</th>
                                    <th>Item Name</th>
                                    <th>Quantity</th>
                                    <th>Total Price</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $orders = $database->select_all("orders", "id", "DESC") ?>

                                <?php if ($orders): ?>
                                    <?php foreach ($orders as $order): ?>
                                        <tr class="text-center">
                                            <td><?= date("F j, Y g:i A", strtotime($order["created_at"])) ?></td>
                                            <td><?= create_order_id($order["id"]) ?></td>
                                            <td><?= $order["customer_name"] ?></td>
                                            <td><?= $database->select_one("items", ["id" => $order["item_id"]])["name"] ?></td>
                                            <td><?= $order["quantity"] ?> PC<?= $order["quantity"] > 1 ? "S" : null ?></td>
                                            <td><i class="fa fa-peso"></i> <?= $order["total_price"] ?></td>
                                            <td class="text-<?= $order["status"] == "Completed" ? "success" : "danger" ?>"><?= $order["status"] ?></td>
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
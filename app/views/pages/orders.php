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
    return str_pad($id, 5, '0', STR_PAD_LEFT);
}
?>

<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Orders</h3>
            </div>
            <div class="title_right text-right">
                <button class="btn btn-primary" data-toggle="modal" data-target="#new_order_modal">
                    <i class="fa fa-plus"></i> Add New Order
                </button>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Current Orders</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatable" class="table table-striped table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th>Order ID</th>
                                    <th>Customer Name</th>
                                    <th>Item Name</th>
                                    <th>Quantity</th>
                                    <th>Total Price</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $database = new Database();
                                $orders = $database->select_all("orders", "id", "DESC");
                                ?>

                                <?php if ($orders): ?>
                                    <?php foreach ($orders as $order): ?>
                                        <tr class="text-center">
                                            <td><?= create_order_id($order["id"]) ?></td>
                                            <td><?= $order["customer_name"] ?></td>
                                            <td><?= $database->select_one("items", ["id" => $order["item_id"]])["name"] ?></td>
                                            <td><?= $order["quantity"] ?> PC<?= $order["quantity"] > 1 ? "S" : null ?></td>
                                            <td><i class="fa fa-peso"></i> <?= $order["total_price"] ?></td>
                                            <td class="text-<?= $order["status"] == "Completed" ? "success" : "danger" ?>"><?= $order["status"] ?></td>
                                            <td>
                                                <a href="javascript:void(0)" class="btn btn-sm btn-success update_order" order_id="<?= $order["id"] ?>">
                                                    <i class="fa fa-pencil"></i> Update Order
                                                </a>
                                            </td>
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

<?php include_once "../app/views/components/new_order.php" ?>
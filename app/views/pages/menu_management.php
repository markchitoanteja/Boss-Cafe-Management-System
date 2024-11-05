<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Menu Management</h3>
            </div>
            <div class="title_right text-right">
                <button class="btn btn-primary" data-toggle="modal" data-target="#new_item_modal">
                    <i class="fa fa-plus"></i> Add New Item
                </button>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Current Menu Items</h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatable" class="table table-striped table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th>Item Name</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $database = new Database();
                                $items = $database->select_all("items", "id", "DESC");
                                ?>

                                <?php if ($items): ?>
                                    <?php foreach ($items as $item): ?>
                                        <tr class="text-center">
                                            <td><?= $item["name"] ?></td>
                                            <td><?= $item["category"] ?></td>
                                            <td><i class="fa fa-peso"></i> <?= $item["price"] ?></td>
                                            <td class="text-<?= $item["status"] == "Available" ? "success" : "danger" ?>"><?= $item["status"] ?></td>
                                            <td>
                                                <a href="javascript:void(0)" class="mr-1 update_item" item_id="<?= $item["id"] ?>">
                                                    <i class="fa fa-pencil text-success"></i>
                                                </a>
                                                <a href="javascript:void(0)" class="delete_item" item_id="<?= $item["id"] ?>">
                                                    <i class="fa fa-trash text-danger"></i>
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

<?php include_once "../app/views/components/new_item.php" ?>
<?php include_once "../app/views/components/update_item.php" ?>
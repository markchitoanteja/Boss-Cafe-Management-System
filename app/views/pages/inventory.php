<?php
function units($abbrv, $stock_level)
{
    $unitNames = [
        'kg' => 'Kilogram',
        'g' => 'Gram',
        'lb' => 'Pound',
        'L' => 'Liter',
        'ml' => 'Milliliter',
        'units' => 'Unit',
        'packs' => 'Pack',
        'dozens' => 'Dozen',
        'bottles' => 'Bottle',
        'cans' => 'Can'
    ];

    if (array_key_exists($abbrv, $unitNames)) {
        $fullName = $unitNames[$abbrv];

        if (($stock_level > 1 || $stock_level == 0) && in_array($abbrv, ['kg', 'g', 'lb', 'L', 'ml', 'units', 'packs', 'dozens', 'bottles', 'cans'])) {
            return $fullName . 's';
        }

        return $fullName;
    }

    return '';
}
?>

<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Inventory</h3>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Current Available Menu Items</h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table id="datatable" class="table table-striped table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th>Item Name</th>
                                    <th>Category</th>
                                    <th>Stock Level</th>
                                    <?php if ($user_type == "admin"): ?>
                                        <th>Actions</th>
                                    <?php endif ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $database = new Database();
                                $inventories = $database->select_many("inventories", [], "", "inventories.id", "DESC", [['table' => 'items', 'on' => 'items.id = inventories.item_id']]);
                                ?>

                                <?php if ($inventories): ?>
                                    <?php foreach ($inventories as $inventory): ?>
                                        <tr class="text-center">
                                            <td><?= $inventory["name"] ?></td>
                                            <td><?= $inventory["category"] ?></td>
                                            <td class="<?= $inventory["stock_level"] == 0 ? "text-danger" : null ?>"><?= $inventory["stock_level"] ?> <?= units($inventory["unit"], $inventory["stock_level"]) ?></td>
                                            <?php if ($user_type == "admin"): ?>
                                                <td>
                                                    <a href="javascript:void(0)" class="btn btn-sm btn-success update_inventory" item_id="<?= $inventory["item_id"] ?>" item_name="<?= $inventory["name"] ?>" item_category="<?= $inventory["category"] ?>">
                                                        <i class="fa fa-pencil"></i> Update Inventory
                                                    </a>
                                                </td>
                                            <?php endif ?>
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

<?php include_once "../app/views/components/update_inventory.php" ?>
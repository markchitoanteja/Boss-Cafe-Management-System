<?php $database = new Database() ?>

<div class="modal fade" id="new_order_modal" tabindex="-1" role="dialog" aria-labelledby="menuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="menuModalLabel">New Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="javascript:void(0)" id="new_order_form">
                <div class="modal-body">
                    <!-- Loading Indicator -->
                    <div class="loading d-none">
                        <div class="d-flex justify-content-center align-items-center py-5">
                            <img src="./assets/img/loading.gif" class="mr-2" alt="Loading GIF">
                            <h3>Please Wait...</h3>
                        </div>
                    </div>

                    <!-- Main Form Content -->
                    <div class="main-form">
                        <div class="form-group">
                            <label for="new_order_staff_name">Staff Name</label>
                            <input type="text" class="form-control" id="new_order_staff_name" value="<?= $user_data["name"] ?>" readonly required>
                            <input type="hidden" id="new_order_staff_id" value="<?= $user_data["id"] ?>">
                        </div>

                        <div class=" form-group">
                            <?php $customers = $database->select_all("customers", "name", "ASC") ?>
                            <label for="new_order_customer_name">Customer Name</label>
                            <input type="text" class="form-control" list="<?= $customers ? "customers" : null ?>" id="new_order_customer_name" required>
                            <datalist id="customers">
                                <?php if ($customers): ?>
                                    <?php foreach ($customers as $customer): ?>
                                        <option value="<?= $customer["name"] ?>">
                                    <?php endforeach ?>
                                <?php endif ?>
                            </datalist>
                        </div>

                        <div class="form-group">
                            <label for="new_order_item_id">Item Name</label>
                            <select class="form-control" id="new_order_item_id" required>
                                <option value selected disabled></option>
                                <?php $items = $database->select_many("items", ["status" => "Available"]) ?>
                                <?php if ($items): ?>
                                    <?php foreach ($items as $item): ?>
                                        <option value="<?= $item["id"] ?>"><?= $item["name"] ?></option>
                                    <?php endforeach ?>
                                <?php endif ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="new_order_quantity">Quantity</label>
                            <input type="number" class="form-control" id="new_order_quantity" min="1" required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="new_order_submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
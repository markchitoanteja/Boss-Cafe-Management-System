<div class="modal fade" id="update_inventory_modal" tabindex="-1" role="dialog" aria-labelledby="menuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="menuModalLabel">Update Inventory</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="javascript:void(0)" id="update_inventory_form">
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
                        <div class="mb-3">
                            <div class="row mb-2">
                                <div class="col-lg-2">
                                    <strong>Name:</strong>
                                </div>
                                <div class="col-lg-10">
                                    <span id="update_inventory_name">Sample Item</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-2">
                                    <strong>Category:</strong>
                                </div>
                                <div class="col-lg-10">
                                    <span id="update_inventory_category">Sample Category</span>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="alert alert-danger text-center d-none notification_alert" role="alert">
                            Stock level must not be less than zero!
                        </div>

                        <div class="form-group">
                            <label for="update_inventory_stock_level">Stock Level</label>
                            <input type="number" class="form-control" id="update_inventory_stock_level" min="0" step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label for="update_inventory_unit">Unit</label>
                            <select id="update_inventory_unit" class="form-control" required>
                                <option value="kg">Kilograms (kg)</option>
                                <option value="g">Grams (g)</option>
                                <option value="lb">Pounds (lb)</option>
                                <option value="L">Liters (L)</option>
                                <option value="ml">Milliliters (ml)</option>
                                <option value="units">Units (pieces)</option>
                                <option value="packs">Packs</option>
                                <option value="dozens">Dozens</option>
                                <option value="bottles">Bottles</option>
                                <option value="cans">Cans</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="update_inventory_item_id">

                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="update_inventory_submit">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="update_item_modal" tabindex="-1" role="dialog" aria-labelledby="menuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="menuModalLabel">New Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="javascript:void(0)" id="update_item_form">
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
                        <div class="alert alert-danger text-center d-none notification_alert" role="alert">
                            This item is already in the database!
                        </div>
                        <div class="form-group">
                            <label for="update_item_name">Item Name</label>
                            <input type="text" class="form-control" id="update_item_name" required>
                        </div>
                        <div class="form-group">
                            <label for="update_item_category">Category</label>
                            <select class="form-control" id="update_item_category" required>
                                <option value="Coffee">Coffee</option>
                                <option value="Tea">Tea</option>
                                <option value="Pastries">Pastries</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="update_item_price">Price</label>
                            <input type="number" class="form-control" id="update_item_price" step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label for="update_item_status">Status</label>
                            <select class="form-control" id="update_item_status" required>
                                <option value="Available">Available</option>
                                <option value="Unavailable">Unavailable</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="update_item_id">

                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="update_item_submit">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="check_admin_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Admin Authorization Required!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="javascript:void(0)" id="check_admin_form">
                <div class="modal-body">
                    <div class="loading d-none">
                        <div class="d-flex justify-content-center align-items-center py-5">
                            <img src="./assets/img/loading.gif" class="mr-2" alt="Loading GIF">
                            <h3>Please Wait...</h3>
                        </div>
                    </div>
                    <div class="main-form">
                        <div class="alert alert-danger text-center d-none notification_alert" role="alert">
                            Invalid Username or Password!
                        </div>

                        <div class="form-group">
                            <label for="check_admin_username">Username</label>
                            <input type="text" class="form-control" id="check_admin_username" required>
                        </div>
                        <div class="form-group">
                            <label for="check_admin_password">Password</label>
                            <input type="password" class="form-control" id="check_admin_password" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="check_admin_order_id">

                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="check_admin_submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
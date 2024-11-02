<div class="modal fade" id="account_settings_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Account Settings</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="javascript:void(0)" id="account_settings_form">
                <div class="modal-body">
                    <div class="loading d-none">
                        <div class="d-flex justify-content-center align-items-center py-5">
                            <img src="./assets/img/loading.gif" class="mr-2" alt="Loading GIF">
                            <h3>Please Wait...</h3>
                        </div>
                    </div>
                    <div class="main-form">
                        <div class="alert alert-danger text-center d-none notification_alert" role="alert">
                            Username is already taken. Please choose a different username.
                        </div>

                        <div class="form-group">
                            <label for="account_settings_name" class="mb-0">Name</label>
                            <input type="text" class="form-control" id="account_settings_name" placeholder="Enter your name" required>
                        </div>

                        <div class="form-group">
                            <label for="account_settings_username" class="mb-0">Username</label>
                            <input type="text" class="form-control" id="account_settings_username" placeholder="Enter your username" required>
                        </div>

                        <div class="form-group">
                            <label for="account_settings_password" class="mb-0">Password</label>
                            <input type="password" class="form-control" id="account_settings_password" placeholder="Enter new password">
                            <small class="form-text text-muted">Leave blank to keep current password.</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="account_settings_old_password">

                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="account_settings_submit">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
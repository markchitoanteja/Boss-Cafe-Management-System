<?php
if (session("user_id")) {
    header("location: dashboard");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Boss Cafe Management System</title>

    <link href="./assets/plugins/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="./assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="./assets/plugins/animate.css/animate.min.css" rel="stylesheet">
    <link href="./assets/plugins/sweetalert2/css/sweetalert2.min.css" rel="stylesheet">

    <link href="./assets/css/custom.min.css" rel="stylesheet">
    <link href="./assets/css/login.css" rel="stylesheet">
</head>

<body class="login">
    <div>
        <a class="hiddenanchor" id="signup"></a>
        <a class="hiddenanchor" id="signin"></a>

        <div class="loading d-none">
            <img src="./assets/img/loading.gif" class="mr-2" alt="Loading GIF">
            <h3>Please Wait...</h3>
        </div>

        <div class="login_wrapper">
            <?php if (session("notification")): ?>
                <div class="alert <?= session("notification")["type"] ?> text-center" id="notification"><?= session("notification")["message"] ?></div>
            <?php endif ?>

            <div class="alert text-center d-none" id="login_notification"><!-- Text From AJAX --></div>

            <div class="animate form login_form pt-3">
                <section class="login_content">
                    <form action="javascript:void(0)" id="login_form">
                        <h1>Login</h1>
                        <div>
                            <p class="text-danger mb-0 d-none" id="error_login_username">Username is required!</p>
                            <input type="text" class="form-control" id="login_username" placeholder="Username" required />
                        </div>
                        <div>
                            <p class="text-danger mb-0 d-none" id="error_login_password">Password is required!</p>
                            <input type="password" class="form-control" id="login_password" placeholder="Password" required />
                        </div>
                        <div>
                            <a class="btn btn-default submit" id="login_submit" href="javascript:void(0)">Log in</a>
                            <a class="reset_pass" href="javascript:void(0)">Lost your password?</a>
                        </div>

                        <div class="clearfix"></div>

                        <div class="separator">
                            <p class="change_link">Need an Account?
                                <a href="#signup" class="to_register"> Create Account </a>
                            </p>

                            <div class="clearfix"></div>
                            <br />

                            <div>
                                <h1>Boss Cafe Management System</h1>
                                <p>&copy;2024 All Rights Reserved.</p>
                            </div>
                        </div>
                    </form>
                </section>
            </div>

            <div id="register" class="animate form registration_form pt-3">
                <section class="login_content">
                    <form>
                        <h1>Create an Account</h1>
                        <div>
                            <p class="text-danger mb-0 d-none" id="error_register_name">Name is required!</p>
                            <input type="text" class="form-control" id="register_name" placeholder="Name" required />
                        </div>
                        <div>
                            <p class="text-danger mb-0 d-none" id="error_register_username">Username is required!</p>
                            <input type="text" class="form-control" id="register_username" placeholder="Username" required />
                        </div>
                        <div>
                            <p class="text-danger mb-0 d-none" id="error_register_password">Password is required!</p>
                            <input type="password" class="form-control" id="register_password" placeholder="Password" required />
                        </div>
                        <div>
                            <p class="text-danger mb-0 d-none" id="error_register_confirm_password">Confirm Password is required!</p>
                            <input type="password" class="form-control" id="register_confirm_password" placeholder="Confirm Password" required />
                        </div>
                        <div>
                            <a class="btn btn-default submit" id="register_submit" href="javascript:void(0)">Submit</a>
                        </div>

                        <div class="clearfix"></div>

                        <div class="separator">
                            <p class="change_link">Already an Employee ?
                                <a href="" class="to_register"> Log in </a>
                            </p>

                            <div class="clearfix"></div>
                            <br />

                            <div>
                                <h1>Boss Cafe Management System</h1>
                                <p>©2024 All Rights Reserved.</p>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>

    <script src="./assets/plugins/jquery/dist/jquery.min.js"></script>
    <script src="./assets/plugins/sweetalert2/js/sweetalert2.min.js"></script>
    <script src="./assets/js/login.js"></script>
</body>

</html>

<?php session("notification", "unset") ?>
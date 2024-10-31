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
    <link href="./assets/plugins/nprogress/nprogress.css" rel="stylesheet">
    <link href="./assets/plugins/animate.css/animate.min.css" rel="stylesheet">

    <link href="./assets/css/custom.min.css" rel="stylesheet">
</head>

<body class="login">
    <div>
        <a class="hiddenanchor" id="signup"></a>
        <a class="hiddenanchor" id="signin"></a>

        <div class="login_wrapper">
            <div class="animate form login_form">
                <section class="login_content">
                    <form action="javascript:void(0)" id="login_form">
                        <h1>Login</h1>
                        <div>
                            <p class="text-danger mb-0 d-none" id="error_login_username">Username is required!</p>
                            <input type="text" class="form-control" id="login_username" placeholder="Username" required="" />
                        </div>
                        <div>
                            <p class="text-danger mb-0 d-none" id="error_login_password">Password is required!</p>
                            <input type="password" class="form-control" id="login_password" placeholder="Password" required="" />
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
                                <p>©2024 All Rights Reserved.</p>
                            </div>
                        </div>
                    </form>
                </section>
            </div>

            <div id="register" class="animate form registration_form">
                <section class="login_content">
                    <form>
                        <h1>Create an Account</h1>
                        <div>
                            <input type="text" class="form-control" placeholder="Username" required="" />
                        </div>
                        <div>
                            <input type="email" class="form-control" placeholder="Email" required="" />
                        </div>
                        <div>
                            <input type="password" class="form-control" placeholder="Password" required="" />
                        </div>
                        <div>
                            <a class="btn btn-default submit" href="index.html">Submit</a>
                        </div>

                        <div class="clearfix"></div>

                        <div class="separator">
                            <p class="change_link">Already a member ?
                                <a href="#signin" class="to_register"> Log in </a>
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
    <script src="./assets/js/login.js"></script>
</body>

</html>
jQuery(document).ready(function () {
    $("#login_submit").click(function () {
        const username = $("#login_username").val();
        const password = $("#login_password").val();

        let is_error = false;

        if (!username) {
            $("#login_username").addClass("is-invalid");
            $("#error_login_username").removeClass("d-none");

            is_error = true;
        }

        if (!password) {
            $("#login_password").addClass("is-invalid");
            $("#error_login_password").removeClass("d-none");

            is_error = true;
        }

        if (!is_error) {
            var formData = new FormData();

            $(".login_wrapper").addClass("d-none");
            $(".loading").removeClass("d-none");

            $("#login_notification").removeClass("alert-danger");
            $("#login_notification").removeClass("alert-success");
            $("#login_notification").addClass("d-none");

            $("#notification").addClass("d-none");

            formData.append('username', username);
            formData.append('password', password);

            formData.append('action', 'login');

            $.ajax({
                url: 'server',
                data: formData,
                type: 'POST',
                dataType: 'JSON',
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        setTimeout(function () {
                            $("#login_notification").text("Invalid Username or Password!");
                            $("#login_notification").addClass("alert-danger");
                            $("#login_notification").removeClass("d-none");

                            $(".login_wrapper").removeClass("d-none");
                            $(".loading").addClass("d-none");
                        }, 1500);
                    }
                },
                error: function (_, _, error) {
                    console.error(error);
                }
            });
        }
    })

    $("#login_username").keydown(function () {
        $("#login_username").removeClass("is-invalid");
        $("#error_login_username").addClass("d-none");
    })

    $("#login_password").keydown(function () {
        $("#login_password").removeClass("is-invalid");
        $("#error_login_password").addClass("d-none");
    })

    $(".reset_pass").click(function () {
        Swal.fire({
            title: "Attention!",
            text: "Please contact your administrator!",
            icon: "info"
        });
    })

    $(".to_register").click(function () {
        $("#login_notification").removeClass("alert-danger");
        $("#login_notification").removeClass("alert-success");
        $("#login_notification").addClass("d-none");
        $("#notification").addClass("d-none");
    })

    $("#register_submit").click(function () {
        const name = $("#register_name").val();
        const username = $("#register_username").val();
        const password = $("#register_password").val();
        const confirm_password = $("#register_confirm_password").val();

        let is_error = false;

        if (!name) {
            $("#register_name").addClass("is-invalid");
            $("#error_register_name").removeClass("d-none");

            is_error = true;
        }

        if (!username) {
            $("#register_username").addClass("is-invalid");
            $("#error_register_username").text("Username is required!");
            $("#error_register_username").removeClass("d-none");

            is_error = true;
        }

        if (!password) {
            $("#register_password").addClass("is-invalid");
            $("#error_register_password").text("Password is required!");
            $("#error_register_password").removeClass("d-none");

            is_error = true;
        }

        if (!confirm_password) {
            $("#register_confirm_password").addClass("is-invalid");
            $("#error_register_confirm_password").text("Confirm Password is required!");
            $("#error_register_confirm_password").removeClass("d-none");

            is_error = true;
        }

        if (!is_error) {
            if (password != confirm_password) {
                $("#register_password").addClass("is-invalid");
                $("#error_register_password").text("Passwords do not match!");
                $("#error_register_password").removeClass("d-none");

                $("#register_confirm_password").addClass("is-invalid");
                $("#error_register_confirm_password").text("Passwords do not match!");
                $("#error_register_confirm_password").removeClass("d-none");
            } else {
                var formData = new FormData();

                formData.append('username', username);

                formData.append('action', 'check_username');

                $.ajax({
                    url: 'server',
                    data: formData,
                    type: 'POST',
                    dataType: 'JSON',
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response.success) {
                            const data = {
                                "name": name,
                                "username": username,
                                "password": password,
                            };

                            $("#check_admin_data").val(JSON.stringify(data));

                            $("#check_admin_modal").modal("show");
                        } else {
                            $("#register_username").addClass("is-invalid");
                            $("#error_register_username").text(response.message);
                            $("#error_register_username").removeClass("d-none");
                        }
                    },
                    error: function (_, _, error) {
                        console.error(error);
                    }
                });
            }
        }
    })

    $("#check_admin_form").submit(function () {
        const data = JSON.parse($("#check_admin_data").val());
        const name = data.name;
        const username = data.username;
        const password = data.password;

        const admin_username = $("#check_admin_username").val();
        const admin_password = $("#check_admin_password").val();

        $(".notification_alert").addClass("d-none");

        $("#check_admin_username").attr("disabled", true);
        $("#check_admin_password").attr("disabled", true);

        $("#check_admin_submit").attr("disabled", true);
        $("#check_admin_submit").text("Please Wait..");

        var formData = new FormData();

        formData.append('username', admin_username);
        formData.append('password', admin_password);

        formData.append('action', 'check_admin');

        $.ajax({
            url: 'server',
            data: formData,
            type: 'POST',
            dataType: 'JSON',
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.success) {
                    var formData = new FormData();

                    formData.append('name', name);
                    formData.append('username', username);
                    formData.append('password', password);

                    formData.append('action', 'register');

                    $.ajax({
                        url: 'server',
                        data: formData,
                        type: 'POST',
                        dataType: 'JSON',
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            if (response.success) {
                                $("#register_name").val("");
                                $("#register_username").val("");
                                $("#register_password").val("");
                                $("#register_confirm_password").val("");

                                $("#login_notification").text("A new account has been saved successfully!");
                                $("#login_notification").addClass("alert-success");
                                $("#login_notification").removeClass("d-none");

                                $(".notification_alert").addClass("d-none");

                                $("#check_admin_username").removeAttr("disabled");
                                $("#check_admin_password").removeAttr("disabled");
                                
                                $("#check_admin_username").val("");
                                $("#check_admin_password").val("");

                                $("#check_admin_submit").removeAttr("disabled");
                                $("#check_admin_submit").text("Submit");

                                $("#check_admin_modal").modal("hide");
                            }
                        },
                        error: function (_, _, error) {
                            console.error(error);
                        }
                    });
                } else {
                    $(".notification_alert").removeClass("d-none");

                    $("#check_admin_username").removeAttr("disabled");
                    $("#check_admin_password").removeAttr("disabled");

                    $("#check_admin_submit").removeAttr("disabled");
                    $("#check_admin_submit").text("Submit");
                }
            },
            error: function (_, _, error) {
                console.error(error);
            }
        });
    })

    $("#register_name").keydown(function () {
        $("#register_name").removeClass("is-invalid");
        $("#error_register_name").addClass("d-none");
    })

    $("#register_username").keydown(function () {
        $("#register_username").removeClass("is-invalid");
        $("#error_register_username").addClass("d-none");
    })

    $("#register_password").keydown(function () {
        $("#register_password").removeClass("is-invalid");
        $("#register_confirm_password").removeClass("is-invalid");
        $("#error_register_password").addClass("d-none");
        $("#error_register_confirm_password").addClass("d-none");
    })

    $("#register_confirm_password").keydown(function () {
        $("#register_password").removeClass("is-invalid");
        $("#register_confirm_password").removeClass("is-invalid");
        $("#error_register_password").addClass("d-none");
        $("#error_register_confirm_password").addClass("d-none");
    })
})
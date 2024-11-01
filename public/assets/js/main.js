jQuery(document).ready(function () {
    if (notification) {
        Swal.fire({
            title: notification.title,
            text: notification.text,
            icon: notification.icon
        });
    }

    $(".logout").click(function () {
        var formData = new FormData();

        formData.append('action', 'logout');

        $.ajax({
            url: 'server',
            data: formData,
            type: 'POST',
            dataType: 'JSON',
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.success) {
                    location.href = "/";
                }
            },
            error: function (_, _, error) {
                console.error(error);
            }
        });
    })

    $(".about_us").click(function () {
        $("#about_us_modal").modal("show");
    })
    
    $(".backup").click(function () {
        var formData = new FormData();
        
        formData.append('action', 'backup_database');
        
        $.ajax({
            url: 'server',
            data: formData,
            type: 'POST',
            dataType: 'JSON',
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success){
                    location.reload();
                }
            },
            error: function(_, _, error) {
                console.error(error);
            }
        });
    })

    $(".account_settings").click(function () {
        $(".main-form").addClass("d-none");
        $(".loading").removeClass("d-none");

        $("#account_settings_modal").modal("show");

        var formData = new FormData();

        formData.append('id', user_id);

        formData.append('action', 'get_user_data');

        $.ajax({
            url: 'server',
            data: formData,
            type: 'POST',
            dataType: 'JSON',
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.success) {
                    const name = response.message.name;
                    const username = response.message.username;
                    const password = response.message.password;

                    $("#account_settings_name").val(name);
                    $("#account_settings_username").val(username);
                    $("#account_settings_old_password").val(password);

                    $(".main-form").removeClass("d-none");
                    $(".loading").addClass("d-none");
                }
            },
            error: function (_, _, error) {
                console.error(error);
            }
        });
    })

    $("#account_settings_form").submit(function () {
        const id = user_id;
        const name = $("#account_settings_name").val();
        const username = $("#account_settings_username").val();
        const password = $("#account_settings_password").val();
        const old_password = $("#account_settings_old_password").val();

        $(".main-form").addClass("d-none");
        $(".loading").removeClass("d-none");

        $("#notification_alert").addClass("d-none");

        $("#account_settings_submit").attr("disabled", true);

        var formData = new FormData();

        formData.append('id', id);
        formData.append('name', name);
        formData.append('username', username);
        formData.append('password', password);
        formData.append('old_password', old_password);

        formData.append('action', 'update_user_account');

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
                    $("#account_settings_submit").removeAttr("disabled");
                    $("#account_settings_username").addClass("is-invalid");
                    $("#notification_alert").removeClass("d-none");

                    $(".main-form").removeClass("d-none");
                    $(".loading").addClass("d-none");
                }
            },
            error: function (_, _, error) {
                console.error(error);
            }
        });
    })

    $("#account_settings_username").keydown(function () {
        $("#account_settings_username").removeClass("is-invalid");
    })
})
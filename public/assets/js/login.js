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
                    console.log(response);
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
})
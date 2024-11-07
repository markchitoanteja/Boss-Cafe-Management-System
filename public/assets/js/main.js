jQuery(document).ready(function () {
    if (notification) {
        Swal.fire({
            title: notification.title,
            text: notification.text,
            icon: notification.icon
        });
    }

    $(".not_allowed").click(function () {
        Swal.fire({
            title: "Oops...",
            text: "Operation not allowed for non-admin users!",
            icon: "error"
        });
    })

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
        Swal.fire({
            title: "Confirm Backup",
            text: "A backup of the current database will be created as an SQL file. Do you want to proceed?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, create backup",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                var formData = new FormData();

                formData.append('action', 'backup_database');

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
                        }
                    },
                    error: function (_, _, error) {
                        console.error(error);
                    }
                });
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

        $(".notification_alert").addClass("d-none");

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
                    $(".notification_alert").removeClass("d-none");

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

    $("#new_item_form").submit(function () {
        const name = $("#new_item_name").val();
        const category = $("#new_item_category").val();
        const price = $("#new_item_price").val();
        const status = $("#new_item_status").val();

        $(".main-form").addClass("d-none");
        $(".loading").removeClass("d-none");

        $(".notification_alert").addClass("d-none");

        $("#new_item_submit").attr("disabled", true);

        var formData = new FormData();

        formData.append('name', name);
        formData.append('category', category);
        formData.append('price', price);
        formData.append('status', status);

        formData.append('action', 'new_item');

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
                    $(".notification_alert").removeClass("d-none");
                    $("#new_item_name").addClass("is-invalid");

                    $(".main-form").removeClass("d-none");
                    $(".loading").addClass("d-none");

                    $("#new_item_submit").removeAttr("disabled");
                }
            },
            error: function (_, _, error) {
                console.error(error);
            }
        });
    })

    $("#new_item_name").keydown(function () {
        $("#new_item_name").removeClass("is-invalid");
    })

    $(document).on("click", ".update_item", function () {
        const id = $(this).attr("item_id");

        $("#update_item_modal").modal("show");

        $(".main-form").addClass("d-none");
        $(".loading").removeClass("d-none");

        $(".notification_alert").addClass("d-none");

        var formData = new FormData();

        formData.append('id', id);

        formData.append('action', 'get_item_data');

        $.ajax({
            url: 'server',
            data: formData,
            type: 'POST',
            dataType: 'JSON',
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.success) {
                    $("#update_item_id").val(response.message.id);
                    $("#update_item_name").val(response.message.name);
                    $("#update_item_category").val(response.message.category);
                    $("#update_item_price").val(response.message.price);
                    $("#update_item_status").val(response.message.status);

                    $(".main-form").removeClass("d-none");
                    $(".loading").addClass("d-none");
                }
            },
            error: function (_, _, error) {
                console.error(error);
            }
        });
    })

    $(document).on("click", ".delete_item", function () {
        const id = $(this).attr("item_id");

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                var formData = new FormData();

                formData.append('id', id);

                formData.append('action', 'delete_item');

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
                        }
                    },
                    error: function (_, _, error) {
                        console.error(error);
                    }
                });
            }
        });
    })

    $("#update_item_form").submit(function () {
        const id = $("#update_item_id").val();
        const name = $("#update_item_name").val();
        const category = $("#update_item_category").val();
        const price = $("#update_item_price").val();
        const status = $("#update_item_status").val();

        $(".main-form").addClass("d-none");
        $(".loading").removeClass("d-none");

        $(".notification_alert").addClass("d-none");

        $("#update_item_submit").attr("disabled", true);

        var formData = new FormData();

        formData.append('id', id);
        formData.append('name', name);
        formData.append('category', category);
        formData.append('price', price);
        formData.append('status', status);

        formData.append('action', 'update_item');

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
                    $(".notification_alert").removeClass("d-none");
                    $("#update_item_name").addClass("is-invalid");

                    $(".main-form").removeClass("d-none");
                    $(".loading").addClass("d-none");

                    $("#update_item_submit").removeAttr("disabled");
                }
            },
            error: function (_, _, error) {
                console.error(error);
            }
        });
    })

    $("#update_item_name").keydown(function () {
        $("#update_item_name").removeClass("is-invalid");
    })

    $(document).on("click", ".update_inventory", function () {
        const item_id = $(this).attr("item_id");
        const name = $(this).attr("item_name");
        const category = $(this).attr("item_category");

        $("#update_inventory_modal").modal("show");

        $(".main-form").addClass("d-none");
        $(".loading").removeClass("d-none");

        $(".notification_alert").addClass("d-none");

        var formData = new FormData();

        formData.append('item_id', item_id);

        formData.append('action', 'get_inventory_data');

        $.ajax({
            url: 'server',
            data: formData,
            type: 'POST',
            dataType: 'JSON',
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.success) {
                    $("#update_inventory_item_id").val(response.message.item_id);
                    $("#update_inventory_name").text(name);
                    $("#update_inventory_category").text(category);
                    $("#update_inventory_stock_level").val(response.message.stock_level);
                    $("#update_inventory_unit").val(response.message.unit);

                    $(".main-form").removeClass("d-none");
                    $(".loading").addClass("d-none");
                }
            },
            error: function (_, _, error) {
                console.error(error);
            }
        });
    })

    $("#update_inventory_form").submit(function () {
        const item_id = $("#update_inventory_item_id").val();
        const stock_level = $("#update_inventory_stock_level").val();
        const unit = $("#update_inventory_unit").val();

        if (stock_level < 0) {
            $("#update_inventory_stock_level").addClass("is-invalid");
            $(".notification_alert").removeClass("d-none");
        } else {
            $(".main-form").addClass("d-none");
            $(".loading").removeClass("d-none");

            $(".notification_alert").addClass("d-none");

            $("#update_inventory_submit").attr("disabled", true);

            var formData = new FormData();

            formData.append('item_id', item_id);
            formData.append('stock_level', stock_level);
            formData.append('unit', unit);

            formData.append('action', 'update_inventory');

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
                    }
                },
                error: function (_, _, error) {
                    console.error(error);
                }
            });
        }
    })

    $("#update_inventory_stock_level").keydown(function () {
        $("#update_inventory_stock_level").removeClass("is-invalid");
    })

    $("#new_order_form").submit(function () {
        const staff_id = $("#new_order_staff_id").val();
        const customer_name = $("#new_order_customer_name").val();
        const item_id = $("#new_order_item_id").val();
        const quantity = $("#new_order_quantity").val();

        $(".main-form").addClass("d-none");
        $(".loading").removeClass("d-none");

        $(".notification_alert").addClass("d-none");

        $("#new_order_submit").attr("disabled", true);

        var formData = new FormData();

        formData.append('staff_id', staff_id);
        formData.append('customer_name', customer_name);
        formData.append('item_id', item_id);
        formData.append('quantity', quantity);

        formData.append('action', 'new_order');

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
                }
            },
            error: function (_, _, error) {
                console.error(error);
            }
        });
    })

    $(document).on("click", ".restore_backup", function () {
        var backup_file = $(this).data("filename");

        Swal.fire({
            title: "Confirm Restore",
            text: "You are about to restore the database to the selected point: " + backup_file + ". Do you want to proceed?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, restore",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                var formData = new FormData();

                formData.append('backup_file', backup_file);

                formData.append('action', 'restore_database');

                $.ajax({
                    url: 'server',
                    data: formData,
                    type: 'POST',
                    dataType: 'JSON',
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        location.reload();
                    },
                    error: function (_, _, error) {
                        console.error("AJAX Error: ", error);
                    }
                });
            }
        });
    })

    $(document).on("click", ".update_order", function () {
        const order_id = $(this).attr("order_id");

        $("#check_admin_order_id").val(order_id);

        $("#check_admin_modal").modal("show");
    })

    $("#check_admin_form").submit(function () {
        const order_id = $("#check_admin_order_id").val();
        const username = $("#check_admin_username").val();
        const password = $("#check_admin_password").val();

        $(".main-form").addClass("d-none");
        $(".loading").removeClass("d-none");

        $(".notification_alert").addClass("d-none");

        $("#check_admin_submit").attr("disabled", true);

        var formData = new FormData();

        formData.append('username', username);
        formData.append('password', password);

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
                    $("#check_admin_modal").modal("hide");

                    $("#update_order_modal").modal("show");

                    $(".main-form").addClass("d-none");
                    $(".loading").removeClass("d-none");

                    $(".notification_alert").addClass("d-none");

                    var formData = new FormData();

                    formData.append('order_id', order_id);

                    formData.append('action', 'get_order_data');

                    $.ajax({
                        url: 'server',
                        data: formData,
                        type: 'POST',
                        dataType: 'JSON',
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            $("#update_order_id").val(response.message.id);
                            $("#update_order_customer_name").val(response.message.customer_name);
                            $("#update_order_item_id").val(response.message.item_id);
                            $("#update_order_quantity").val(response.message.quantity);
                            $("#update_order_status").val(response.message.status);

                            $(".main-form").removeClass("d-none");
                            $(".loading").addClass("d-none");
                        },
                        error: function (_, _, error) {
                            console.error(error);
                        }
                    });
                } else {
                    $(".notification_alert").removeClass("d-none");

                    $("#check_admin_submit").removeAttr("disabled");

                    $(".main-form").removeClass("d-none");
                    $(".loading").addClass("d-none");
                }
            },
            error: function (_, _, error) {
                console.error(error);
            }
        });
    })

    $("#update_order_form").submit(function () {
        const id = $("#update_order_id").val();
        const customer_name = $("#update_order_customer_name").val();
        const item_id = $("#update_order_item_id").val();
        const quantity = $("#update_order_quantity").val();
        const status = $("#update_order_status").val();

        $(".main-form").addClass("d-none");
        $(".loading").removeClass("d-none");

        $(".notification_alert").addClass("d-none");

        $("#update_order_submit").attr("disabled", true);

        var formData = new FormData();

        formData.append('id', id);
        formData.append('customer_name', customer_name);
        formData.append('item_id', item_id);
        formData.append('quantity', quantity);
        formData.append('status', status);

        formData.append('action', 'update_order');

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
                }
            },
            error: function (_, _, error) {
                console.error(error);
            }
        });
    })

    $("#export_as_pdf").click(function () {
        const { jsPDF } = window.jspdf;

        let element = document.querySelector('.right_col');

        html2canvas(element).then((canvas) => {
            const pdf = new jsPDF("p", "mm", "a4");
            const imgData = canvas.toDataURL("image/png");
            const pdfWidth = pdf.internal.pageSize.getWidth();
            const pdfHeight = (canvas.height * pdfWidth) / canvas.width;

            pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
            pdf.save("Sales_Report.pdf");
        });
    })

    $("#print_report").click(function () {
        const { jsPDF } = window.jspdf;

        let element = document.querySelector('.right_col');

        html2canvas(element).then((canvas) => {
            let imgData = canvas.toDataURL("image/png");

            let printWindow = window.open('', '_blank');
            
            printWindow.document.write('<html><head><title>Print</title></head><body>');
            printWindow.document.write('<img src="' + imgData + '" style="width:100%;">');
            printWindow.document.write('</body></html>');
            printWindow.document.close();

            printWindow.onload = function () {
                printWindow.print();
                printWindow.close();
            };
        });
    })
})
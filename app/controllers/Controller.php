<?php
class Controller
{
    private $database;

    public function __construct()
    {
        $this->database = new Database();

        $this->handleRequest();
    }

    private function handleRequest()
    {
        $action = post("action") ?? null;

        if (method_exists($this, $action)) {
            $this->$action();
        } else {
            $this->response(false, "Action do not exists!");
        }
    }

    private function login()
    {
        $username = post("username");
        $password = post("password");

        $user_data = $this->database->select_one("users", ["username" => $username]);

        $success = false;

        if ($user_data) {
            $db_password = $user_data["password"];

            if (password_verify($password, $db_password)) {
                session("user_id", $user_data["id"]);
                session("user_type", $user_data["user_type"]);

                $success = true;
            }
        }

        $this->response($success);
    }

    private function check_username()
    {
        $username = post("username");

        $success = false;
        $message = "Username is already in use!";

        $is_username_exists = $this->database->select_one("users", ["username" => $username]);

        if (!$is_username_exists) {
            $success = true;
        }

        $this->response($success, $message);
    }

    private function register()
    {
        $name = post("name");
        $username = post("username");
        $password = post("password");
        
        $success = false;
        
        $data = [
            "uuid" => $this->database->generate_uuid(),
            "name" => $name,
            "username" => $username,
            "password" => password_hash($password, PASSWORD_BCRYPT),
            "image" => "default-user-image.png",
            "user_type" => "employee",
            "created_at" => date("Y-m-d H:i:s"),
            "updated_at" => date("Y-m-d H:i:s"),
        ];

        $this->database->insert("users", $data);

        $success = true;
        
        $this->response($success);
    }

    private function get_user_data()
    {
        $id = post("id");

        $user_data = $this->database->select_one("users", ["id" => $id]);

        $this->response(true, $user_data);
    }

    private function update_user_account()
    {
        $id = post("id");
        $name = post("name");
        $username = post("username");
        $password = post("password");
        $old_password = post("old_password");

        $success = false;

        if ($password) {
            $password = password_hash($password, PASSWORD_BCRYPT);
        } else {
            $password = $old_password;
        }

        $data = [
            "name" => $name,
            "username" => $username,
            "password" => $password,
            "updated_at" => date("Y-m-d H:i:s"),
        ];

        $update_success = $this->database->update("users", $data, ["id" => $id]);

        if ($update_success) {
            $notification_message = [
                "title" => "Success!",
                "text" => "Your account has been successfully updated.",
                "icon" => "success",
            ];

            session("notification", $notification_message);

            $success = true;
        }

        $this->response($success);
    }

    private function backup_database()
    {
        $backup = $this->database->backup("backup");

        if ($backup) {
            $notification_message = [
                "title" => "Success!",
                "text" => "Database backup was successful.",
                "icon" => "success",
            ];

            session("notification", $notification_message);
        }

        $this->response(true);
    }

    private function new_item()
    {
        $name = post("name");
        $category = post("category");
        $price = post("price");
        $status = post("status");

        $success = false;

        $item_data = [
            "uuid" => $this->database->generate_uuid(),
            "name" => $name,
            "category" => $category,
            "price" => $price,
            "status" => $status,
            "created_at" => date("Y-m-d H:i:s"),
            "updated_at" => date("Y-m-d H:i:s"),
        ];

        $new_item_success = $this->database->insert("items", $item_data);

        if ($new_item_success) {
            $item_id = $this->database->get_last_insert_id();

            $inventory_data = [
                "uuid" => $this->database->generate_uuid(),
                "item_id" => $item_id,
                "stock_level" => 0,
                "unit" => "kg",
                "created_at" => date("Y-m-d H:i:s"),
                "updated_at" => date("Y-m-d H:i:s"),
            ];

            $new_inventory_success = $this->database->insert("inventories", $inventory_data);

            if ($new_inventory_success) {
                $notification_message = [
                    "title" => "Success!",
                    "text" => "A new item was added successfully.",
                    "icon" => "success",
                ];

                session("notification", $notification_message);

                $success = true;
            }
        }

        $this->response($success);
    }

    private function update_item()
    {
        $id = post("id");
        $name = post("name");
        $category = post("category");
        $price = post("price");
        $status = post("status");

        $success = false;

        $data = [
            "name" => $name,
            "category" => $category,
            "price" => $price,
            "status" => $status,
            "updated_at" => date("Y-m-d H:i:s"),
        ];

        $update_item_success = $this->database->update("items", $data, ["id" => $id]);

        if ($update_item_success) {
            $notification_message = [
                "title" => "Success!",
                "text" => "An item was updated successfully.",
                "icon" => "success",
            ];

            session("notification", $notification_message);

            $success = true;
        }

        $this->response($success);
    }

    private function get_item_data()
    {
        $id = post("id");

        $success = true;

        $item_data = $this->database->select_one("items", ["id" => $id]);

        $this->response($success, $item_data);
    }

    private function get_inventory_data()
    {
        $item_id = post("item_id");

        $success = true;

        $item_data = $this->database->select_one("inventories", ["item_id" => $item_id]);

        $this->response($success, $item_data);
    }

    private function delete_item()
    {
        $id = post("id");

        $success = false;

        if ($this->database->delete("items", ["id" => $id]) && $this->database->delete("inventories", ["item_id" => $id])) {
            $notification_message = [
                "title" => "Success!",
                "text" => "An item was deleted successfully.",
                "icon" => "success",
            ];

            session("notification", $notification_message);

            $success = true;
        }

        $this->response($success);
    }

    private function update_inventory()
    {
        $item_id = post("item_id");
        $stock_level = post("stock_level");
        $unit = post("unit");

        $success = false;

        $data = [
            "stock_level" => $stock_level,
            "unit" => $unit,
            "updated_at" => date("Y-m-d H:i:s"),
        ];

        $update_inventory_success = $this->database->update("inventories", $data, ["item_id" => $item_id]);

        if ($update_inventory_success) {
            $notification_message = [
                "title" => "Success!",
                "text" => "An inventory was updated successfully.",
                "icon" => "success",
            ];

            session("notification", $notification_message);

            $success = true;
        }

        $this->response($success);
    }

    private function new_order()
    {
        $staff_id = post("staff_id");
        $customer_name = post("customer_name");
        $item_id = post("item_id");
        $quantity = post("quantity");

        $success = false;

        $item_price = $this->database->select_one("items", ["id" => $item_id])["price"];

        $total_price = $item_price * $quantity;

        $data = [
            "uuid" => $this->database->generate_uuid(),
            "staff_id" => $staff_id,
            "customer_name" => $customer_name,
            "item_id" => $item_id,
            "quantity" => $quantity,
            "total_price" => $total_price,
            "status" => "Completed",
            "created_at" => date("Y-m-d H:i:s"),
            "updated_at" => date("Y-m-d H:i:s"),
        ];

        $new_order_success = $this->database->insert("orders", $data);

        if ($new_order_success) {
            $notification_message = [
                "title" => "Success!",
                "text" => "Order was placed successfully.",
                "icon" => "success",
            ];

            session("notification", $notification_message);

            $success = true;
        }

        $this->response($success);
    }

    private function restore_database()
    {
        $backup_file = basename(post("backup_file"));
        $backup_dir = 'backup/';
        $file_path = $backup_dir . $backup_file;

        if (!file_exists($file_path)) {
            $notification_message = [
                "title" => "Oops..",
                "text" => "The backup file does not exists!",
                "icon" => "error",
            ];
        } else {
            if ($this->database->restore($file_path)) {
                $notification_message = [
                    "title" => "Success!",
                    "text" => "Database restored successfully from $backup_file.",
                    "icon" => "success",
                ];
            } else {
                $notification_message = [
                    "title" => "Oops..",
                    "text" => "There was an error while processing your request.",
                    "icon" => "error",
                ];
            }
        }

        session("notification", $notification_message);

        $this->response(true);
    }

    private function get_order_data()
    {
        $order_id = post("order_id");

        $success = true;

        $order_data = $this->database->select_one("orders", ["id" => $order_id]);

        $this->response($success, $order_data);
    }

    private function check_admin()
    {
        $username = post("username");
        $password = post("password");

        $success = false;

        $admin_data = $this->database->select_one("users", ["username" => $username]);

        if ($admin_data) {
            $db_password = $admin_data["password"];

            if (password_verify($password, $db_password)) {
                $success = true;
            }
        }

        $this->response($success);
    }

    private function update_order()
    {
        $id = post("id");
        $customer_name = post("customer_name");
        $item_id = post("item_id");
        $quantity = post("quantity");
        $status = post("status");

        $success = false;

        $data = [
            "customer_name" => $customer_name,
            "item_id" => $item_id,
            "quantity" => $quantity,
            "status" => $status,
            "updated_at" => date("Y-m-d H:i:s"),
        ];

        if ($this->database->update("orders", $data, ["id" => $id])) {
            $notification_message = [
                "title" => "Success!",
                "text" => "An order was updated successfully!",
                "icon" => "success",
            ];

            session("notification", $notification_message);

            $success = true;
        }

        $this->response($success);
    }

    private function logout()
    {
        $notification_message = [
            "type" => "alert-success",
            "message" => "You have been logged out.",
        ];

        session("notification", $notification_message);

        session("user_id", "unset");

        $this->response(true, null);
    }

    private function response(bool $success, $message = null)
    {
        echo json_encode(['success' => $success, 'message' => $message]);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    new Controller();
} else {
    http_response_code(500);

    header("location: 500");

    exit();
}

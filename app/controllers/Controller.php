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
        $admin_password = post("admin_password");
        $name = post("name");
        $username = post("username");
        $password = post("password");

        $hash = $this->database->select_one("users", ["id", "1"])["password"];

        $success = false;
        $message = "Invalid administrator password!";

        if (password_verify($admin_password, $hash)) {
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
            $message = "A new account has been saved successfully!";
        }

        $this->response($success, $message);
    }

    private function get_user_data()
    {
        $id = post("id");

        $user_data = $this->database->select_one("users", ["id", $id]);

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

        $data = [
            "uuid" => $this->database->generate_uuid(),
            "name" => $name,
            "category" => $category,
            "price" => $price,
            "status" => $status,
            "created_at" => date("Y-m-d H:i:s"),
            "updated_at" => date("Y-m-d H:i:s"),
        ];

        $new_item_success = $this->database->insert("items", $data);

        if ($new_item_success) {
            $notification_message = [
                "title" => "Success!",
                "text" => "A new item was added successfully.",
                "icon" => "success",
            ];

            session("notification", $notification_message);

            $success = true;
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

    private function delete_item()
    {
        $id = post("id");

        $success = false;

        if ($this->database->delete("items", ["id" => $id])) {
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

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
        $action = $_POST['action'] ?? null;

        if (method_exists($this, $action)) {
            $this->$action();
        } else {
            $this->response(false, "Action do not exists!");
        }
    }

    private function login()
    {
        $username = $_POST["username"];

        $user_data = $this->database->select_one("users", ["username" => $username]);

        if ($user_data) {
            $user_data = $user_data;
        } else {
            $user_data = null;
        }

        $this->response(true, ["User Data" => $user_data]);
    }

    private function register()
    {
        $this->response(true);
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

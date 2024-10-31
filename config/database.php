<?php
class Database
{
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $database_name = 'boss_cafe_management_system';
    private $connection;

    public function __construct()
    {
        $this->connect();
    }

    /**
     * Establishes a database connection and creates the database if it doesn't exist.
     *
     * @return mysqli The established MySQLi connection.
     */
    public function connect()
    {
        $this->connection = new mysqli($this->host, $this->username, $this->password);

        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }

        if ($this->create_database()) {
            $this->connection->select_db($this->database_name);
        } else {
            die("Database Error");
        }

        return $this->connection;
    }

    private function create_database()
    {
        $sql = "CREATE DATABASE IF NOT EXISTS " . $this->database_name;

        if (!$this->connection->query($sql) === TRUE) {
            return false;
        }

        return true;
    }

    /**
     * Determines the parameter types for a prepared statement based on the data provided.
     *
     * @param array $data An associative array of column-value pairs where values are used to determine types.
     * @return string A string of type specifiers ('i' for integer, 'd' for double, 's' for string) corresponding to each value in $data.
     */
    private function get_param_types(array $data)
    {
        return implode('', array_map(function ($value) {
            return is_int($value) ? 'i' : (is_double($value) ? 'd' : 's');
        }, $data));
    }

    /**
     * Retrieves the ID of the most recently inserted row.
     *
     * @return int The ID of the last inserted row in the database.
     */
    public function get_last_insert_id()
    {
        return $this->connection->insert_id;
    }

    /**
     * Selects a single record from a database table with multiple conditions.
     *
     * @param string $table The name of the table to query.
     * @param array $conditions Associative array of conditions where keys are column names and values are the column values to match.
     * @param string $operator Logical operator to use between conditions ("AND" or "OR"). Default is "AND".
     * @return array|null The result as an associative array, or null if no match is found.
     */
    public function select_one($table, $conditions, $operator = "AND")
    {
        $sql = "SELECT * FROM $table WHERE ";
        $conditionStrings = [];
        $params = [];
        $types = "";

        foreach ($conditions as $column => $value) {
            $conditionStrings[] = "$column = ?";
            $params[] = $value;
            $types .= "s";
        }

        $sql .= implode(" $operator ", $conditionStrings) . " LIMIT 1";

        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();
    }

    /**
     * Inserts a new record into a specified database table.
     *
     * @param string $table The name of the table where the data will be inserted.
     * @param array $data Associative array of column-value pairs to insert, where keys are column names and values are the values to insert.
     * @return bool Returns true if the record was successfully inserted, false otherwise.
     */
    public function insert($table, array $data)
    {
        try {
            $columns = implode(", ", array_keys($data));
            $placeholders = implode(", ", array_fill(0, count($data), "?"));

            $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
            $stmt = $this->connection->prepare($sql);

            $types = $this->get_param_types($data);
            $values = array_values($data);

            if ($stmt->bind_param($types, ...$values) && $stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (mysqli_sql_exception $e) {
            return false;
        }
    }
}

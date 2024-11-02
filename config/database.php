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

    private function create_database()
    {
        $sql = "CREATE DATABASE IF NOT EXISTS " . $this->database_name;

        if (!$this->connection->query($sql) === TRUE) {
            return false;
        }

        return true;
    }

    /**
     * Generate a unique UUID.
     *
     * @return string A 32-character hexadecimal UUID.
     */
    public function generate_uuid()
    {
        return bin2hex(random_bytes(16));
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

    /**
     * Backs up the entire database to an SQL file.
     *
     * @param string|null $backupDir Directory to save the backup file. Defaults to the current directory.
     * @return string|bool The path to the backup file if successful, or false on failure.
     */
    public function backup($backupDir = null)
    {
        $backupDir = $backupDir ?? __DIR__;
        $backupFile = $backupDir . '/backup_' . $this->database_name . '_' . date("Y-m-d_H-i-s") . '.sql';

        try {
            $tables = [];
            $result = $this->connection->query("SHOW TABLES");

            if (!$result) {
                throw new Exception("Error retrieving tables: " . $this->connection->error);
            }

            while ($row = $result->fetch_row()) {
                $tables[] = $row[0];
            }

            $sqlDump = "-- Database Backup\n-- Database: {$this->database_name}\n-- Date: " . date("Y-m-d H:i:s") . "\n\n";

            foreach ($tables as $table) {
                $tableCreate = $this->connection->query("SHOW CREATE TABLE `$table`")->fetch_row()[1] . ";\n\n";
                $sqlDump .= "-- Structure for table `$table`\n";
                $sqlDump .= $tableCreate . "\n\n";

                $result = $this->connection->query("SELECT * FROM `$table`");

                if ($result->num_rows > 0) {
                    $sqlDump .= "-- Data for table `$table`\n";
                    while ($row = $result->fetch_assoc()) {
                        $values = array_map([$this->connection, 'real_escape_string'], array_values($row));
                        $values = "'" . implode("', '", $values) . "'";
                        $columns = implode("`, `", array_keys($row));
                        $sqlDump .= "INSERT INTO `$table` (`$columns`) VALUES ($values);\n";
                    }
                    $sqlDump .= "\n";
                }
            }

            if (file_put_contents($backupFile, $sqlDump) === false) {
                throw new Exception("Error writing backup file");
            }

            return $backupFile;
        } catch (Exception $e) {
            error_log("Backup Error: " . $e->getMessage());
            return false;
        }
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
     * Selects multiple records from a database table with multiple conditions and optional ordering.
     *
     * @param string $table The name of the table to query.
     * @param array $conditions Associative array of conditions where keys are column names and values are the column values to match.
     * @param string $operator Logical operator to use between conditions ("AND" or "OR"). Default is "AND".
     * @param string $orderBy Column to order by. Default is an empty string (no ordering).
     * @param string $orderDir Order direction, either "ASC" or "DESC". Default is "ASC".
     * @return array|null The result as an array of associative arrays, or null if no matches are found.
     */
    public function select_many($table, $conditions = [], $operator = "AND", $orderBy = "", $orderDir = "ASC")
    {
        $sql = "SELECT * FROM $table";
        $params = [];
        $types = "";

        if (!empty($conditions)) {
            $conditionStrings = [];
            foreach ($conditions as $column => $value) {
                $conditionStrings[] = "$column = ?";
                $params[] = $value;
                $types .= "s";
            }
            $sql .= " WHERE " . implode(" $operator ", $conditionStrings);
        }

        if (!empty($orderBy)) {
            $orderDir = strtoupper($orderDir) === "DESC" ? "DESC" : "ASC";
            $sql .= " ORDER BY $orderBy $orderDir";
        }

        $stmt = $this->connection->prepare($sql);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Selects all records from a database table with optional ordering.
     *
     * @param string $table The name of the table to query.
     * @param string $orderBy Column to order by. Default is an empty string (no ordering).
     * @param string $orderDir Order direction, either "ASC" or "DESC". Default is "ASC".
     * @return array|null The result as an array of associative arrays, or null if no records are found.
     */
    public function select_all($table, $orderBy = "", $orderDir = "ASC")
    {
        $sql = "SELECT * FROM $table";

        if (!empty($orderBy)) {
            $orderDir = strtoupper($orderDir) === "DESC" ? "DESC" : "ASC";
            $sql .= " ORDER BY $orderBy $orderDir";
        }

        $result = $this->connection->query($sql);

        return $result ? $result->fetch_all(MYSQLI_ASSOC) : null;
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

    /**
     * Updates a record in a specified database table with given data and conditions.
     *
     * @param string $table The name of the table to update.
     * @param array $data Associative array of column-value pairs to update.
     * @param array $conditions Associative array of conditions where keys are column names and values are the values to match.
     * @param string $operator Logical operator to use between conditions ("AND" or "OR"). Default is "AND".
     * @return bool Returns true if the query executed successfully, false otherwise.
     */
    public function update($table, array $data, array $conditions, $operator = "AND")
    {
        try {
            $setClauses = [];
            $params = [];
            $types = "";

            foreach ($data as $column => $value) {
                $setClauses[] = "$column = ?";
                $params[] = $value;
                $types .= "s";
            }

            $conditionClauses = [];
            foreach ($conditions as $column => $value) {
                $conditionClauses[] = "$column = ?";
                $params[] = $value;
                $types .= "s";
            }

            $setString = implode(", ", $setClauses);
            $conditionString = implode(" $operator ", $conditionClauses);
            $sql = "UPDATE $table SET $setString WHERE $conditionString";

            $stmt = $this->connection->prepare($sql);

            if ($stmt === false) {
                throw new Exception("SQL Preparation Error: " . $this->connection->error);
            }

            if ($stmt->bind_param($types, ...$params) && $stmt->execute()) {
                return true;
            } else {
                throw new Exception("Execution Error: " . $stmt->error);
            }
        } catch (Exception $e) {
            error_log("Update Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Deletes records from a specified database table based on given conditions.
     *
     * @param string $table The name of the table from which to delete records.
     * @param array $conditions Associative array of conditions where keys are column names and values are the column values to match.
     * @param string $operator Logical operator to use between conditions ("AND" or "OR"). Default is "AND".
     * @return bool Returns true if the record(s) were successfully deleted, false otherwise.
     */
    public function delete($table, array $conditions, $operator = "AND")
    {
        $sql = "DELETE FROM $table WHERE ";
        $conditionStrings = [];
        $params = [];
        $types = "";

        foreach ($conditions as $column => $value) {
            $conditionStrings[] = "$column = ?";
            $params[] = $value;
            $types .= "s";
        }

        $sql .= implode(" $operator ", $conditionStrings);

        $stmt = $this->connection->prepare($sql);
        
        if ($stmt === false) {
            throw new Exception("SQL Preparation Error: " . $this->connection->error);
        }

        if ($stmt->bind_param($types, ...$params) && $stmt->execute()) {
            return $stmt->affected_rows > 0;
        } else {
            error_log("Delete Error: " . $stmt->error);
            return false;
        }
    }
}

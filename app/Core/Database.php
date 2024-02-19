<?php
// https://cycle-orm.dev/docs/database-configuration/current/en
namespace App\Core;

use PDO;
use PDOException;

class Database
{
    protected $connection = null;
    public $connectionStatus;
    private $rowCount;

    private $querySuccess;



    
    private $where;
    private $whereParams;
    


    private $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    public function __construct()
    {
        try {
            $this->connection = new PDO(DB_DRIVE . ":host=" . DB_HOST . ";dbname=" . DB_DATABASE_NAME, DB_USERNAME, DB_PASSWORD, $this->options);
            $this->connection->exec("SET NAMES 'utf8'");
            $this->connectionStatus = $this->connection->getAttribute(PDO::ATTR_CONNECTION_STATUS);
        } catch (PDOException  $e) {
            redirect('503');
            // echo "Connection Error: " . $e->getMessage();
        }
    }

    public function query($query, $params = [], $debug = false)
    {

        try {
            if ($debug) {
                echo "Query: " . $query . PHP_EOL;
                echo "Params: " . print_r($params, true) . PHP_EOL;
            }

            if (!is_null($this->connection)) {
                $stmt = $this->connection->prepare($query);
                foreach ($params as $key => $value) {
                    $stmt->bindValue($key, $value);
                }
                $this->querySuccess = $stmt->execute();
                $this->rowCount = $stmt->rowCount();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            echo "Query Fail: " . $e->getMessage();
        }
    }

    public function columnNameByIndex($index, $tableName)
    {
        $resultArr = $this->query("SELECT column_name
        FROM information_schema.columns
        WHERE table_name = '{$tableName}' 
        AND ordinal_position = {$index}");


        if (isset($resultArr[0])) {
            return $resultArr[0]['column_name'];
        }
    }

    public function getRowCount()
    {
        return  $this->rowCount;
    }

    public function verifyQueryResult()
    {
        return $this->querySuccess;
    }

    public function lastInsertId()
    {
        return $this->connection->lastInsertId();
    }

    public function validateConnection()
    {
        if ($this->connection) {
            echo "Connection Success!";
        } else {
            echo "Connection Error!";
        }
    }

    public function create($table, $data)
    {
        try {
            $columns = implode(', ', array_keys($data));
            $values = implode(', :', array_keys($data));
    
            $query = "INSERT INTO $table ($columns) VALUES (:$values)";
    
            $this->query($query, $data);
    
            return $this->lastInsertId();
        } catch (PDOException $e) {
            echo "Create Fail: " . $e->getMessage();
            return false;
        }
    }
    
    public function read($table)
    {
        try {
            $query = "SELECT * FROM $table";
    
            return $this->query($query);
        } catch (PDOException $e) {
            echo "Read Fail: " . $e->getMessage();
            return false;
        }
    }

    public function where($params = []){
        $this->where = 'WHERE ';

    }
    
    public function update($table, $data, $conditions)
    {
        try {
            $updateData = implode(', ', array_map(function ($key) {
                return "$key = :$key";
            }, array_keys($data)));
    
            $query = "UPDATE $table SET $updateData";
    
            $this->query($query, $data, $conditions);
    
            return $this->querySuccess;
        } catch (PDOException $e) {
            echo "Update Fail: " . $e->getMessage();
            return false;
        }
    }
    
    public function delete($table, $conditions)
    {
        try {
            $query = "DELETE FROM $table";
    
            $this->query($query, [], $conditions);
    
            return $this->querySuccess;
        } catch (PDOException $e) {
            echo "Delete Fail: " . $e->getMessage();
            return false;
        }
    }
    
}

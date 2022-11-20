<?php

namespace App\Core;

use App\Database\Config;
use PDO;
use PDOException;

class Model
{
    protected $db;
    public    $_table;
    public    $_fk;

    public function __construct()
    {
        $db = Config::getSettings();
        extract($db);
        $this->db = new PDO("mysql:host=$host;dbname=$database", "$username", "$password", array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8MB4'));
        if (!$this->db) die('Error connecting to database');
    }

    /**
     * Insert into database
     *
     * @name insert
     * @access public
     * @param (array)$dados - Array with the data to insert into the table
     * @param (boolean)$where -Past condition for update
     * @return (int) returns an id with the inserted row
     * @version 1.0
     **/
    public function insert(array $dados, $debug = FALSE)
    {
        $fields = $this->getTableField();
        foreach ($dados as $ind => $val) {
            if (in_array($ind, $fields)) {
                $dadosBD[$ind] = $val;
            }
        }
        // DYNAMIC INSERT BASED ON DATA ARRAY
        $fields      =  implode(",", array_keys($dadosBD));
        $valores  =  ":" . implode(",:", array_keys($dadosBD));
        // DEBUG THE SQL STRING
        if ($debug) {
            $valoresDebug = "'" . implode("','", $dadosBD) . "'";
            $this->debug("INSERT INTO `{$this->_table}` ({$fields}) values ({$valoresDebug})");
        }
        //TRY TO INSERT THE DATA
        try {
            // PREPARE THE DATA FOR INSERT USING PREPARED STATEMENTS
            $statement = $this->db->prepare("INSERT INTO `{$this->_table}` ({$fields}) values ({$valores})");
            //PASS THE CORRECT VALUES BASED ON THE STRING PARAMETERS
            foreach ($dadosBD as $key => $value) {
                $statement->bindValue(":$key", $value);
            }
            // EXECUTE THE QUERY
            $executa = $statement->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $this->db->lastInsertId();
    }

    /**
     * query directed to current table
     *
     * @name read
     * @access public
     * @param (string)$where - Pass conditions if necessary
     * @param (string)$limit - sets the search limit
     * @param (string)$offset - sets the search offset
     * @param (string)$orderby - sets the order for the result
     * @param (boolean)$debug - prints the sql string
     * @version 1.0
     **/
    public function read($where = null, $limit = null, $offset = null, $orderby = null, $debug = FALSE)
    {
        $where    = ($where   != null ? "WHERE {$where}"      : "");
        $limit    = ($limit   != null ? "LIMIT {$limit}"       : "");
        $offset   = ($offset  != null ? "OFFSET {$offset}"       : "");
        $orderby  = ($orderby != null ? "ORDER BY {$orderby}" : "");
        if ($debug)
            $this->debug("SELECT * FROM `{$this->_table}` {$where} {$orderby} {$limit} {$offset}");
        $query = $this->db->prepare("SELECT * FROM `{$this->_table}` {$where} {$orderby} {$limit} {$offset}");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * query directed to current table with return of one line
     *
     * @name read
     * @access public
     * @param (string)$where - Pass conditions if needed
     * @param (string)$limit - sets the search limit
     * @param (string)$offset - sets the search offset
     * @param (string)$orderby - sets the order for the result
     * @param (boolean)$debug - prints the sql string
     * @version 1.0
     **/

    public function readLine($where = null, $limit = null, $offset = null, $orderby = null, $debug = FALSE)
    {
        $where    = ($where   != null ? "WHERE {$where}"      : "");
        if ($debug)
            $this->debug("SELECT * FROM `{$this->_table}` {$where}");
        $query = $this->db->prepare("SELECT * FROM `{$this->_table}` {$where}");
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * update table data
     *
     * @name update
     * @access public
     * @param (array)$data - Array with the new table data
     * @param (boolean)$where - Condition passed to update
     * @version 1.0
     **/

    public function update(array $dados, $where, $debug = FALSE)
    {
        $fields = $this->getTableField();
        foreach ($dados as $ind => $val) {
            if (in_array($ind, $fields)) {
                $campos[] = "{$ind} = :{$ind}";
                $dadosBD[$ind] = $val;
            }
        }
        $campos = implode(",", $campos);
        // DEBUG THE SQL STRING
        if ($debug) {
            foreach ($dadosBD as $key => $value) {
                $camposDebug[] = "$key = '$value'";
            }
            $camposDebug = implode(",", $camposDebug);
            $this->debug("UPDATE `{$this->_table}` SET {$camposDebug} WHERE {$where}");
        }
        try {
            // PREPARE THE DATA FOR INSERT USING PREPARED STATEMENTS
            $ps = $this->db->prepare("UPDATE `{$this->_table}` SET {$campos} WHERE {$where}");
            //PASS THE CORRECT VALUES BASED ON THE STRING PARAMETERS
            foreach ($dadosBD as $key => $value) {
                $ps->bindValue(":$key", $value);
            }
            // EXECUTE THE QUERY
            $executa = $ps->execute();
        } catch (PDOexception $e) {
            echo $e->getMessage();
        }
        return $ps->rowCount();
    }

    /**
     * Insert data into the database
     * @name delete
     * @access public
     * @param (boolean)$where - Condition passed for deletion
     * @return (int) returns the number of rows affected;
     * @version 1.0
     **/
    public function delete($where)
    {
        try {
            $ps = $this->db->prepare("DELETE FROM `{$this->_table}` WHERE {$where} ");
            $executa = $ps->execute();
        } catch (PDOexception $e) {
            echo $e->getMessage();
        }
        return $ps->rowCount();
    }

    /**
     * Returns the name of the table fields in the database
     *
     * @name getTableField
     * @access private
     * @version 1.0
     **/
    private function getTableField()
    {
        $fields = array();
        $result = $this->db->query("DESCRIBE `{$this->_table}`")->fetchAll();
        foreach ($result as $r) {
            array_push($fields, $r['Field']);
        }
        return $fields;
    }

    /**
     * Returns a custom SQL query
     * @name consult
     * @access public
     * @param (string)$sql - SQL command to execute
     * @param (boolean)$debug - Whether to debug the command. By default it is FALSE
     * @version 1.0
     **/
    public function consult($sql, $debug = FALSE)
    {
        if ($debug) $this->debug($sql);
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * consult one line
     * returns the first row of the query
     *
     * @access public
     * @param (string)$sql - SQL command to execute
     * @param (boolean)$debug - Whether to debug the command. By default it is FALSE
     * @return (array)$result - Array with the results of the first line of the SQL query
     * @version 11.1.11
     **/
    public function oneLineConsult($sql, $debug = FALSE)
    {
        if ($debug) $this->debug($sql);
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * query a single value
     * This method returns the first column of the first row of a query result
     * @name consultValue
     * @access public
     * @param (string)$sql - SQL command to execute
     * @param (boolean)$debug - Whether to debug the command. By default it is FALSE
     * @return (?) Value of the first column of the first row of the query result
     * @version 11.1.11
     **/

    public function consultValue($sql, $debug = FALSE)
    {
        $resultado = $this->oneLineConsult($sql, $debug);
        if (is_array($resultado)) {
            return array_shift($resultado);
        } else {
            return FALSE;
        }
    }

    /**
     * Fetch data from a related table via foreign key
     * @name populateFK
     * @access public
     * @return (array) returns an array of data for each related table
     **/
    public function populateFK()
    {
        foreach ($this->fk as $key => $value) {
            $order = (isset($this->orderby[$key])) ? "ORDER BY " . $this->orderby[$key] : "";
            $dados[$key] = $this->consult("SELECT * FROM `{$key}` {$order}");
        }
        return $dados;
    }

    /**
     * Private debug method of SQL commands
     * @name debug
     * @access private
     * @param (string)$sql - SQL command to be debugged
     * @return void
     * @version 1
     **/
    private function debug($sql)
    {
        echo "<hr/><pre>$sql</pre><hr/>";
    }
}

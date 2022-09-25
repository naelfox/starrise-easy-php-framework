<?php
class Model
{
    protected $db;
    public    $_table;
    public    $_fk;

    public function __construct()
    {
        $database = array(
            'host' => 'host',
            'login' => 'login',
            'senha' => 'pass',
            'banco' => 'banco de dados',
        );
        extract($database);
        // $this -> db = new PDO("mysql:host=$host;dbname=$banco", "$login", "$senha", array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'));
        $this->db = new PDO("mysql:host=$host;dbname=$banco", "$login", "$senha", array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8MB4'));
        if (!$this->db) die('Erro ao conectar ao banco de dado');
    }

    /**
     * Insert into database
     *
     * @name insert
     * @access public
     * @param (array)$dados - Array com os dados para inserir na table
     * @param (boolean)$where - Condição passada para atualização
     * @return (int) retorna a id da linha inserida;
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
        //INSERT DINAMICO BASEADO EM ARRAY DE DADOS
        $campos      =  implode(",", array_keys($dadosBD));
        $valores  =  ":" . implode(",:", array_keys($dadosBD));
        //FAZ O DEBUG DA STRING SQL
        if ($debug) {
            $valoresDebug = "'" . implode("','", $dadosBD) . "'";
            $this->debug("INSERT INTO `{$this->_table}` ({$campos}) values ({$valoresDebug})");
        }
        //TENTA INSERIR OS DADOS
        try {
            //PREPARA OS DADOS PARA INSERT USANDO PREPARED STATEMENTS
            $ps = $this->db->prepare("INSERT INTO `{$this->_table}` ({$campos}) values ({$valores})");
            //PASSA OS VALORES CORRETOS BASEADOS NO PARAMETROS DA STRING
            foreach ($dadosBD as $key => $value) {
                $ps->bindValue(":$key", $value);
            }
            //EXECUTA A QUERY
            $executa = $ps->execute();
        } catch (PDOexception $e) {
            echo $e->getMessage();
        }
        return $this->db->lastInsertId();
    }

    /**
     * query directed to current table
     *
     * @name read
     * @access public
     * @param (string)$where   - Passa condições se for necessário
     * @param (string)$limit   - define o limit da pesquisa
     * @param (string)$offset  - define o offset da pesquisa
     * @param (string)$orderby - define a ordem para o resultado
     * @param (boolean)$debug  - imprime a string do sql
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
     * consult direcionada a table atual com retorno de uma linha
     *
     * @name read
     * @access public
     * @param (string)$where   - Passa condições se for necessário
     * @param (string)$limit   - define o limit da pesquisa
     * @param (string)$offset  - define o offset da pesquisa
     * @param (string)$orderby - define a ordem para o resultado
     * @param (boolean)$debug  - imprime a string do sql
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
     * @param (array)$dados - Array com os novos dados da table
     * @param (boolean)$where - Condição passada para atualização
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
        //FAZ O DEBUG DA STRING SQL
        if ($debug) {
            foreach ($dadosBD as $key => $value) {
                $camposDebug[] = "$key = '$value'";
            }
            $camposDebug = implode(",", $camposDebug);
            $this->debug("UPDATE `{$this->_table}` SET {$camposDebug} WHERE {$where}");
        }
        try {
            //PREPARA OS DADOS PARA INSERT USANDO PREPARED STATEMENTS
            $ps = $this->db->prepare("UPDATE `{$this->_table}` SET {$campos} WHERE {$where}");
            //PASSA OS VALORES CORRETOS BASEADOS NO PARAMETROS DA STRING
            foreach ($dadosBD as $key => $value) {
                $ps->bindValue(":$key", $value);
            }
            //EXECUTA A QUERY
            $executa = $ps->execute();
        } catch (PDOexception $e) {
            echo $e->getMessage();
        }
        return $ps->rowCount();
    }

    /**
     * Inserir dados no banco
     *
     * @name delete
     * @access public
     * @param (boolean)$where - Condição passada para exclusão
     * @return (int) retorna a quantidade de linhas afetadas;
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
     *
     * @name consult
     * @access public
     * @param (string)$sql - Comando SQL a ser executado
     * @param (boolean)$debug - Se deve debugar o comando. Por padrão é FALSE
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
     * @name oneLineConsult
     * @access public
     * @param (string)$sql - Comando SQL a ser executado
     * @param (boolean)$debug - Se deve debugar o comando. Por padrão é FALSE
     * @return (array)$resultado - Array com os resultados da primeira linha da consult SQL
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
     * consult um único valor
     * Este método retorna a primeira coluna da primeira linha do resultado de uma consult
     *
     * @name consultValue
     * @access public
     * @param (string)$sql - Comando SQL a ser executado
     * @param (boolean)$debug - Se deve debugar o comando. Por padrão é FALSE
     * @return (?) Valor da primeira coluna da primeira linha do resultado da consult
     * @version 11.1.11
     **/

    public function consultValue($sql, $debug = FALSE)
    {
        // consultndo
        $resultado = $this->oneLineConsult($sql, $debug);
        // Se retornou um Array
        if (is_array($resultado)) {
            // Retornando a primeira coluna
            return array_shift($resultado);
        } else {
            // Retornando falso
            return FALSE;
        }
    }

    /**
     * Busca os dados de uma table relacionada atravez da chave estrangeira
     *
     * @name populateFK
     * @access public
     * @return (array) retorna um array com os dados referente a cada table relacionada
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
     * Método privado de debug dos comandos SQL
     *
     * @name debug
     * @access private
     * @param (string)$sql - Comando SQL a ser debugado
     * @return void
     * @version 1
     **/
    private function debug($sql)
    {
        echo "<hr/><pre>$sql</pre><hr/>";
    }
}

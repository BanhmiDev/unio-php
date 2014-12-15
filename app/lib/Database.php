<?php

class Database {
    // Objects  
    private $pdo;
    private $log;
    private $query;

    // Settings
    private $db_host;
    private $db_name;
    private $db_user;
    private $db_pass;

    // SQL query parameters
    private $parameters;

    // Database connection status
    private $is_connected = false;
        
    /**
     * Database Constructor
     */
    public function __construct() {
        // Apply global settings
        $this->db_host = DB_HOST;
        $this->db_name = DB_NAME;
        $this->db_user = DB_USER;
        $this->db_pass = DB_PASS;

        // Create log
        $this->log = new Log(); 
        $this->connect();
        $this->parameters = array();
    }
    
    /**
     * This method makes connection to the database.
     */
    private function connect() {
        $dsn = 'mysql:dbname='. $this->db_name .';host='. $this->db_host .'';
        try {
            $this->pdo = new PDO($dsn, $this->db_user, $this->db_pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
                
            // http://php.net/manual/de/pdo.setattribute.php
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            // No connection errors, set to true
            $this->is_connected = true;
        } catch (PDOException $e) {
            // Connection issues, stop program
            echo $this->ExceptionLog($e->getMessage());
            exit();
        }
    }

    /**
     * Close the PDO connection
     */
    public function closeConnection() {
        $this->pdo = null;
    }
        
    /**
     * Every method which needs to execute a SQL query uses this method.
     * 1. If not connected, connect to the database.
     * 2. Prepare Query.
     * 3. Parameterize Query.
     * 4. Execute Query.   
     * 5. On exception : Write Exception into the log + SQL query.
     * 6. Reset the Parameters.
     */  
    private function init($search_query, $parameters = '') {
        // Connect to database
        if (!$this->is_connected) 
            $this->connect();

        try {
            // Prepare query
            $this->query = $this->pdo->prepare($search_query);

            // Add parameters to the parameter array 
            $this->bindMore($parameters);

            // Bind parameters
            if (!empty($this->parameters)) {
                foreach($this->parameters as $param) {
                    $parameters = explode("\x7F", $param);
                    $this->query->bindParam($parameters[0], $parameters[1]);
                }       
            }

            // Execute SQL 
            $this->success = $this->query->execute();     
        } catch(PDOException $e) {
            // Write into log and display Exception
            echo $this->ExceptionLog($e->getMessage(), $search_query );
            exit();
        }

        // Reset the parameters
        $this->parameters = array();
    }
        
    /**
     * @void 
     * Add the parameter to the parameter array
     * @param string $para 
     * @param string $value 
     */  
    public function bind($para, $value) {   
        $this->parameters[sizeof($this->parameters)] = ":" . $para . "\x7F" . $value;
    }
       
    /**
     * @void
     * Add more parameters to the parameter array
     * @param array $parray
     */  
    public function bindMore($parray) {
        if (empty($this->parameters) && is_array($parray)) {
            $columns = array_keys($parray);
            foreach($columns as $i => &$column) {
                $this->bind($column, $parray[$column]);
            }
        }
    }

    /**
     * If the SQL query  contains a SELECT or SHOW statement it returns an array containing all of the result set row
     * If the SQL statement is a DELETE, INSERT, or UPDATE statement it returns the number of affected rows
     * @param  string $search_query
     * @param  array  $params
     * @param  int    $fetchmode
     * @return mixed
     */          
    public function query($search_query, $params = null, $fetchmode = PDO::FETCH_ASSOC) {
        $search_query = trim($search_query);

        $this->init($search_query, $params);

        $rawStatement = explode(' ', $search_query);
        
        # Which SQL statement is used 
        $statement = strtolower($rawStatement[0]);
        
        if ($statement === 'select' || $statement === 'show') {
            return $this->query->fetchAll($fetchmode);
        } elseif ($statement === 'insert' ||  $statement === 'update' || $statement === 'delete' ) {
            return $this->query->rowCount();   
        } else {
            return null;
        }
    }
        
    /**
     * Returns the last inserted id.
     * @return string
     */   
    public function lastInsertId() {
        return $this->pdo->lastInsertId();
    }   
        
    /**
     * Returns an array which represents a column from the result set 
     * @param string $search_query
     * @param array $params
     * @return array
     */  
    public function column($search_query, $params = null)
    {
        $this->init($search_query, $params);
        $Columns = $this->query->fetchAll(PDO::FETCH_NUM);     
        
        $column = null;

        foreach($Columns as $cells) {
            $column[] = $cells[0];
        }

        return $column;
        
    } 

    /**
     * Returns an array which represents a row from the result set
     * @param string $search_query
     * @param array  $params
     * @param int $fetchmode
     * @return array
     */  
    public function row($search_query, $params = null, $fetchmode = PDO::FETCH_ASSOC) {               
        $this->init($search_query, $params);
        return $this->query->fetch($fetchmode);            
    }

    /**
     * Returns the value of one single field/column
     * @param string $search_query
     * @param array $params
     * @return string
     */  
    public function single($search_query, $params = null) {
        $this->init($search_query, $params);
        return $this->query->fetchColumn();
    }

    /**  
     * Writes the log and returns the exception
     * @param string $message
     * @param string $sql
     * @return string
     */
    private function ExceptionLog($message, $sql = '') {
        $exception  = 'Unhandled Exception. <br />';
        $exception .= $message;
        $exception .= "<br /> You can find the error back in the log.";

        if (!empty($sql)) {
            // Add the Raw SQL to the Log
            $message .= "\r\nRaw SQL : "  . $sql;
        }
        
        // Write into log
        $this->log->write($message);

        return $exception;
    }           
}

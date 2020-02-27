<?php

class Controller {
    private $server;
    private $database;
    private $username;
    private $password;

    public function __construct($server, $database, $username, $password) {
        $this->server   = $server;
        $this->database = $database;
        $this->username = $username;
        $this->password = $password;
    }   

    public function connect($dsnType = null) {
        switch ($dsnType) {
            case 'sqlsrv':
                $dsn = "sqlsrv:server=$this->server;database=$this->database";
                break;
            
            default:
                $dsn = "mysql:host=$this->server;dbname=$this->database;charset=utf8";
        }

        try {
            $pdo = new PDO($dsn, $this->username, $this->password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $pdo;
        } catch (PDOException $err) {
            echo 'Database Connection Failed: ', $err->getMessage();
        }
    }
}
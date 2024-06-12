<?php

class Database{
    private $connection;

    private $host = 'db';
    private $user = 'root';
    private $password = 'root';
    private $database = 'desafio_dev_mysql';
    private $port = '3030';

    public function __construct(){
        $this->connection = new mysqli($this->host, $this->user, $this->password, $this->database, $this->port);
    }

    public function query($sql){
        return $this->connection->query($sql);
    }

    public function fetch($result){
        return $result->fetch_assoc();
    }

    public function fetchAll($result){
        $data = [];
        while($row = $result->fetch_assoc()){
            $data[] = $row;
        }
        return $data;
    }

    public function escape($value){
        return $this->connection->real_escape_string($value);
    }
}
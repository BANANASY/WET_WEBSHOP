<?php

class DB {
    private $host = "localhost";
    private $user = "webshop_user";
    private $password = "wet_123";
    private $dbname = "7048141db1";
    
    public function initConnect(){
        $ret_v = new DB();
        return $ret_v->connect2DB();
    }
    
    private function connect2DB(){
        $conn = new mysqli($this->host, $this->user, $this->password, $this->dbname);       
        return $conn;
    }
    
    private function generateTestdata(){
        $testArr = [];
        $tables = [];
        $table_colNames = [];
    }
}
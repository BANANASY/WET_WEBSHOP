<?php

class DB {
    private $host = "mysqlsvr71.world4you.com";
    private $user = "sql2558943";
    private $password = "uxevy+j";
    private $dbname = "7048141db1";
    
    public function initConnect(){
        $ret_v = new DB();
        return $ret_v->connect2DB();
    }
    
    private function connect2DB(){
        $conn = new mysqli($this->host, $this->user, $this->password, $this->dbname);       
        return $conn;
    }  
}
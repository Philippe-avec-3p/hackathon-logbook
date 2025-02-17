<?php

class Bdd
{
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $dbname = "logbooktest";

    private static $connection;

    public function getConnexion() {
        $PDO = "mysql:host=$this->host;dbname=$this->dbname;port=3306";
        return $connection = new PDO($PDO, $this->user, $this->password);
    }



}
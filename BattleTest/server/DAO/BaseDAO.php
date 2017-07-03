<?php

class BaseDAO {
    public $pdo;
    
    function __construct() {
        $config = parse_ini_file("../server/config.ini");
        $host = $config["host"];
        $dbname = $config["dbname"];
        $username = $config["username"];
        $password = $config["password"];
        $this->pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    }
}

?>
<?php

class ConnectionManager
{
    public function getConnection()
    {
        // VERIFY THE VALUES BELOW. CHANGE AS NEEDED
        
        $host     = 'localhost';
        $port     = '3306';
        $dbname   = 'tracker'; 
        $username = 'root';
        $password = '';

        $dsn = "mysql:host=$host;port=$port;dbname=$dbname";
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
        return $pdo;
    }
}
?>

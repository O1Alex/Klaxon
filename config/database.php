<?php
class Config{
    private static $pdo=null;

public static function Connexion(){
    if (!isset(self::$pdo)){
        $servername="localhost"; //127.0.0.1
        $nom_bd="covoiturage";
        $username="root";
        $password="";
    }
    try {
        self::$pdo=new PDO(
            "mysql:host=$servername, dbname=$nom_bd",
            $username,
            $password,
            [
                PDO::ATTR_ERRMODE =>PDO::ERRMODE_EXCEPTION
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            ]
            );
        echo'Database connected successfully';
    } catch (Exception $e) {
        echo("Database connection".$e);
    }

    return ::$pdo;
}
}

Config::Connexion();
?>
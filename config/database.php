<?php

class Config {

    private static $pdo = null;

    public static function Connexion() {
        if (self::$pdo === null) {

            $servername = "localhost";
            $nom_bd = "covoiturage";
            $username = "root";
            $password = "";

            try {
                self::$pdo = new PDO(
                    "mysql:host=$servername;dbname=$nom_bd",
                    $username,
                    $password,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
                    ]
                );

            } catch (PDOException $e) {
                die("Database connection error : " . $e->getMessage());
            }
        }

        return self::$pdo;
    }
}

?>
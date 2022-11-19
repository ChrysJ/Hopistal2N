<?php

require_once __DIR__ . './../../config/config.php';


class Connexion
{

    private static $_pdo;

    public static function getInstance()
    {
        if (is_null(self::$_pdo)) {

            self::$_pdo = new PDO(
                DSN,
                USER,
                PWD
            );
            self::$_pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        }
        return self::$_pdo;
    }
}

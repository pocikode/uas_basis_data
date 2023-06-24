<?php

namespace App\Repositories;

use PDO;
use PDOException;

class Database
{
    protected static PDO $instance;

    public static function connect()
    {
        $db_info = [
            "db_host" => $_ENV['DB_HOST'],
            "db_port" => $_ENV['DB_PORT'],
            "db_user" => $_ENV['DB_USERNAME'],
            "db_pass" => $_ENV['DB_PASSWORD'],
            "db_name" => $_ENV['DB_DATABASE'],
            "db_charset" => "UTF-8"
        ];

        try {
            $connection = new PDO("mysql:host=" . $db_info['db_host'] . ';port=' . $db_info['db_port'] . ';dbname=' . $db_info['db_name'], $db_info['db_user'], $db_info['db_pass']);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
            $connection->query('SET NAMES utf8');
            $connection->query('SET CHARACTER SET utf8');

            return $connection;
        } catch (PDOException $error) {
            echo $error->getMessage();
        }
    }

    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = self::connect();
        }

        return self::$instance;
    }
}
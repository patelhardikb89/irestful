<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Installations;

final class Database {
    private static $pdo = null;

    public static function reset() {

        //create PDO:
        $dsn = getenv('DB_DRIVER').':host='.getenv('DB_SERVER');
        self::$pdo = new \PDO($dsn, getenv('DB_USERNAME'), getenv('DB_PASSWORD'));

        $databaseName = getenv('DB_NAME');

        //setup db:
        self::dropDatabase($databaseName);
        self::createDatabase($databaseName);

        //disable strict mode:
        self::execute("SET @@global.sql_mode= 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION'");
    }

    private static function dropDatabase($databaseName) {
        $query = 'drop database if exists '.$databaseName;
        self::execute($query);
    }

    private static function createDatabase($databaseName) {
        $query = 'create database if not exists '.$databaseName;
        self::execute($query);
    }

    public static function execute($query) {
        $statement = self::$pdo->prepare($query);
        $statement->execute();
    }
}

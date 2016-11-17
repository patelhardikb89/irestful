<?php
namespace iRESTful\LeoPaul\Applications\APIs\Entities\Tests\Tests\Installations;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Installations\Database as EngineDatabase;

final class Database {

    public static function install() {

        EngineDatabase::reset();
        $databaseName = getenv('DB_NAME');

        //use database:
        self::useDatabase($databaseName);

        //setup tables:
        self::simpleEntity();
        self::complexEntity();
    }

    private static function useDatabase($databaseName) {
        $query = 'use '.$databaseName;
        EngineDatabase::execute($query);
    }

    private static function simpleEntity() {
        $query = '
            create table simple_entity (
                uuid binary(16) primary key,
                slug varchar(255) unique,
                title varchar(255),
                description text,
                created_on int(11)
            ) Engine=InnoDb;
        ';

        EngineDatabase::execute($query);
    }

    private static function complexEntity() {
        $query = '
            create table complex_entity (
                uuid binary(16) primary key,
                slug varchar(255) unique,
                name varchar(255),
                description text,
                simple_entity binary(16) not null,
                created_on int(11)
            ) Engine=InnoDb;
        ';

        EngineDatabase::execute($query);

        $query = 'alter table complex_entity add foreign key (simple_entity) references simple_entity(uuid);';
        EngineDatabase::execute($query);

        self::complexEntitySimpleEntity();
    }

    private static function complexEntitySimpleEntity() {
        $query = '
            create table complex_entity___simple_entities (
                master_uuid binary(16),
                slave_uuid binary(16)
            ) Engine=InnoDb;
        ';

        EngineDatabase::execute($query);

        $query = 'alter table complex_entity___simple_entities add foreign key (master_uuid) references complex_entity(uuid);';
        EngineDatabase::execute($query);

        $query = 'alter table complex_entity___simple_entities add foreign key (slave_uuid) references simple_entity(uuid);';
        EngineDatabase::execute($query);
    }
}

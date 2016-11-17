<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDODatabases\Tests\Tests\Functional\Factories;
use iRESTful\LeoPaul\Applications\Libraries\PDODatabases\Infrastructure\Factories\PDOSchemaAdapterFactory;
use iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Infrastructure\Factories\ReflectionClassSchemaAdapterFactory;

final class PDOSchemaAdapterFactoryTest extends \PHPUnit_Framework_TestCase {
    private $schemaAdapterFactory;
    private $pdoSchemaAdapterFactory;
    public function setUp() {

        $containerClassMapper = [
			'complex_entity' => 'iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects\ComplexEntity',
			'simple_entity' => 'iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects\SimpleEntity'
		];

		$interfaceClassMapper = [
			'iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects\SimpleEntityInterface' => 'iRESTful\LeoPaul\Objects\Libraries\MetaDatas\Tests\Tests\Objects\SimpleEntity'
		];

        $engine = 'InnoDB';
        $delimiter = '___';

        $this->data = [
            'name' => 'my_schema',
            'container_names' => [
                'complex_entity',
                'simple_entity'
            ]
        ];

        $this->schemaAdapterFactory = new ReflectionClassSchemaAdapterFactory($containerClassMapper, $interfaceClassMapper, $engine, $delimiter);
        $this->pdoSchemaAdapterFactory = new PDOSchemaAdapterFactory($delimiter);
    }

    public function tearDown() {

    }

    public function testCreate_convertToSQLQueries_Success() {

        $schema = $this->schemaAdapterFactory->create()->fromDataToSchema($this->data);
        $queries = $this->pdoSchemaAdapterFactory->create()->fromSchemaToSQLQueries($schema);

        $this->assertEquals($queries, [
            "drop database if exists my_schema;",
            "create database if not exists my_schema;",
            "use my_schema;",
            "create table complex_entity (uuid binary (16) primary key, created_on bigint not null, title char (255) not null, sub_entity___uuid binary (16) primary key, sub_entity___created_on bigint not null, sub_entity___title char (255) not null default 'my-title', sub_entity___slug char (255) not null default 'my-slug', sub_entity___domain_names char (255), sub_entity___float decimal (20, 3) default null, big_property___title char (255) not null, big_property___is_good bool, empty_big_property___title char (255) not null, empty_big_property___is_good bool, sub_complex_entity binary (16)) Engine=innodb;",
            "create table simple_entity (uuid binary (16) primary key, created_on bigint not null, title char (255) not null default 'my-title', slug char (255) not null default 'my-slug', domain_names char (255), float decimal (20, 3) default null) Engine=innodb;",
            "create table complex_entity___simple_entities (master_uuid binary (16) not null, slave_uuid binary (16) not null) Engine=innodb;",
            "alter table complex_entity___simple_entities add foreign key (master_uuid) references complex_entity(uuid);",
            "alter table complex_entity___simple_entities add foreign key (slave_uuid) references simple_entity(uuid);"
        ]);

    }

}

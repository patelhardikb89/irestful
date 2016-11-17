<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Tests\Functional;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Factories\ConcreteNativePDOFactory;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Exceptions\PDOException;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Native\Exceptions\NativePDOException;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Adapters\ConcretePDORepositoryFactoryAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Adapters\ConcretePDOServiceFactoryAdapter;

final class InsertThenFetchTest extends \PHPUnit_Framework_TestCase {
    private $driver;
    private $hostname;
    private $username;
    private $password;
    private $database;
    private $uuid;
    private $params;
    private $data;
    private $secondUuid;
    private $secondParams;
    private $secondData;
    private $service;
    private $repository;
    public function setUp() {

        \iRESTful\LeoPaul\Applications\Libraries\PDO\Installations\Database::reset();

        $this->driver = getenv('DB_DRIVER');
        $this->hostname = getenv('DB_SERVER');
        $this->username = getenv('DB_USERNAME');
        $this->password = getenv('DB_PASSWORD');
        $this->database = getenv('DB_NAME');


        $this->uuid = hex2bin(str_replace('-', '', '5b442004-61b3-4791-b8ea-27263b3542dc'));
        $this->params = [
            'uuid' => $this->uuid,
            'slug' => 'my_slug',
            'title' => 'This is a title',
            'description' => 'This is a description'
        ];

        $this->data = [
            'uuid' => $this->uuid,
            0 => $this->uuid,
            'slug' => 'my_slug',
            1 => 'my_slug',
            'title' => 'This is a title',
            2 => 'This is a title',
            'description' => 'This is a description',
            3 => 'This is a description'
        ];

        $this->secondUuid = hex2bin(str_replace('-', '', '494b501f-5513-40ec-ada3-bb631879f246'));
        $this->secondParams = [
            'uuid' => $this->secondUuid,
            'slug' => 'another_slug',
            'title' => 'This is a second title',
            'description' => 'This is a second description'
        ];

        $this->secondData = [
            'uuid' => $this->secondUuid,
            0 => $this->secondUuid,
            'slug' => 'another_slug',
            1 => 'another_slug',
            'title' => 'This is a second title',
            2 => 'This is a second title',
            'description' => 'This is a second description',
            3 => 'This is a second description'
        ];

        $params = [
            'timezone' => 'America/Montreal',
            'driver' => $this->driver,
            'hostname' => $this->hostname,
            'database' => $this->database,
            'username' => $this->username,
            'password' => $this->password
        ];

        $serviceFactoryAdapter = new ConcretePDOServiceFactoryAdapter();
        $this->service = $serviceFactoryAdapter->fromDataToPDOServiceFactory($params)->create();

        $repositoryFactoryAdapter = new ConcretePDORepositoryFactoryAdapter();
        $this->repository = $repositoryFactoryAdapter->fromDataToPDORepositoryFactory($params)->create();

    }

    public function tearDown() {

    }

    public function testRetrieve_withoutDataInTable_Success() {

        //create table:
        $pdo = $this->service->query([
            'query' => '
                create table mytable (
                    uuid binary(16) primary key,
                    slug varchar(255) unique,
                    title varchar(255),
                    description text
                ) Engine=InnoDb;
            '
        ]);

        $pdo = $this->repository->fetchFirst([
            'query' => 'select * from mytable where uuid = :uuid;',
            'params' => [
                ':uuid' => $this->uuid
            ]
        ]);

        $this->assertFalse($pdo->getMicroDateTimeClosure()->hasResults());
        $this->assertNull($pdo->getMicroDateTimeClosure()->getResults());
    }

    public function testRetrieve_withoutDatabase_throwsPDOException() {

        $asserted = false;
        try {

            $this->repository->fetchFirst([
                'query' => 'select * from mytable where uuid = :uuid;',
                'params' => [
                    ':uuid' => $this->uuid
                ]
            ]);

        } catch (PDOException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testInsertThenFetch_Success() {

        //create table:
        $pdo = $this->service->query([
            'query' => '
                create table mytable (
                    uuid binary(16) primary key,
                    slug varchar(255) unique,
                    title varchar(255),
                    description text
                ) Engine=InnoDb;
            '
        ]);

        $this->assertTrue($pdo->getMicroDateTimeClosure()->hasResults());
        $this->assertTrue($pdo->getMicroDateTimeClosure()->getResults() instanceof \PDOStatement);

        //insert first element:
        $pdo = $this->service->query([
            'query' => 'insert into mytable (uuid, slug, title, description) values(:uuid, :slug, :title, :description);',
            'params' => $this->params
        ]);

        $this->assertTrue($pdo->getMicroDateTimeClosure()->hasResults());
        $this->assertTrue($pdo->getMicroDateTimeClosure()->getResults() instanceof \PDOStatement);

        //insert second element:
        $pdo = $this->service->query([
            'query' => 'insert into mytable (uuid, slug, title, description) values(:uuid, :slug, :title, :description);',
            'params' => $this->secondParams
        ]);

        $this->assertTrue($pdo->getMicroDateTimeClosure()->hasResults());
        $this->assertTrue($pdo->getMicroDateTimeClosure()->getResults() instanceof \PDOStatement);

        //retrieve first element:
        $pdo = $this->repository->fetchFirst([
            'query' => 'select * from mytable where uuid = :uuid;',
            'params' => [
                ':uuid' => $this->uuid
            ]
        ]);

        $this->assertTrue($pdo->getMicroDateTimeClosure()->hasResults());
        $this->assertEquals($this->data, $pdo->getMicroDateTimeClosure()->getResults());

        //retrieve second element:
        $pdo = $this->repository->fetchFirst([
            'query' => 'select * from mytable where uuid = :uuid;',
            'params' => [
                ':uuid' => $this->secondUuid
            ]
        ]);

        $this->assertTrue($pdo->getMicroDateTimeClosure()->hasResults());
        $this->assertEquals($this->secondData, $pdo->getMicroDateTimeClosure()->getResults());

        //retrieve both elements:
        $pdo = $this->repository->fetch([
            'query' => 'select * from mytable;'
        ]);

        $this->assertTrue($pdo->getMicroDateTimeClosure()->hasResults());
        $this->assertEquals([$this->secondData, $this->data], $pdo->getMicroDateTimeClosure()->getResults());

    }

    public function testInsert_withInvalidQuery_throwsPDOException() {

        $asserted = false;
        try {

            $this->service->query([
                'query' => 'not a valid query'
            ]);

        } catch (PDOException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testInsertWithTransactionThenFetch_Success() {

        //create table:
        $pdo = $this->service->query([
            'query' => '
                create table mytable (
                    uuid binary(16) primary key,
                    slug varchar(255) unique,
                    title varchar(255),
                    description text
                ) Engine=InnoDb;
            '
        ]);

        $this->assertTrue($pdo->getMicroDateTimeClosure()->hasResults());
        $this->assertTrue($pdo->getMicroDateTimeClosure()->getResults() instanceof \PDOStatement);

        //insert first element:
        $pdo = $this->service->queries([
            [
                'query' => 'insert into mytable (uuid, slug, title, description) values(:uuid, :slug, :title, :description);',
                'params' => $this->params
            ],
            [
                'query' => 'insert into mytable (uuid, slug, title, description) values(:uuid, :slug, :title, :description);',
                'params' => $this->secondParams
            ]
        ]);

        $this->assertTrue($pdo->getMicroDateTimeClosure()->hasResults());
        $this->assertTrue($pdo->getMicroDateTimeClosure()->getResults() instanceof \iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\Closures\MicroDateTimeClosure);

        $microDateTimeClosure = $pdo->getMicroDateTimeClosure()->getResults();
        $this->assertTrue($microDateTimeClosure->hasResults());

        $results = $microDateTimeClosure->getResults();
        $this->assertTrue(is_array($results));

        $this->assertTrue($results[0]->getMicroDateTimeClosure()->hasResults());
        $this->assertTrue($results[0]->getMicroDateTimeClosure()->getResults() instanceof \PDOStatement);

        $this->assertTrue($results[1]->getMicroDateTimeClosure()->hasResults());
        $this->assertTrue($results[1]->getMicroDateTimeClosure()->getResults() instanceof \PDOStatement);

        //retrieve first element:
        $pdo = $this->repository->fetchFirst([
            'query' => 'select * from mytable where uuid = :uuid;',
            'params' => [
                ':uuid' => $this->uuid
            ]
        ]);

        $this->assertTrue($pdo->getMicroDateTimeClosure()->hasResults());
        $this->assertEquals($this->data, $pdo->getMicroDateTimeClosure()->getResults());

        //retrieve second element:
        $pdo = $this->repository->fetchFirst([
            'query' => 'select * from mytable where uuid = :uuid;',
            'params' => [
                ':uuid' => $this->secondUuid
            ]
        ]);

        $this->assertTrue($pdo->getMicroDateTimeClosure()->hasResults());
        $this->assertEquals($this->secondData, $pdo->getMicroDateTimeClosure()->getResults());

        //retrieve both elements:
        $pdo = $this->repository->fetch([
            'query' => 'select * from mytable;'
        ]);

        $this->assertTrue($pdo->getMicroDateTimeClosure()->hasResults());
        $this->assertEquals([$this->secondData, $this->data], $pdo->getMicroDateTimeClosure()->getResults());

    }

    public function testInsertWithTransactionThenFetch_withOneInvalidQuery_noDataIsInDatabase_throwsPDOException() {

        //create table:
        $pdo = $this->service->query([
            'query' => '
                create table mytable (
                    uuid binary(16) primary key,
                    slug varchar(255) unique,
                    title varchar(255),
                    description text
                ) Engine=InnoDb;
            '
        ]);

        $this->assertTrue($pdo->getMicroDateTimeClosure()->hasResults());
        $this->assertTrue($pdo->getMicroDateTimeClosure()->getResults() instanceof \PDOStatement);

        $asserted = false;

        try {

            $this->service->queries([
                [
                    'query' => 'insert into mytable (uuid, slug, title, description) values(:uuid, :slug, :title, :description);',
                    'params' => $this->params
                ],
                [
                    'query' => 'insert into notavalidtable (uuid, slug, title, description) values(:uuid, :slug, :title, :description);',
                    'params' => $this->secondParams
                ]
            ]);

        } catch (PDOException $exception) {
            $asserted = true;
        }

        //retrieve both elements:
        $pdo = $this->repository->fetch([
            'query' => 'select * from mytable;'
        ]);

        $this->assertFalse($pdo->getMicroDateTimeClosure()->hasResults());

    }

    public function testRetrieve_withInvalidQuery_throwsPDOException() {

        $asserted = false;
        try {

            $this->repository->fetch([
                'query' => 'not a valid query'
            ]);

        } catch (PDOException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testInsert_withoutCriteria_throwsPDOException() {

        $asserted = false;
        try {

            $this->service->query([]);

        } catch (PDOException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testRetrieve_withoutCriteria_throwsPDOException() {

        $asserted = false;
        try {

            $this->repository->fetch([]);

        } catch (PDOException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testInsert_withNotEnoughParams_throwsPDOException() {

        $asserted = false;
        try {

            unset($this->params['uuid']);

            $this->service->query([
                'query' => 'insert into mytable (uuid, slug, title, description) values(:uuid, :slug, :title, :description);',
                'params' => $this->params
            ]);

        } catch (PDOException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreateNativePDO_withInvalidCredentials_throwsPDOException_throwsNativePDOException() {

        $factory = new ConcreteNativePDOFactory($this->driver, $this->hostname, $this->database, 'invalidusername', 'invalidpassword');

        $asserted = false;
        try {

            $factory->create();

        } catch (NativePDOException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreateNativePDO_withoutPassword_passwordIsMandatoryForOurMysqlServer_throwsPDOException_throwsNativePDOException() {

        $factory = new ConcreteNativePDOFactory($this->driver, $this->hostname, $this->database, $this->username);

        $asserted = false;
        try {

            $factory->create();

        } catch (NativePDOException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreateNativePDO_withInvalidDatabase_throwsNativePDOException() {

        $factory = new ConcreteNativePDOFactory($this->driver, $this->hostname, 'invaid_db', $this->username, $this->password);

        $asserted = false;
        try {

            $factory->create();

        } catch (NativePDOException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}

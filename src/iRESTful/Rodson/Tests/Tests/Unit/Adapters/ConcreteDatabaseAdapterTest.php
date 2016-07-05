<?php
namespace iRESTful\Rodson\Tests\Tests\Unit\Adapters;
use iRESTful\Rodson\Tests\Helpers\Adapters\RelationalDatabaseAdapterHelper;
use iRESTful\Rodson\Tests\Helpers\Adapters\RESTAPIAdapterHelper;
use iRESTful\Rodson\Infrastructure\Adapters\ConcreteDatabaseAdapter;
use iRESTful\Rodson\Domain\Inputs\Databases\Exceptions\DatabaseException;

final class ConcreteDatabaseAdapterTest extends \PHPUnit_Framework_TestCase {
    private $relationalDatabaseAdapterMock;
    private $relationalDatabaseMock;
    private $restAPIAdapterMock;
    private $restAPIMock;
    private $name;
    private $relationalData;
    private $restAPIData;
    private $multipleData;
    private $adapter;
    private $relationalDatabaseAdapterHelper;
    private $restAPIAdapterHelper;
    public function setUp() {
        $this->relationalDatabaseAdapterMock = $this->getMock('iRESTful\Rodson\Domain\Inputs\Databases\Relationals\Adapters\RelationalDatabaseAdapter');
        $this->relationalDatabaseMock = $this->getMock('iRESTful\Rodson\Domain\Inputs\Databases\Relationals\RelationalDatabase');
        $this->restAPIAdapterMock = $this->getMock('iRESTful\Rodson\Domain\Inputs\Databases\RESTAPIs\Adapters\RESTAPIAdapter');
        $this->restAPIMock = $this->getMock('iRESTful\Rodson\Domain\Inputs\Databases\RESTAPIs\RESTAPI');

        $this->name = 'some_name';

        $this->relationalData = [
            'name' => $this->name,
            'type' => 'relational',
            'some' => 'other'
        ];

        $this->restAPIData = [
            'name' => $this->name,
            'type' => 'rest_api',
            'some' => 'other'
        ];

        $this->multipleData = [
            $this->name => [
                'type' => 'rest_api',
                'some' => 'other'
            ]
        ];

        $this->adapter = new ConcreteDatabaseAdapter($this->relationalDatabaseAdapterMock, $this->restAPIAdapterMock);

        $this->relationalDatabaseAdapterHelper = new RelationalDatabaseAdapterHelper($this, $this->relationalDatabaseAdapterMock);
        $this->restAPIAdapterHelper = new RESTAPIAdapterHelper($this, $this->restAPIAdapterMock);
    }

    public function tearDown() {

    }

    public function testFromDataToDatabase_withRelationalDatabase_Success() {

        $this->relationalDatabaseAdapterHelper->expectsFromDataToRelationalDatabase_Success($this->relationalDatabaseMock, $this->relationalData);

        $database = $this->adapter->fromDataToDatabase($this->relationalData);

        $this->assertEquals($this->name, $database->getName());
        $this->assertTrue($database->hasRelational());
        $this->assertEquals($this->relationalDatabaseMock, $database->getRelational());
        $this->assertFalse($database->hasRESTAPI());
        $this->assertNull($database->getRESTAPI());

    }

    public function testFromDataToDatabase_withRelationalDatabase_throwsRelationalDatabaseException_throwsDatabaseException() {

        $this->relationalDatabaseAdapterHelper->expectsFromDataToRelationalDatabase_throwsRelationalDatabaseException($this->relationalData);

        $asserted = false;
        try {

            $this->adapter->fromDataToDatabase($this->relationalData);

        } catch (DatabaseException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToDatabase_withRESTAPI_Success() {

        $this->restAPIAdapterHelper->expectsFromDataToRESTAPI_Success($this->restAPIMock, $this->restAPIData);

        $database = $this->adapter->fromDataToDatabase($this->restAPIData);

        $this->assertEquals($this->name, $database->getName());
        $this->assertFalse($database->hasRelational());
        $this->assertNull($database->getRelational());
        $this->assertTrue($database->hasRESTAPI());
        $this->assertEquals($this->restAPIMock, $database->getRESTAPI());
    }

    public function testFromDataToDatabase_withRESTAPI_throwsRESTAPIException_throwsDatabaseException() {

        $this->restAPIAdapterHelper->expectsFromDataToRESTAPI_throwsRESTAPIException($this->restAPIData);

        $asserted = false;
        try {

            $this->adapter->fromDataToDatabase($this->restAPIData);

        } catch (DatabaseException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testFromDataToDatabase_withInvalidType_throwsDatabaseException() {

        $this->restAPIData['type'] = 'invalid';

        $asserted = false;
        try {

            $this->adapter->fromDataToDatabase($this->restAPIData);

        } catch (DatabaseException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testFromDataToDatabase_witoutType_throwsDatabaseException() {

        unset($this->restAPIData['type']);

        $asserted = false;
        try {

            $this->adapter->fromDataToDatabase($this->restAPIData);

        } catch (DatabaseException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testFromDataToDatabase_witoutName_throwsDatabaseException() {

        unset($this->restAPIData['name']);

        $asserted = false;
        try {

            $this->adapter->fromDataToDatabase($this->restAPIData);

        } catch (DatabaseException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testFromDataToDatabases_Success() {
        $this->restAPIAdapterHelper->expectsFromDataToRESTAPI_Success($this->restAPIMock, $this->restAPIData);

        $databases = $this->adapter->fromDataToDatabases($this->multipleData);

        $this->assertEquals($this->name, $databases[$this->name]->getName());
        $this->assertFalse($databases[$this->name]->hasRelational());
        $this->assertNull($databases[$this->name]->getRelational());
        $this->assertTrue($databases[$this->name]->hasRESTAPI());
        $this->assertEquals($this->restAPIMock, $databases[$this->name]->getRESTAPI());
    }

}

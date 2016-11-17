<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Helpers\Factories\ServerFactoryHelper;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Tests\Helpers\Adapters\MicroDateTimeClosureAdapterHelper;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Adapters\ConcretePDOAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Exceptions\PDOException;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Helpers\Objects\PDOHelper;
use iRESTful\LeoPaul\Objects\Libraries\Dates\Tests\Helpers\Objects\MicroDateTimeClosureHelper;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Tests\Objects\TestPDOStatement;

final class ConcretePDOAdapterTest extends \PHPUnit_Framework_TestCase {
    private $pdoMock;
    private $serverFactoryMock;
    private $serverMock;
    private $microDateTimeClosureAdapterMock;
    private $microDateTimeClosureMock;
    private $requestMock;
    private $closure;
    private $pdoStatement;
    private $data;
    private $adapter;
    private $pdoHelper;
    private $microDateTimeClosureHelper;
    private $serverFactoryHelper;
    private $microDateTimeClosureAdapterHelper;
    public function setUp() {

        $this->pdoMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\PDO');
        $this->serverFactoryMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Servers\Factories\ServerFactory');
        $this->serverMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Servers\Server');
        $this->microDateTimeClosureAdapterMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\Closures\Adapters\MicroDateTimeClosureAdapter');
        $this->microDateTimeClosureMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\Closures\MicroDateTimeClosure');
        $this->requestMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Requests\Request');

        $this->closure = function() {

        };

        $this->pdoStatement = new TestPDOStatement();

        $this->data = [
            'request' => $this->requestMock,
            'closure' => $this->closure
        ];

        $this->adapter = new ConcretePDOAdapter($this->serverFactoryMock , $this->microDateTimeClosureAdapterMock);

        $this->pdoHelper = new PDOHelper($this, $this->pdoMock);
        $this->microDateTimeClosureHelper = new MicroDateTimeClosureHelper($this, $this->microDateTimeClosureMock);
        $this->serverFactoryHelper = new ServerFactoryHelper($this, $this->serverFactoryMock);
        $this->microDateTimeClosureAdapterHelper = new MicroDateTimeClosureAdapterHelper($this, $this->microDateTimeClosureAdapterMock);

    }

    public function tearDown() {

    }

    public function testFromDataToPDO_Success() {

        $this->serverFactoryHelper->expectsCreate_Success($this->serverMock);
        $this->microDateTimeClosureAdapterHelper->expectsFromClosureToMicroDateTimeClosure_Success($this->microDateTimeClosureMock, $this->closure);

        $pdo = $this->adapter->fromDataToPDO($this->data);

        $this->assertEquals($this->requestMock, $pdo->getRequest());
        $this->assertEquals($this->microDateTimeClosureMock, $pdo->getMicroDateTimeClosure());
        $this->assertEquals($this->serverMock, $pdo->getServer());
    }

    public function testFromDataToPDO_throwsMicroDateTimeClosureException_throwsPDOException() {

        $this->serverFactoryHelper->expectsCreate_Success($this->serverMock);
        $this->microDateTimeClosureAdapterHelper->expectsFromClosureToMicroDateTimeClosure_throwsMicroDateTimeClosureException($this->closure);

        $asserted = false;
        try {

            $this->adapter->fromDataToPDO($this->data);

        } catch(PDOException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testFromDataToPDO_throwsServerException_throwsPDOException() {

        $this->serverFactoryHelper->expectsCreate_throwsServerException();

        $asserted = false;
        try {

            $this->adapter->fromDataToPDO($this->data);

        } catch(PDOException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testFromDataToPDO_withInvalidRequest_throwsPDOException() {

        $this->data['request'] = 'invalid request';

        $asserted = false;
        try {

            $this->adapter->fromDataToPDO($this->data);

        } catch(PDOException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testFromDataToPDO_withInvalidClosure_throwsPDOException() {

        $this->data['closure'] = 'invalid closure';

        $asserted = false;
        try {

            $this->adapter->fromDataToPDO($this->data);

        } catch(PDOException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testFromDataToPDO_withoutRequest_throwsPDOException() {

        unset($this->data['request']);

        $asserted = false;
        try {

            $this->adapter->fromDataToPDO($this->data);

        } catch(PDOException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testFromDataToPDO_withoutClosure_throwsPDOException() {

        unset($this->data['closure']);

        $asserted = false;
        try {

            $this->adapter->fromDataToPDO($this->data);

        } catch(PDOException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testFromPDOToNativePDOStatement_Success() {
        $this->pdoHelper->expectsGetMicroDateTimeClosure_Success($this->microDateTimeClosureMock);
        $this->microDateTimeClosureHelper->expectsHasResults_Success(true);
        $this->microDateTimeClosureHelper->expectsGetResults_Success($this->pdoStatement);

        $statement = $this->adapter->fromPDOToNativePDOStatement($this->pdoMock);

        $this->assertEquals($this->pdoStatement, $statement);
    }

    public function testFromPDOToNativePDOStatement_withInvalidResults_Success() {
        $this->pdoHelper->expectsGetMicroDateTimeClosure_Success($this->microDateTimeClosureMock);
        $this->microDateTimeClosureHelper->expectsHasResults_Success(true);
        $this->microDateTimeClosureHelper->expectsGetResults_Success('this is not a \PDOStatement object.');

        $asserted = false;
        try {

            $this->adapter->fromPDOToNativePDOStatement($this->pdoMock);

        } catch(PDOException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

    public function testFromPDOToNativePDOStatement_withoutResults_Success() {
        $this->pdoHelper->expectsGetMicroDateTimeClosure_Success($this->microDateTimeClosureMock);
        $this->microDateTimeClosureHelper->expectsHasResults_Success(false);

        $asserted = false;
        try {

            $this->adapter->fromPDOToNativePDOStatement($this->pdoMock);

        } catch(PDOException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);
    }

}

<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Tests\Unit\Objects;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Infrastructure\Objects\ConcretePDO;

final class ConcretePDOTest extends \PHPUnit_Framework_TestCase {
    private $requestMock;
    private $microDateTimeClosureMock;
    private $serverMock;
    private $requests;
    public function setUp() {
        $this->requestMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Requests\Request');
        $this->microDateTimeClosureMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\Closures\MicroDateTimeClosure');
        $this->serverMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Servers\Server');

        $this->requests = [
            $this->requestMock
        ];
    }

    public function tearDown() {

    }

    public function testCreate_withRequest_Success() {

        $pdo = new ConcretePDO($this->microDateTimeClosureMock, $this->serverMock, $this->requestMock);

        $this->assertTrue($pdo->hasRequest());
        $this->assertEquals($this->requestMock, $pdo->getRequest());
        $this->assertFalse($pdo->hasRequests());
        $this->assertNull($pdo->getRequests());
        $this->assertEquals($this->microDateTimeClosureMock, $pdo->getMicroDateTimeClosure());
        $this->assertEquals($this->serverMock, $pdo->getServer());

    }

    public function testCreate_withRequests_Success() {

        $pdo = new ConcretePDO($this->microDateTimeClosureMock, $this->serverMock, null, $this->requests);

        $this->assertFalse($pdo->hasRequest());
        $this->assertNull($pdo->getRequest());
        $this->assertTrue($pdo->hasRequests());
        $this->assertEquals($this->requests, $pdo->getRequests());
        $this->assertEquals($this->microDateTimeClosureMock, $pdo->getMicroDateTimeClosure());
        $this->assertEquals($this->serverMock, $pdo->getServer());

    }

}

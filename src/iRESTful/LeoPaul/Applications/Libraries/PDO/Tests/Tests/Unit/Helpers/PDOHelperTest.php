<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Helpers\Objects\PDOHelper;

final class PDOHelperTest extends \PHPUnit_Framework_TestCase {
    private $pdoMock;
    private $requestMock;
    private $microDateTimeClosureMock;
    private $serverMock;
    private $requests;
    private $helper;
    public function setUp() {
        $this->pdoMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\PDO');
        $this->requestMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Requests\Request');
        $this->microDateTimeClosureMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Dates\Domain\Micro\Closures\MicroDateTimeClosure');
        $this->serverMock = $this->createMock('iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Servers\Server');

        $this->requests = [
            $this->requestMock,
            $this->requestMock
        ];

        $this->helper = new PDOHelper($this, $this->pdoMock);
    }

    public function tearDown() {

    }

    public function testHasRequest_Success() {

        $this->helper->expectsHasRequest_Success(true);

        $hasRequest = $this->pdoMock->hasRequest();

        $this->assertTrue($hasRequest);

    }

    public function testGetRequest_Success() {

        $this->helper->expectsGetRequest_Success($this->requestMock);

        $request = $this->pdoMock->getRequest();

        $this->assertEquals($this->requestMock, $request);

    }

    public function testHasRequests_Success() {

        $this->helper->expectsHasRequests_Success(false);

        $hasRequest = $this->pdoMock->hasRequests();

        $this->assertFalse($hasRequest);

    }

    public function testGetRequests_Success() {

        $this->helper->expectsGetRequests_Success($this->requests);

        $requests = $this->pdoMock->getRequests();

        $this->assertEquals($this->requests, $requests);

    }

    public function testGetMicroDateTimeClosure_Success() {

        $this->helper->expectsGetMicroDateTimeClosure_Success($this->microDateTimeClosureMock);

        $microDateTimeClosure = $this->pdoMock->getMicroDateTimeClosure();

        $this->assertEquals($this->microDateTimeClosureMock, $microDateTimeClosure);

    }

    public function testGetServer_Success() {

        $this->helper->expectsGetServer_Success($this->serverMock);

        $server = $this->pdoMock->getServer();

        $this->assertEquals($this->serverMock, $server);

    }

}

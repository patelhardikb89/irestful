<?php
namespace iRESTful\DSLs\Tests\Tests\Unit\Objects;
use iRESTful\DSLs\Infrastructure\Objects\ConcreteRESTAPI;
use iRESTful\DSLs\Domain\Projects\Databases\RESTAPIs\Exceptions\RESTAPIException;

final class ConcreteRESTAPITest extends \PHPUnit_Framework_TestCase {
    private $credentialsMock;
    private $port;
    private $headerLine;
    public function setUp() {
        $this->urlMock = $this->createMock('iRESTful\DSLs\Domain\URLs\Url');
        $this->credentialsMock = $this->createMock('iRESTful\DSLs\Domain\Projects\Databases\Credentials\Credentials');

        $this->port = rand(1, 500);
        $this->headerLine = 'RODson my-token';
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $api = new ConcreteRESTAPI($this->urlMock, $this->port);

        $this->assertEquals($this->urlMock, $api->getBaseUrl());
        $this->assertEquals($this->port, $api->getPort());
        $this->assertFalse($api->hasCredentials());
        $this->assertNull($api->getCredentials());
        $this->assertFalse($api->hasHeaderLine());
        $this->assertNull($api->getHeaderLine());

    }

    public function testCreate_withCredentials_Success() {

        $api = new ConcreteRESTAPI($this->urlMock, $this->port, $this->credentialsMock);

        $this->assertEquals($this->urlMock, $api->getBaseUrl());
        $this->assertEquals($this->port, $api->getPort());
        $this->assertTrue($api->hasCredentials());
        $this->assertEquals($this->credentialsMock, $api->getCredentials());
        $this->assertFalse($api->hasHeaderLine());
        $this->assertNull($api->getHeaderLine());

    }

    public function testCreate_withHeaderLine_Success() {

        $api = new ConcreteRESTAPI($this->urlMock, $this->port, null, $this->headerLine);

        $this->assertEquals($this->urlMock, $api->getBaseUrl());
        $this->assertEquals($this->port, $api->getPort());
        $this->assertFalse($api->hasCredentials());
        $this->assertNull($api->getCredentials());
        $this->assertTrue($api->hasHeaderLine());
        $this->assertEquals($this->headerLine, $api->getHeaderLine());

    }

    public function testCreate_withCredentials_withHeaderLine_throwsRESTAPIException() {

        $asserted = false;
        try {

            new ConcreteRESTAPI($this->urlMock, $this->port, $this->credentialsMock, $this->headerLine);

        } catch (RESTAPIException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}

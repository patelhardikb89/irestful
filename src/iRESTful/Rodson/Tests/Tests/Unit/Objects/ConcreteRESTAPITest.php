<?php
namespace iRESTful\Rodson\Tests\Tests\Unit\Objects;
use iRESTful\Rodson\Infrastructure\Objects\ConcreteRESTAPI;
use iRESTful\Rodson\Domain\Databases\RESTAPIs\Exceptions\RESTAPIException;

final class ConcreteRESTAPITest extends \PHPUnit_Framework_TestCase {
    private $credentialsMock;
    private $baseUrl;
    private $port;
    private $headerLine;
    public function setUp() {
        $this->credentialsMock = $this->getMock('iRESTful\Rodson\Domain\Databases\Credentials\Credentials');

        $this->baseUrl = 'http://apis.irestful.com';
        $this->port = rand(1, 500);
        $this->headerLine = 'iRESTful my-token';
    }

    public function tearDown() {

    }

    public function testCreate_Success() {

        $api = new ConcreteRESTAPI($this->baseUrl, $this->port);

        $this->assertEquals($this->baseUrl, $api->getBaseUrl());
        $this->assertEquals($this->port, $api->getPort());
        $this->assertFalse($api->hasCredentials());
        $this->assertNull($api->getCredentials());
        $this->assertFalse($api->hasHeaderLine());
        $this->assertNull($api->getHeaderLine());

    }

    public function testCreate_withCredentials_Success() {

        $api = new ConcreteRESTAPI($this->baseUrl, $this->port, $this->credentialsMock);

        $this->assertEquals($this->baseUrl, $api->getBaseUrl());
        $this->assertEquals($this->port, $api->getPort());
        $this->assertTrue($api->hasCredentials());
        $this->assertEquals($this->credentialsMock, $api->getCredentials());
        $this->assertFalse($api->hasHeaderLine());
        $this->assertNull($api->getHeaderLine());

    }

    public function testCreate_withHeaderLine_Success() {

        $api = new ConcreteRESTAPI($this->baseUrl, $this->port, null, $this->headerLine);

        $this->assertEquals($this->baseUrl, $api->getBaseUrl());
        $this->assertEquals($this->port, $api->getPort());
        $this->assertFalse($api->hasCredentials());
        $this->assertNull($api->getCredentials());
        $this->assertTrue($api->hasHeaderLine());
        $this->assertEquals($this->headerLine, $api->getHeaderLine());

    }

    public function testCreate_withCredentials_withHeaderLine_throwsRESTAPIException() {

        $asserted = false;
        try {

            new ConcreteRESTAPI($this->baseUrl, $this->port, $this->credentialsMock, $this->headerLine);

        } catch (RESTAPIException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNonStringHeaderLine_throwsRESTAPIException() {

        $asserted = false;
        try {

            new ConcreteRESTAPI($this->baseUrl, $this->port, null, new \DateTime());

        } catch (RESTAPIException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNonIntegerPort_throwsRESTAPIException() {

        $asserted = false;
        try {

            new ConcreteRESTAPI($this->baseUrl, (string) $this->port);

        } catch (RESTAPIException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withInvalidBaseUrl_throwsRESTAPIException() {

        $asserted = false;
        try {

            new ConcreteRESTAPI('not-a-valid-url', $this->port);

        } catch (RESTAPIException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withEmptyBaseUrl_throwsRESTAPIException() {

        $asserted = false;
        try {

            new ConcreteRESTAPI('', $this->port);

        } catch (RESTAPIException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testCreate_withNonStringBaseUrl_throwsRESTAPIException() {

        $asserted = false;
        try {

            new ConcreteRESTAPI('', $this->port);

        } catch (RESTAPIException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}

<?php
namespace iRESTful\Rodson\Tests\Inputs\Tests\Unit\Adapters;
use iRESTful\Rodson\Infrastructure\Inputs\Adapters\ConcreteRESTAPIAdapter;
use iRESTful\Rodson\Tests\Inputs\Helpers\Adapters\CredentialsAdapterHelper;
use iRESTful\Rodson\Domain\Inputs\Databases\RESTAPIs\Exceptions\RESTAPIException;

final class ConcreteRESTAPIAdapterTest extends \PHPUnit_Framework_TestCase {
    private $credentialsAdapterMock;
    private $credentialsMock;
    private $baseUrl;
    private $port;
    private $headerLine;
    private $credentials;
    private $data;
    private $dataWithHeaderLine;
    private $dataWithCredentials;
    private $adapter;
    private $credentialsAdapterHelper;
    public function setUp() {
        $this->credentialsAdapterMock = $this->getMock('iRESTful\Rodson\Domain\Inputs\Databases\Credentials\Adapters\CredentialsAdapter');
        $this->credentialsMock = $this->getMock('iRESTful\Rodson\Domain\Inputs\Databases\Credentials\Credentials');

        $this->baseUrl = 'http://api.irestful.com';
        $this->port = 80;
        $this->headerLine = 'Rodson MYAPIKEY';

        $this->credentials = [
            'username' => 'roger',
            'password' => 'cyr'
        ];

        $this->data = [
            'base_url' => $this->baseUrl,
            'port' => $this->port
        ];

        $this->dataWithHeaderLine = [
            'base_url' => $this->baseUrl,
            'port' => $this->port,
            'header_line' => $this->headerLine
        ];

        $this->dataWithCredentials = [
            'base_url' => $this->baseUrl,
            'port' => $this->port,
            'credentials' => $this->credentials
        ];

        $this->adapter = new ConcreteRESTAPIAdapter($this->credentialsAdapterMock);

        $this->credentialsAdapterHelper = new CredentialsAdapterHelper($this, $this->credentialsAdapterMock);
    }

    public function tearDown() {

    }

    public function testFromDataToRESTAPI_Success() {

        $api = $this->adapter->fromDataToRESTAPI($this->data);

        $this->assertEquals($this->baseUrl, $api->getBaseUrl());
        $this->assertEquals($this->port, $api->getPort());
        $this->assertFalse($api->hasCredentials());
        $this->assertNull($api->getCredentials());
        $this->assertFalse($api->hasHeaderLine());
        $this->assertNull($api->getHeaderLine());

    }

    public function testFromDataToRESTAPI_withHeaderLine_Success() {

        $api = $this->adapter->fromDataToRESTAPI($this->dataWithHeaderLine);

        $this->assertEquals($this->baseUrl, $api->getBaseUrl());
        $this->assertEquals($this->port, $api->getPort());
        $this->assertFalse($api->hasCredentials());
        $this->assertNull($api->getCredentials());
        $this->assertTrue($api->hasHeaderLine());
        $this->assertEquals($this->headerLine, $api->getHeaderLine());

    }

    public function testFromDataToRESTAPI_withCredentials_Success() {

        $this->credentialsAdapterHelper->expectsFromDataToCredentials_Success($this->credentialsMock, $this->credentials);

        $api = $this->adapter->fromDataToRESTAPI($this->dataWithCredentials);

        $this->assertEquals($this->baseUrl, $api->getBaseUrl());
        $this->assertEquals($this->port, $api->getPort());
        $this->assertTrue($api->hasCredentials());
        $this->assertEquals($this->credentialsMock, $api->getCredentials());
        $this->assertFalse($api->hasHeaderLine());
        $this->assertNull($api->getHeaderLine());

    }

    public function testFromDataToRESTAPI_withCredentials_throwsCredentialsException_throwsRESTAPIException() {

        $this->credentialsAdapterHelper->expectsFromDataToCredentials_throwsCredentialsException($this->credentials);

        $asserted = false;
        try {

            $this->adapter->fromDataToRESTAPI($this->dataWithCredentials);

        } catch (RESTAPIException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToRESTAPI_withoutBaseUrl_throwsRESTAPIException() {

        unset($this->data['base_url']);

        $asserted = false;
        try {

            $this->adapter->fromDataToRESTAPI($this->data);

        } catch (RESTAPIException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToRESTAPI_withoutPort_throwsRESTAPIException() {

        unset($this->data['port']);

        $asserted = false;
        try {

            $this->adapter->fromDataToRESTAPI($this->data);

        } catch (RESTAPIException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }
}

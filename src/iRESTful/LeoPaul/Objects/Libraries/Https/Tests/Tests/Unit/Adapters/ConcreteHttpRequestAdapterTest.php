<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Https\Tests\Tests\Unit\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\Https\Infrastructure\Adapters\ConcreteHttpRequestAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Exceptions\HttpException;

final class ConcreteHttpRequestAdapterTest extends \PHPUnit_Framework_TestCase {
    private $uri;
    private $method;
    private $port;
    private $queryParameters;
    private $requestParameters;
    private $data;
    private $dataWithQueryParameters;
    private $dataWithRequestParameters;
    private $dataWithParameters;
    private $adapter;
    public function setUp() {

        $this->uri = '/my/uri';
        $this->method = 'post';
        $this->port = 80;
        $this->queryParameters = array(
            'first' => 'param',
            'second' => 'element'
        );

        $this->requestParameters = array(
            'my' => 'element',
            'title' => 'This is just a title'
        );

        $this->data = array(
            'uri' => $this->uri,
            'method' => $this->method,
            'port' => $this->port
        );

        $this->dataWithQueryParameters = array(
            'uri' => $this->uri,
            'method' => $this->method,
            'port' => $this->port,
            'query_parameters' => $this->queryParameters
        );

        $this->dataWithRequestParameters = array(
            'uri' => $this->uri,
            'method' => $this->method,
            'port' => $this->port,
            'request_parameters' => $this->requestParameters
        );

        $this->dataWithParameters = array(
            'uri' => $this->uri,
            'method' => $this->method,
            'port' => $this->port,
            'query_parameters' => $this->queryParameters,
            'request_parameters' => $this->requestParameters
        );

        $this->adapter = new ConcreteHttpRequestAdapter();

    }

    public function tearDown() {

    }

    public function testFromDataToHttpRequest_Success() {

        $httpRequest = $this->adapter->fromDataToHttpRequest($this->data);

        $this->assertEquals($this->uri, $httpRequest->getUri());
        $this->assertEquals($this->method, $httpRequest->getMethod());
        $this->assertEquals($this->port, $httpRequest->getPort());
        $this->assertNull($httpRequest->getQueryParameters());
        $this->assertNull($httpRequest->getRequestParameters());

    }

    public function testFromDataToHttpRequest_withQueryParameters_Success() {

        $httpRequest = $this->adapter->fromDataToHttpRequest($this->dataWithQueryParameters);

        $this->assertEquals($this->uri, $httpRequest->getUri());
        $this->assertEquals($this->method, $httpRequest->getMethod());
        $this->assertEquals($this->port, $httpRequest->getPort());
        $this->assertEquals($this->queryParameters, $httpRequest->getQueryParameters());
        $this->assertNull($httpRequest->getRequestParameters());

    }

    public function testFromDataToHttpRequest_withRequestParameters_Success() {

        $httpRequest = $this->adapter->fromDataToHttpRequest($this->dataWithRequestParameters);

        $this->assertEquals($this->uri, $httpRequest->getUri());
        $this->assertEquals($this->method, $httpRequest->getMethod());
        $this->assertEquals($this->port, $httpRequest->getPort());
        $this->assertNull($httpRequest->getQueryParameters());
        $this->assertEquals($this->requestParameters, $httpRequest->getRequestParameters());

    }

    public function testFromDataToHttpRequest_withQueryParameters_withRequestParameters_Success() {

        $httpRequest = $this->adapter->fromDataToHttpRequest($this->dataWithParameters);

        $this->assertEquals($this->uri, $httpRequest->getUri());
        $this->assertEquals($this->method, $httpRequest->getMethod());
        $this->assertEquals($this->port, $httpRequest->getPort());
        $this->assertEquals($this->queryParameters, $httpRequest->getQueryParameters());
        $this->assertEquals($this->requestParameters, $httpRequest->getRequestParameters());

    }

    public function testFromDataToHttpRequest_withoutUriIndex_Success() {

        $asserted = false;
        try {

            unset($this->data['uri']);
            $this->adapter->fromDataToHttpRequest($this->data);

        } catch (HttpException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToHttpRequest_withoutMethodIndex_Success() {

        $asserted = false;
        try {

            unset($this->data['method']);
            $this->adapter->fromDataToHttpRequest($this->data);

        } catch (HttpException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

    public function testFromDataToHttpRequest_withoutPortIndex_Success() {

        $asserted = false;
        try {

            unset($this->data['port']);
            $this->adapter->fromDataToHttpRequest($this->data);

        } catch (HttpException $exception) {
            $asserted = true;
        }

        $this->assertTrue($asserted);

    }

}

<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Https\Tests\Tests\Unit\Helpers;
use iRESTful\LeoPaul\Objects\Libraries\Https\Tests\Helpers\Objects\HttpRouteHelper;

final class HttpRouteHelperTest extends \PHPUnit_Framework_TestCase {
    private $httpRouteMock;
    private $method;
    private $endpoint;
    private $className;
    private $helper;
    public function setUp() {
        $this->httpRouteMock = $this->createMock('iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Routes\HttpRoute');

        $this->methodName = 'get';
        $this->endpoint = '/my/endpoint';
        $this->className = 'iRESTful\LeoPaul\Objects\Libraries\Https\Tests\Tests\Unit\Helpers\HttpRouteHelperTest';

        $this->helper = new HttpRouteHelper($this, $this->httpRouteMock);
    }

    public function tearDown() {

    }

    public function testGetMethod_Success() {

        $this->helper->expectsGetMethod_Success($this->method);

        $method = $this->httpRouteMock->getMethod();

        $this->assertEquals($this->method, $method);

    }

    public function testGetEndpoint_Success() {

        $this->helper->expectsGetEndpoint_Success($this->endpoint);

        $endpoint = $this->httpRouteMock->getEndpoint();

        $this->assertEquals($this->endpoint, $endpoint);

    }

    public function testGetClassName_Success() {

        $this->helper->expectsGetClassName_Success($this->className);

        $className = $this->httpRouteMock->getClassName();

        $this->assertEquals($this->className, $className);

    }

}

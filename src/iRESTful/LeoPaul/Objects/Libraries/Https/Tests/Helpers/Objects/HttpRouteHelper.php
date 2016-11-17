<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Https\Tests\Helpers\Objects;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Routes\HttpRoute;

final class HttpRouteHelper {
    private $phpunit;
    private $httpRouteMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, HttpRoute $httpRouteMock) {
        $this->phpunit = $phpunit;
        $this->httpRouteMock = $httpRouteMock;
    }

    public function expectsGetMethod_Success($returnedMethod) {
        $this->httpRouteMock->expects($this->phpunit->once())
                            ->method('getMethod')
                            ->will($this->phpunit->returnValue($returnedMethod));
    }

    public function expectsGetEndpoint_Success($returnedEndpoint) {
        $this->httpRouteMock->expects($this->phpunit->once())
                            ->method('getEndpoint')
                            ->will($this->phpunit->returnValue($returnedEndpoint));
    }

    public function expectsGetClassName_Success($returnedClassName) {
        $this->httpRouteMock->expects($this->phpunit->once())
                            ->method('getClassName')
                            ->will($this->phpunit->returnValue($returnedClassName));
    }

}

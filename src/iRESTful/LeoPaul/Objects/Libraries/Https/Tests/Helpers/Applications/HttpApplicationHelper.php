<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Https\Tests\Helpers\Applications;
use iRESTful\LeoPaul\Objects\Libraries\Https\Applications\HttpApplication;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Responses\HttpResponse;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Exceptions\HttpException;

final class HttpApplicationHelper {
    private $phpunit;
    private $httpApplicationMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, HttpApplication $httpApplicationMock) {
        $this->phpunit = $phpunit;
        $this->httpApplicationMock = $httpApplicationMock;
    }

    public function expectsExecute_Success(HttpResponse $returnedResponse, array $httpRequest) {
        $this->httpApplicationMock->expects($this->phpunit->once())
                                    ->method('execute')
                                    ->with($httpRequest)
                                    ->will($this->phpunit->returnValue($returnedResponse));
    }

    public function expectsExecute_throwsHttpException(array $httpRequest) {
        $this->httpApplicationMock->expects($this->phpunit->once())
                                    ->method('execute')
                                    ->with($httpRequest)
                                    ->will($this->phpunit->throwException(new HttpException('TEST')));
    }

}

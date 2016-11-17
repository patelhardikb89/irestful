<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Helpers\Objects;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Requests\Request;

final class RequestHelper {
    private $phpunit;
    private $requestMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, Request $requestMock) {
        $this->phpunit = $phpunit;
        $this->requestMock = $requestMock;
    }

    public function expectsGetQuery_Success($returnedQuery) {
        $this->requestMock->expects($this->phpunit->once())
                            ->method('getQuery')
                            ->will($this->phpunit->returnValue($returnedQuery));
    }

    public function expectsHasParams_Success($returnedBoolean) {
        $this->requestMock->expects($this->phpunit->once())
                            ->method('hasParams')
                            ->will($this->phpunit->returnValue($returnedBoolean));
    }

    public function expectsGetParams_Success(array $returnedParams) {
        $this->requestMock->expects($this->phpunit->once())
                            ->method('getParams')
                            ->will($this->phpunit->returnValue($returnedParams));
    }

}

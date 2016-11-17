<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Adapters\RequestAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Exceptions\RequestException;

final class RequestAdapterHelper {
    private $phpunit;
    private $requestAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, RequestAdapter $requestAdapterMock) {
        $this->phpunit = $phpunit;
        $this->requestAdapterMock = $requestAdapterMock;
    }

    public function expectsFromDataToEntityRequest_Success(array $returnedRequest, array $data) {
        $this->requestAdapterMock->expects($this->phpunit->once())
                                    ->method('fromDataToEntityRequest')
                                    ->with($data)
                                    ->will($this->phpunit->returnValue($returnedRequest));
    }

    public function expectsFromDataToEntityRequest_throwsRequestException(array $data) {
        $this->requestAdapterMock->expects($this->phpunit->once())
                                    ->method('fromDataToEntityRequest')
                                    ->with($data)
                                    ->will($this->phpunit->throwException(new RequestException('TEST')));
    }

}

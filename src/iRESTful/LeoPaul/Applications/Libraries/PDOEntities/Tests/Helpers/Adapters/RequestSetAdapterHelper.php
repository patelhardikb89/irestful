<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Sets\Adapters\RequestSetAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Sets\Exceptions\RequestSetException;

final class RequestSetAdapterHelper {
    private $phpunit;
    private $requestSetAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, RequestSetAdapter $requestSetAdapterMock) {
        $this->phpunit = $phpunit;
        $this->requestSetAdapterMock = $requestSetAdapterMock;
    }

    public function expectsFromDataToEntitySetRequest_Success(array $returnedRequest, array $data) {
        $this->requestSetAdapterMock->expects($this->phpunit->once())
                                    ->method('fromDataToEntitySetRequest')
                                    ->with($data)
                                    ->will($this->phpunit->returnValue($returnedRequest));
    }

    public function expectsFromDataToEntitySetRequest_throwsRequestSetException(array $data) {
        $this->requestSetAdapterMock->expects($this->phpunit->once())
                                    ->method('fromDataToEntitySetRequest')
                                    ->with($data)
                                    ->will($this->phpunit->throwException(new RequestSetException('TEST')));
    }
}

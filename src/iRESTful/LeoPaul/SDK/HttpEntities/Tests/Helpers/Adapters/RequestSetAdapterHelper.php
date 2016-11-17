<?php
namespace iRESTful\LeoPaul\SDK\HttpEntities\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\SDK\HttpEntities\Domain\Requests\Sets\Adapters\RequestSetAdapter;
use iRESTful\LeoPaul\SDK\HttpEntities\Domain\Requests\Sets\Exceptions\RequestSetException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Sets\Repositories\Criterias\EntitySetRetrieverCriteria;

final class RequestSetAdapterHelper {
    private $phpunit;
    private $requestSetAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, RequestSetAdapter $requestSetAdapterMock) {
        $this->phpunit = $phpunit;
        $this->requestSetAdapterMock = $requestSetAdapterMock;
    }

    public function expectsFromDataToEntitySetHttpRequestData_Success(array $returnedHttpRequest, array $data) {
        $this->requestSetAdapterMock->expects($this->phpunit->once())
                                        ->method('fromDataToEntitySetHttpRequestData')
                                        ->with($data)
                                        ->will($this->phpunit->returnValue($returnedHttpRequest));
    }

    public function expectsFromDataToEntitySetHttpRequestData_throwsRequestSetException(array $data) {
        $this->requestSetAdapterMock->expects($this->phpunit->once())
                                        ->method('fromDataToEntitySetHttpRequestData')
                                        ->with($data)
                                        ->will($this->phpunit->throwException(new RequestSetException('TEST')));
    }

}

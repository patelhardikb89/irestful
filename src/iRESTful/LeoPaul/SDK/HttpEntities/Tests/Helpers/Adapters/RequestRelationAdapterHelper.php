<?php
namespace iRESTful\LeoPaul\SDK\HttpEntities\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\SDK\HttpEntities\Domain\Requests\Relations\Adapters\RequestRelationAdapter;
use iRESTful\LeoPaul\SDK\HttpEntities\Domain\Requests\Relations\Exceptions\RequestRelationException;

final class RequestRelationAdapterHelper {
    private $phpunit;
    private $requestRelationAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, RequestRelationAdapter $requestRelationAdapterMock) {
        $this->phpunit = $phpunit;
        $this->requestRelationAdapterMock = $requestRelationAdapterMock;
    }

    public function expectsFromDataToEntityRelationHttpRequestData_Success(array $returnedHttpRequest, array $data) {
        $this->requestRelationAdapterMock->expects($this->phpunit->once())
                                            ->method('fromDataToEntityRelationHttpRequestData')
                                            ->with($data)
                                            ->will($this->phpunit->returnValue($returnedHttpRequest));
    }

    public function expectsFromDataToEntityRelationHttpRequestData_throwsRequestRelationException(array $data) {
        $this->requestRelationAdapterMock->expects($this->phpunit->once())
                                            ->method('fromDataToEntityRelationHttpRequestData')
                                            ->with($data)
                                            ->will($this->phpunit->throwException(new RequestRelationException('TEST')));
    }

}

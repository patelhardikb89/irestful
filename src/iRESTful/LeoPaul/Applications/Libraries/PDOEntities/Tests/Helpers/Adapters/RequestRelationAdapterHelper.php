<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Relations\Adapters\RequestRelationAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Relations\Exceptions\RequestRelationException;

final class RequestRelationAdapterHelper {
    private $phpunit;
    private $requestRelationAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, RequestRelationAdapter $requestRelationAdapterMock) {
        $this->phpunit = $phpunit;
        $this->requestRelationAdapterMock = $requestRelationAdapterMock;
    }

    public function expectsFromDataToEntityRelationRequest_Success(array $returnedRequest, array $criteria) {
        $this->requestRelationAdapterMock->expects($this->phpunit->once())
                                            ->method('fromDataToEntityRelationRequest')
                                            ->with($criteria)
                                            ->will($this->phpunit->returnValue($returnedRequest));
    }

    public function expectsFromDataToEntityRelationRequest_throwsRequestRelationException(array $criteria) {
        $this->requestRelationAdapterMock->expects($this->phpunit->once())
                                            ->method('fromDataToEntityRelationRequest')
                                            ->with($criteria)
                                            ->will($this->phpunit->throwException(new RequestRelationException('TEST')));
    }

}

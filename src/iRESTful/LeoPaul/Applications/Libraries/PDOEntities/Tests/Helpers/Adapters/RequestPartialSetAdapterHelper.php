<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Sets\Partials\Adapters\RequestPartialSetAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\Requests\Sets\Partials\Exceptions\RequestPartialSetException;

final class RequestPartialSetAdapterHelper {
    private $phpunit;
    private $requestPartialSetAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, RequestPartialSetAdapter $requestPartialSetAdapterMock) {
        $this->phpunit = $phpunit;
        $this->requestPartialSetAdapterMock = $requestPartialSetAdapterMock;
    }

    public function expectsFromDataToEntityPartialSetRequest_Success(array $returnedRequest, array $criteria) {
        $this->requestPartialSetAdapterMock->expects($this->phpunit->once())
                                            ->method('fromDataToEntityPartialSetRequest')
                                            ->with($criteria)
                                            ->will($this->phpunit->returnValue($returnedRequest));
    }

    public function expectsFromDataToEntityPartialSetRequest_throwsRequestPartialSetException(array $criteria) {
        $this->requestPartialSetAdapterMock->expects($this->phpunit->once())
                                            ->method('fromDataToEntityPartialSetRequest')
                                            ->with($criteria)
                                            ->will($this->phpunit->throwException(new RequestPartialSetException('TEST')));
    }

    public function expectsFromDataToEntityPartialSetTotalAmountRequest_Success(array $returnedRequest, array $criteria) {
        $this->requestPartialSetAdapterMock->expects($this->phpunit->once())
                                            ->method('fromDataToEntityPartialSetTotalAmountRequest')
                                            ->with($criteria)
                                            ->will($this->phpunit->returnValue($returnedRequest));
    }

}

<?php
namespace iRESTful\LeoPaul\SDK\HttpEntities\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\SDK\HttpEntities\Domain\Requests\Sets\Partials\Adapters\RequestPartialSetAdapter;
use iRESTful\LeoPaul\SDK\HttpEntities\Domain\Requests\Sets\Partials\Exceptions\RequestPartialSetException;

final class RequestPartialSetAdapterHelper {
    private $phpunit;
    private $requestPartialSetAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, RequestPartialSetAdapter $requestPartialSetAdapterMock) {
        $this->phpunit = $phpunit;
        $this->requestPartialSetAdapterMock = $requestPartialSetAdapterMock;
    }

    public function expectsFromDataToEntityPartialSetHttpRequestData_Success(array $returnedHttpRequest, array $data) {
        $this->requestPartialSetAdapterMock->expects($this->phpunit->once())
                                            ->method('fromDataToEntityPartialSetHttpRequestData')
                                            ->with($data)
                                            ->will($this->phpunit->returnValue($returnedHttpRequest));
    }

    public function expectsFromDataToEntityPartialSetHttpRequestData_throwsRequestPartialSetException(array $data) {
        $this->requestPartialSetAdapterMock->expects($this->phpunit->once())
                                            ->method('fromDataToEntityPartialSetHttpRequestData')
                                            ->with($data)
                                            ->will($this->phpunit->throwException(new RequestPartialSetException('TEST')));
    }

}

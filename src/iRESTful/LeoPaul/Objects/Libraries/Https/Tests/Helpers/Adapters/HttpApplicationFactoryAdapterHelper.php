<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Https\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\Https\Applications\Factories\Adapters\HttpApplicationFactoryAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Https\Applications\Factories\HttpApplicationFactory;
use iRESTful\LeoPaul\Objects\Libraries\Https\Domain\Exceptions\HttpException;

final class HttpApplicationFactoryAdapterHelper {
    private $phpunit;
    private $httpApplicationFactoryAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, HttpApplicationFactoryAdapter $httpApplicationFactoryAdapterMock) {
        $this->phpunit = $phpunit;
        $this->httpApplicationFactoryAdapterMock = $httpApplicationFactoryAdapterMock;
    }

    public function expectsFromDataToHttpApplicationFactory_Success(HttpApplicationFactory $returnedFactory, array $data) {
        $this->httpApplicationFactoryAdapterMock->expects($this->phpunit->once())
                                                ->method('fromDataToHttpApplicationFactory')
                                                ->with($data)
                                                ->will($this->phpunit->returnValue($returnedFactory));
    }

    public function expectsFromDataToHttpApplicationFactory_throwsHttpException(array $data) {
        $this->httpApplicationFactoryAdapterMock->expects($this->phpunit->once())
                                                ->method('fromDataToHttpApplicationFactory')
                                                ->with($data)
                                                ->will($this->phpunit->throwException(new HttpException('TEST')));
    }

}

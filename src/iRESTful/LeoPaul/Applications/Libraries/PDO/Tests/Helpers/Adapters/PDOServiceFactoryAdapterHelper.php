<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Services\Factories\Adapters\PDOServiceFactoryAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Services\Factories\PDOServiceFactory;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Exceptions\PDOException;

final class PDOServiceFactoryAdapterHelper {
    private $phpunit;
    private $pdoServiceFactoryAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, PDOServiceFactoryAdapter $pdoServiceFactoryAdapterMock) {
        $this->phpunit = $phpunit;
        $this->pdoServiceFactoryAdapterMock = $pdoServiceFactoryAdapterMock;
    }

    public function expectsFromDataToPDOServiceFactory_Success(PDOServiceFactory $returnedFactory, array $data) {
        $this->pdoServiceFactoryAdapterMock->expects($this->phpunit->once())
                                            ->method('fromDataToPDOServiceFactory')
                                            ->with($data)
                                            ->will($this->phpunit->returnValue($returnedFactory));
    }

    public function expectsFromDataToPDOServiceFactory_throwsPDOException(array $data) {
        $this->pdoServiceFactoryAdapterMock->expects($this->phpunit->once())
                                            ->method('fromDataToPDOServiceFactory')
                                            ->with($data)
                                            ->will($this->phpunit->throwException(new PDOException('TEST')));
    }

}

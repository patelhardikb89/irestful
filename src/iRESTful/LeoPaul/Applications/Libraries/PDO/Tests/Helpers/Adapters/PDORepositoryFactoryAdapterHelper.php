<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Repositories\Factories\Adapters\PDORepositoryFactoryAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Repositories\Factories\PDORepositoryFactory;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Exceptions\PDOException;

final class PDORepositoryFactoryAdapterHelper {
    private $phpunit;
    private $pdoRepositoryFactoryAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, PDORepositoryFactoryAdapter $pdoRepositoryFactoryAdapterMock) {
        $this->phpunit = $phpunit;
        $this->pdoRepositoryFactoryAdapterMock = $pdoRepositoryFactoryAdapterMock;
    }

    public function expectsFromDataToPDORepositoryFactory_Success(PDORepositoryFactory $returnedFactory, array $data) {
        $this->pdoRepositoryFactoryAdapterMock->expects($this->phpunit->once())
                                                ->method('fromDataToPDORepositoryFactory')
                                                ->with($data)
                                                ->will($this->phpunit->returnValue($returnedFactory));
    }

    public function expectsFromDataToPDORepositoryFactory_throwsPDOException(array $data) {
        $this->pdoRepositoryFactoryAdapterMock->expects($this->phpunit->once())
                                                ->method('fromDataToPDORepositoryFactory')
                                                ->with($data)
                                                ->will($this->phpunit->throwException(new PDOException('TEST')));
    }

}

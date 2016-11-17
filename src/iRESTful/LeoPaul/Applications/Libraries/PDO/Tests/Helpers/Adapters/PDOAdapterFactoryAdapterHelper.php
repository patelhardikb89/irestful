<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Adapters\Factories\Adapters\PDOAdapterFactoryAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Adapters\Factories\PDOAdapterFactory;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Exceptions\PDOException;

final class PDOAdapterFactoryAdapterHelper {
    private $phpunit;
    private $pdoAdapterFactoryAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, PDOAdapterFactoryAdapter $pdoAdapterFactoryAdapterMock) {
        $this->phpunit = $phpunit;
        $this->pdoAdapterFactoryAdapterMock = $pdoAdapterFactoryAdapterMock;
    }

    public function expectsFromDataToPDOAdapterFactory_Success(PDOAdapterFactory $returnedFactory, array $data) {
        $this->pdoAdapterFactoryAdapterMock->expects($this->phpunit->once())
                                            ->method('fromDataToPDOAdapterFactory')
                                            ->with($data)
                                            ->will($this->phpunit->returnValue($returnedFactory));
    }

    public function expectsFromDataToPDOAdapterFactory_throwsPDOException(array $data) {
        $this->pdoAdapterFactoryAdapterMock->expects($this->phpunit->once())
                                            ->method('fromDataToPDOAdapterFactory')
                                            ->with($data)
                                            ->will($this->phpunit->throwException(new PDOException('TEST')));
    }

}

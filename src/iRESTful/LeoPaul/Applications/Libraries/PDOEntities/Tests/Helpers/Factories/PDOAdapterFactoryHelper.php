<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Tests\Helpers\Factories;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\PDO\Adapters\Factories\PDOAdapterFactory;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\PDO\Adapters\PDOAdapter;

final class PDOAdapterFactoryHelper {
    private $phpunit;
    private $pdoAdapterFactoryMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, PDOAdapterFactory $pdoAdapterFactoryMock) {
        $this->phpunit = $phpunit;
        $this->pdoAdapterFactoryMock = $pdoAdapterFactoryMock;
    }

    public function expectsCreate_Success(PDOAdapter $returnedPDOAdapter) {
        $this->pdoAdapterFactoryMock->expects($this->phpunit->once())
                                    ->method('create')
                                    ->will($this->phpunit->returnValue($returnedPDOAdapter));
    }

}

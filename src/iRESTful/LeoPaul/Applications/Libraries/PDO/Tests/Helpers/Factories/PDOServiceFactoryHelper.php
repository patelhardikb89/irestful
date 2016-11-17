<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Helpers\Factories;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Services\Factories\PDOServiceFactory;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Services\PDOService;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Exceptions\PDOException;

final class PDOServiceFactoryHelper {
    private $phpunit;
    private $pdoServiceFactoryMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, PDOServiceFactory $pdoServiceFactoryMock) {
        $this->phpunit = $phpunit;
        $this->pdoServiceFactoryMock = $pdoServiceFactoryMock;
    }

    public function expectsCreate_Success(PDOService $returnedPDOService) {
        $this->pdoServiceFactoryMock->expects($this->phpunit->once())
                                        ->method('create')
                                        ->will($this->phpunit->returnValue($returnedPDOService));
    }

    public function expectsCreate_throwsPDOException() {
        $this->pdoServiceFactoryMock->expects($this->phpunit->once())
                                        ->method('create')
                                        ->will($this->phpunit->throwException(new PDOException('TEST')));
    }

}

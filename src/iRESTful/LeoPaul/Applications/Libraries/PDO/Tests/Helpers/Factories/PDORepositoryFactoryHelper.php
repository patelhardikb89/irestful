<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Helpers\Factories;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Repositories\Factories\PDORepositoryFactory;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Repositories\PDORepository;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Exceptions\PDOException;

final class PDORepositoryFactoryHelper {
    private $phpunit;
    private $pdoRepositoryFactoryMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, PDORepositoryFactory $pdoRepositoryFactoryMock) {
        $this->phpunit = $phpunit;
        $this->pdoRepositoryFactoryMock = $pdoRepositoryFactoryMock;
    }

    public function expectsCreate_Success(PDORepository $returnedPDORepository) {
        $this->pdoRepositoryFactoryMock->expects($this->phpunit->once())
                                        ->method('create')
                                        ->will($this->phpunit->returnValue($returnedPDORepository));
    }

    public function expectsCreate_throwsPDOException() {
        $this->pdoRepositoryFactoryMock->expects($this->phpunit->once())
                                        ->method('create')
                                        ->will($this->phpunit->throwException(new PDOException('TEST')));
    }

}

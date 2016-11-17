<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Helpers\Repositories;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Repositories\PDORepository;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\PDO;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Exceptions\PDOException;

final class PDORepositoryHelper {
    private $phpunit;
    private $pdoRepositoryMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, PDORepository $pdoRepositoryMock) {
        $this->phpunit = $phpunit;
        $this->pdoRepositoryMock = $pdoRepositoryMock;
    }

    public function expectsFetch_Success(PDO $returnedPDO, array $data) {
        $this->pdoRepositoryMock->expects($this->phpunit->once())
                                ->method('fetch')
                                ->with($data)
                                ->will($this->phpunit->returnValue($returnedPDO));
    }

    public function expectsFetch_throwsPDOException(array $data) {
        $this->pdoRepositoryMock->expects($this->phpunit->once())
                                ->method('fetch')
                                ->with($data)
                                ->will($this->phpunit->throwException(new PDOException('TEST')));
    }

    public function expectsFetchFirst_Success(PDO $returnedPDO, array $data) {
        $this->pdoRepositoryMock->expects($this->phpunit->once())
                                ->method('fetchFirst')
                                ->with($data)
                                ->will($this->phpunit->returnValue($returnedPDO));
    }

    public function expectsFetchFirst_throwsPDOException(array $data) {
        $this->pdoRepositoryMock->expects($this->phpunit->once())
                                ->method('fetchFirst')
                                ->with($data)
                                ->will($this->phpunit->throwException(new PDOException('TEST')));
    }

}

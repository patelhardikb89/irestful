<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDO\Tests\Helpers\Services;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Services\PDOService;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\PDO;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\Exceptions\PDOException;

final class PDOServiceHelper {
    private $phpunit;
    private $pdoServiceMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, PDOService $pdoServiceMock) {
        $this->phpunit = $phpunit;
        $this->pdoServiceMock = $pdoServiceMock;
    }

    public function expectsQuery_Success(PDO $returnedPDO, array $data) {
        $this->pdoServiceMock->expects($this->phpunit->once())
                                ->method('query')
                                ->with($data)
                                ->will($this->phpunit->returnValue($returnedPDO));
    }

    public function expectsQuery_throwsPDOException(array $data) {
        $this->pdoServiceMock->expects($this->phpunit->once())
                                ->method('query')
                                ->with($data)
                                ->will($this->phpunit->throwException(new PDOException('TEST')));
    }

    public function expectsQueries_Success(PDO $returnedPDO, array $data) {
        $this->pdoServiceMock->expects($this->phpunit->once())
                                ->method('queries')
                                ->with($data)
                                ->will($this->phpunit->returnValue($returnedPDO));
    }

    public function expectsQueries_throwsPDOException(array $data) {
        $this->pdoServiceMock->expects($this->phpunit->once())
                                ->method('queries')
                                ->with($data)
                                ->will($this->phpunit->throwException(new PDOException('TEST')));
    }

}

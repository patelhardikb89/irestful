<?php
namespace iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\PDO\Adapters\PDOAdapter;
use iRESTful\LeoPaul\Applications\Libraries\PDO\Domain\PDO;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity;
use iRESTful\LeoPaul\Applications\Libraries\PDOEntities\Domain\PDO\Exceptions\PDOException;

final class PDOAdapterHelper {
    private $phpunit;
    private $pdoAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, PDOAdapter $pdoAdapterMock) {
        $this->phpunit = $phpunit;
        $this->pdoAdapterMock = $pdoAdapterMock;
    }

    public function expectsFromPDOToEntity_Success(Entity $returnedEntity, PDO $pdo, $container) {
        $this->pdoAdapterMock->expects($this->phpunit->once())
                                ->method('fromPDOToEntity')
                                ->with($pdo, $container)
                                ->will($this->phpunit->returnValue($returnedEntity));
    }

    public function expectsFromPDOToEntity_withoutResults_Success(PDO $pdo, $container) {
        $this->pdoAdapterMock->expects($this->phpunit->once())
                                ->method('fromPDOToEntity')
                                ->with($pdo, $container)
                                ->will($this->phpunit->returnValue(null));
    }

    public function expectsFromPDOToEntity_throwsPDOException(PDO $pdo, $container) {
        $this->pdoAdapterMock->expects($this->phpunit->once())
                                ->method('fromPDOToEntity')
                                ->with($pdo, $container)
                                ->will($this->phpunit->throwException(new PDOException('TEST')));
    }

    public function expectsFromPDOToEntities_Success(array $returnedEntities, PDO $pdo, $container) {
        $this->pdoAdapterMock->expects($this->phpunit->once())
                                ->method('fromPDOToEntities')
                                ->with($pdo, $container)
                                ->will($this->phpunit->returnValue($returnedEntities));
    }

    public function expectsFromPDOToEntities_withoutResults_Success(PDO $pdo, $container) {
        $this->pdoAdapterMock->expects($this->phpunit->once())
                                ->method('fromPDOToEntities')
                                ->with($pdo, $container)
                                ->will($this->phpunit->returnValue(null));
    }

    public function expectsFromPDOToEntities_throwsPDOException(PDO $pdo, $container) {
        $this->pdoAdapterMock->expects($this->phpunit->once())
                                ->method('fromPDOToEntities')
                                ->with($pdo, $container)
                                ->will($this->phpunit->throwException(new PDOException('TEST')));
    }

    public function expectsFromPDOToResults_Success(array $returnedResults, PDO $pdo, $container) {
        $this->pdoAdapterMock->expects($this->phpunit->once())
                                ->method('fromPDOToResults')
                                ->with($pdo, $container)
                                ->will($this->phpunit->returnValue($returnedResults));
    }

    public function expectsFromPDOToResults_throwsPDOException(PDO $pdo, $container) {
        $this->pdoAdapterMock->expects($this->phpunit->once())
                                ->method('fromPDOToResults')
                                ->with($pdo, $container)
                                ->will($this->phpunit->throwException(new PDOException('TEST')));
    }

}

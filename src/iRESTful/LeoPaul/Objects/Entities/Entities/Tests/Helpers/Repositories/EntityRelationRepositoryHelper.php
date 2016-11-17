<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Repositories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\EntityRelationRepository;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Exceptions\EntityRelationException;

final class EntityRelationRepositoryHelper {
    private $phpunit;
    private $entityRelationRepositoryMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, EntityRelationRepository $entityRelationRepositoryMock) {
        $this->phpunit = $phpunit;
        $this->entityRelationRepositoryMock = $entityRelationRepositoryMock;
    }

    public function expectsRetrieve_Success(array $returnedEntities, array $criteria) {
        $this->entityRelationRepositoryMock->expects($this->phpunit->once())
                                            ->method('retrieve')
                                            ->with($criteria)
                                            ->will($this->phpunit->returnValue($returnedEntities));
    }

    public function expectsRetrieve_throwsEntityRelationException(array $criteria) {
        $this->entityRelationRepositoryMock->expects($this->phpunit->once())
                                            ->method('retrieve')
                                            ->with($criteria)
                                            ->will($this->phpunit->throwException(new EntityRelationException('TEST')));
    }

}

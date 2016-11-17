<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Factories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\Factories\EntityRelationRepositoryFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\EntityRelationRepository;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Exceptions\EntityRelationException;

final class EntityRelationRepositoryFactoryHelper {
    private $phpunit;
    private $entityRelationRepositoryFactoryMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, EntityRelationRepositoryFactory $entityRelationRepositoryFactoryMock) {
        $this->phpunit = $phpunit;
        $this->entityRelationRepositoryFactoryMock = $entityRelationRepositoryFactoryMock;
    }

    public function expectsCreate_Success(EntityRelationRepository $returnedEntityRelationRepository) {
        $this->entityRelationRepositoryFactoryMock->expects($this->phpunit->once())
                                                    ->method('create')
                                                    ->will($this->phpunit->returnValue($returnedEntityRelationRepository));
    }

    public function expectsCreate_throwsEntityRelationException() {
        $this->entityRelationRepositoryFactoryMock->expects($this->phpunit->once())
                                                    ->method('create')
                                                    ->will($this->phpunit->throwException(new EntityRelationException('TEST')));
    }

}

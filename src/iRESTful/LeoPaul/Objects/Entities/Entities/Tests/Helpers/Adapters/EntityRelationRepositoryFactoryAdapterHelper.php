<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\Factories\Adapters\EntityRelationRepositoryFactoryAdapter;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Repositories\Factories\EntityRelationRepositoryFactory;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Relations\Exceptions\EntityRelationException;

final class EntityRelationRepositoryFactoryAdapterHelper {
    private $phpunit;
    private $entityRelationRepositoryFactoryAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, EntityRelationRepositoryFactoryAdapter $entityRelationRepositoryFactoryAdapterMock) {
        $this->phpunit = $phpunit;
        $this->entityRelationRepositoryFactoryAdapterMock = $entityRelationRepositoryFactoryAdapterMock;
    }

    public function expectsFromDataToEntityRelationRepositoryFactory_Success(EntityRelationRepositoryFactory $returnedFactory, array $data) {
        $this->entityRelationRepositoryFactoryAdapterMock->expects($this->phpunit->once())
                                                            ->method('fromDataToEntityRelationRepositoryFactory')
                                                            ->with($data)
                                                            ->will($this->phpunit->returnValue($returnedFactory));
    }

    public function expectsFromDataToEntityRelationRepositoryFactory_throwsEntityRelationException(array $data) {
        $this->entityRelationRepositoryFactoryAdapterMock->expects($this->phpunit->once())
                                                            ->method('fromDataToEntityRelationRepositoryFactory')
                                                            ->with($data)
                                                            ->will($this->phpunit->throwException(new EntityRelationException('TEST')));
    }

}

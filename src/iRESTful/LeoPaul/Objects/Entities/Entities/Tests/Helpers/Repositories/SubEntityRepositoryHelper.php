<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Repositories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Subs\Repositories\SubEntityRepository;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Subs\Exceptions\SubEntityException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Subs\SubEntities;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity;

final class SubEntityRepositoryHelper {
    private $phpunit;
    private $subEntityRepositoryMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, SubEntityRepository $subEntityRepositoryMock) {
        $this->phpunit = $phpunit;
        $this->subEntityRepositoryMock = $subEntityRepositoryMock;
    }

    public function expectsRetrieve_Success(SubEntities $returnedSubEntities, Entity $entity) {
        $this->subEntityRepositoryMock->expects($this->phpunit->once())
                                        ->method('retrieve')
                                        ->with($entity)
                                        ->will($this->phpunit->returnValue($returnedSubEntities));
    }

    public function expectsRetrieve_returnsNull_Success(Entity $entity) {
        $this->subEntityRepositoryMock->expects($this->phpunit->once())
                                        ->method('retrieve')
                                        ->with($entity)
                                        ->will($this->phpunit->returnValue(null));
    }

    public function expectsRetrieve_multiple_Success(array $returnedSubEntities, array $entities) {
        foreach($returnedSubEntities as $index => $oneSubEntities) {
            $this->subEntityRepositoryMock->expects($this->phpunit->at($index))
                                            ->method('retrieve')
                                            ->with($entities[$index])
                                            ->will($this->phpunit->returnValue($oneSubEntities));
        }
    }

    public function expectsRetrieve_throwsSubEntityException(Entity $entity) {
        $this->subEntityRepositoryMock->expects($this->phpunit->once())
                                        ->method('retrieve')
                                        ->with($entity)
                                        ->will($this->phpunit->throwException(new SubEntityException('TEST')));
    }

}

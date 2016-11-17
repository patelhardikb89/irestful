<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Repositories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Repositories\EntityRepository;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\EntityException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Exceptions\OutputEntityException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity;

final class EntityRepositoryHelper {
    private $phpunit;
    private $entityRepositoryMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, EntityRepository $entityRepositoryMock) {
        $this->phpunit = $phpunit;
        $this->entityRepositoryMock = $entityRepositoryMock;
    }

    public function expectsExists_Success($returnedBoolean, array $criteria) {
        $this->entityRepositoryMock->expects($this->phpunit->once())
                                    ->method('exists')
                                    ->will($this->phpunit->returnValue($returnedBoolean));
    }

    public function expectsExists_multiple_Success(array $returnedBooleans, array $criterias) {
        foreach($returnedBooleans as $index => $oneReturnedBoolean) {
            $this->entityRepositoryMock->expects($this->phpunit->at($index))
                            ->method('exists')
                            ->with($criterias[$index])
                            ->will($this->phpunit->returnValue($oneReturnedBoolean));
        }
    }

    public function expectsExists_throwsEntityException(array $criteria) {
        $this->entityRepositoryMock->expects($this->phpunit->once())
                                    ->method('exists')
                                    ->will($this->phpunit->throwException(new EntityException('TEST')));
    }

    public function expectsRetrieve_Success(Entity $returnedEntity, array $criteria) {
        $this->entityRepositoryMock->expects($this->phpunit->once())
                                    ->method('retrieve')
                                    ->will($this->phpunit->returnValue($returnedEntity));
    }

    public function expectsRetrieve_returnedNull_Success(array $criteria) {
        $this->entityRepositoryMock->expects($this->phpunit->once())
                                    ->method('retrieve')
                                    ->will($this->phpunit->returnValue(null));
    }

    public function expectsRetrieve_throwsEntityException(array $criteria) {
        $this->entityRepositoryMock->expects($this->phpunit->once())
                                    ->method('retrieve')
                                    ->will($this->phpunit->throwException(new EntityException('TEST')));
    }

    public function expectsRetrieve_throwsOutputEntityException(array $criteria) {
        $this->entityRepositoryMock->expects($this->phpunit->once())
                                    ->method('retrieve')
                                    ->will($this->phpunit->throwException(new OutputEntityException('TEST', 200)));
    }

}

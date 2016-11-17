<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Repositories;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Subs\Sets\Repositories\SubEntitySetRepository;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Subs\Exceptions\SubEntityException;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Subs\SubEntities;

final class SubEntitySetRepositoryHelper {
    private $phpunit;
    private $subEntitySetRepositoryMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, SubEntitySetRepository $subEntitySetRepositoryMock) {
        $this->phpunit = $phpunit;
        $this->subEntitySetRepositoryMock = $subEntitySetRepositoryMock;
    }

    public function expectsRetrieve_Success(SubEntities $returnedSubEntities, array $entities) {
        $this->subEntitySetRepositoryMock->expects($this->phpunit->once())
                                            ->method('retrieve')
                                            ->with($entities)
                                            ->will($this->phpunit->returnValue($returnedSubEntities));
    }

    public function expectsRetrieve_returnsNull_Success(array $entities) {
        $this->subEntitySetRepositoryMock->expects($this->phpunit->once())
                                            ->method('retrieve')
                                            ->with($entities)
                                            ->will($this->phpunit->returnValue(null));
    }

    public function expectsRetrieve_multiple_Success(array $returnedSubEntities, array $entities) {
        foreach($returnedSubEntities as $index => $oneSubEntities) {
            $this->subEntitySetRepositoryMock->expects($this->phpunit->at($index))
                                                ->method('retrieve')
                                                ->with($entities[$index])
                                                ->will($this->phpunit->returnValue($oneSubEntities));
        }
    }

    public function expectsRetrieve_throwsSubEntityException(array $entities) {
        $this->subEntitySetRepositoryMock->expects($this->phpunit->once())
                                            ->method('retrieve')
                                            ->with($entities)
                                            ->will($this->phpunit->throwException(new SubEntityException('TEST')));
    }

}

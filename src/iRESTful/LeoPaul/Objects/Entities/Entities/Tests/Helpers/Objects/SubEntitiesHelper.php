<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Objects;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Subs\SubEntities;

final class SubEntitiesHelper {
    private $phpunit;
    private $subEntitiesMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, SubEntities $subEntitiesMock) {
        $this->phpunit = $phpunit;
        $this->subEntitiesMock = $subEntitiesMock;
    }

    public function expectsHasExistingEntities_Success($returnedBoolean) {
        $this->subEntitiesMock->expects($this->phpunit->once())
                                ->method('hasExistingEntities')
                                ->will($this->phpunit->returnValue($returnedBoolean));
    }

    public function expectsGetExistingEntities_Success(array $returnedEntities) {
        $this->subEntitiesMock->expects($this->phpunit->once())
                                ->method('getExistingEntities')
                                ->will($this->phpunit->returnValue($returnedEntities));
    }

    public function expectsHasNewEntities_Success($returnedBoolean) {
        $this->subEntitiesMock->expects($this->phpunit->once())
                                ->method('hasNewEntities')
                                ->will($this->phpunit->returnValue($returnedBoolean));
    }

    public function expectsGetNewEntities_Success(array $returnedEntities) {
        $this->subEntitiesMock->expects($this->phpunit->once())
                                ->method('getNewEntities')
                                ->will($this->phpunit->returnValue($returnedEntities));
    }

    public function expectsMerge_Success(SubEntities $returnedSubEntities, SubEntities $subEntities) {
        $this->subEntitiesMock->expects($this->phpunit->once())
                                ->method('merge')
                                ->with($subEntities)
                                ->will($this->phpunit->returnValue($returnedSubEntities));
    }

    public function expectsDelete_Success(SubEntities $returnedSubEntities, SubEntities $subEntities) {
        $this->subEntitiesMock->expects($this->phpunit->once())
                                ->method('delete')
                                ->with($subEntities)
                                ->will($this->phpunit->returnValue($returnedSubEntities));
    }

}

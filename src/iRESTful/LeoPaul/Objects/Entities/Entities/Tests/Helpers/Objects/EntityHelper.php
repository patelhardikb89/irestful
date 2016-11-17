<?php
namespace iRESTful\LeoPaul\Objects\Entities\Entities\Tests\Helpers\Objects;
use iRESTful\LeoPaul\Objects\Entities\Entities\Domain\Entity;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Uuid;

final class EntityHelper {
    private $phpunit;
    private $entityMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, Entity $entityMock) {
        $this->phpunit = $phpunit;
        $this->entityMock = $entityMock;
    }

    public function expectsGetUuid_Success(Uuid $returnedUuid) {
        $this->entityMock->expects($this->phpunit->once())
                            ->method('getUuid')
                            ->will($this->phpunit->returnValue($returnedUuid));
    }

    public function expectsGetUuid_multiple_Success(array $returnedUuids) {
        foreach($returnedUuids as $index => $oneReturnedUuid) {
            $this->entityMock->expects($this->phpunit->at($index))
                                ->method('getUuid')
                                ->will($this->phpunit->returnValue($oneReturnedUuid));
        }
    }

    public function expectsCreatedOn_Success(\DateTime $returnedDateTime) {
        $this->entityMock->expects($this->phpunit->once())
                            ->method('createdOn')
                            ->will($this->phpunit->returnValue($returnedDateTime));
    }

}

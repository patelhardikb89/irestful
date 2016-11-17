<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Ids\Tests\Helpers\Objects;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Uuid;

final class UuidHelper {
    private $phpunit;
    private $uuidMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, Uuid $uuidMock) {
        $this->phpunit = $phpunit;
        $this->uuidMock = $uuidMock;
    }

    public function expectsGetHumanReadable_Success($returnedHumanReadableUuid) {

        $this->uuidMock->expects($this->phpunit->once())
                        ->method('getHumanReadable')
                        ->will($this->phpunit->returnValue($returnedHumanReadableUuid));

    }

    public function expectsGetHumanReadable_multiple_Success(array $returnedHumanReadableUuids) {

        foreach($returnedHumanReadableUuids as $index => $oneReturnedHumanReadableUuid) {
            $this->uuidMock->expects($this->phpunit->at($index))
                            ->method('getHumanReadable')
                            ->will($this->phpunit->returnValue($oneReturnedHumanReadableUuid));
        }

    }

    public function expectsGet_Success($returnedBinaryUuid) {

        $this->uuidMock->expects($this->phpunit->once())
                        ->method('get')
                        ->will($this->phpunit->returnValue($returnedBinaryUuid));

    }

    public function expectsGet_multiple_Success(array $returnedBinaries) {

        foreach($returnedBinaries as $index => $oneReturnedBinary) {
            $this->uuidMock->expects($this->phpunit->at($index))
                            ->method('get')
                            ->will($this->phpunit->returnValue($oneReturnedBinary));
        }

    }

}

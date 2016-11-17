<?php
namespace iRESTful\LeoPaul\Objects\Libraries\Ids\Tests\Helpers\Adapters;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Adapters\UuidAdapter;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Uuid;
use iRESTful\LeoPaul\Objects\Libraries\Ids\Domain\Uuids\Exceptions\UuidException;

final class UuidAdapterHelper {
    private $phpunit;
    private $uuidAdapterMock;
    public function __construct(\PHPUnit_Framework_TestCase $phpunit, UuidAdapter $uuidAdapterMock) {
        $this->phpunit = $phpunit;
        $this->uuidAdapterMock = $uuidAdapterMock;
    }

    public function expectsFromStringToUuid_Success(Uuid $returnedUuid, $string) {

        $this->uuidAdapterMock->expects($this->phpunit->once())
                                ->method('fromStringToUuid')
                                ->with($string)
                                ->will($this->phpunit->returnValue($returnedUuid));

    }

    public function expectsFromStringToUuid_throwsUuidException($string) {

        $this->uuidAdapterMock->expects($this->phpunit->once())
                                ->method('fromStringToUuid')
                                ->with($string)
                                ->will($this->phpunit->throwException(new UuidException('TEST')));

    }

    public function expectsFromStringsToUuids_Success(array $returnedUuids, array $strings) {

        $this->uuidAdapterMock->expects($this->phpunit->once())
                                ->method('fromStringsToUuids')
                                ->with($strings)
                                ->will($this->phpunit->returnValue($returnedUuids));

    }

    public function expectsFromStringsToUuids_throwsUuidException(array $strings) {

        $this->uuidAdapterMock->expects($this->phpunit->once())
                                ->method('fromStringsToUuids')
                                ->with($strings)
                                ->will($this->phpunit->throwException(new UuidException('TEST')));

    }

    public function expectsFromHumanReadableStringToUuid_Success(Uuid $returnedUuid, $humanReadableUuid) {

        $this->uuidAdapterMock->expects($this->phpunit->once())
                                ->method('fromHumanReadableStringToUuid')
                                ->with($humanReadableUuid)
                                ->will($this->phpunit->returnValue($returnedUuid));

    }

    public function expectsFromHumanReadableStringToUuid_throwsUuidException($humanReadableUuid) {

        $this->uuidAdapterMock->expects($this->phpunit->once())
                                ->method('fromHumanReadableStringToUuid')
                                ->with($humanReadableUuid)
                                ->will($this->phpunit->throwException(new UuidException('TEST')));

    }

    public function expectsFromHumanReadableStringsToUuids_Success(array $returnedUuids, array $humanReadableUuids) {

        $this->uuidAdapterMock->expects($this->phpunit->once())
                                ->method('fromHumanReadableStringsToUuids')
                                ->with($humanReadableUuids)
                                ->will($this->phpunit->returnValue($returnedUuids));

    }

    public function expectsFromHumanReadableStringsToUuids_throwsUuidException(array $humanReadableUuids) {

        $this->uuidAdapterMock->expects($this->phpunit->once())
                                ->method('fromHumanReadableStringsToUuids')
                                ->with($humanReadableUuids)
                                ->will($this->phpunit->throwException(new UuidException('TEST')));

    }

    public function expectsFromBinaryStringToUuid_Success(Uuid $returnedUuid, $binaryUuid) {

        $this->uuidAdapterMock->expects($this->phpunit->once())
                                ->method('fromBinaryStringToUuid')
                                ->with($binaryUuid)
                                ->will($this->phpunit->returnValue($returnedUuid));

    }

    public function expectsFromBinaryStringToUuid_throwsUuidException($binaryUuid) {

        $this->uuidAdapterMock->expects($this->phpunit->once())
                                ->method('fromBinaryStringToUuid')
                                ->with($binaryUuid)
                                ->will($this->phpunit->throwException(new UuidException('TEST')));

    }

    public function expectsFromBinaryStringsToUuids_Success(array $returnedUuids, array $binaryUuids) {

        $this->uuidAdapterMock->expects($this->phpunit->once())
                                ->method('fromBinaryStringsToUuids')
                                ->with($binaryUuids)
                                ->will($this->phpunit->returnValue($returnedUuids));

    }

    public function expectsFromBinaryStringsToUuids_throwsUuidException(array $binaryUuids) {

        $this->uuidAdapterMock->expects($this->phpunit->once())
                                ->method('fromBinaryStringsToUuids')
                                ->with($binaryUuids)
                                ->will($this->phpunit->throwException(new UuidException('TEST')));

    }

    public function expectsFromUuidsToBinaryStrings_Success(array $returnedBinaryUuids, array $uuids) {

        $this->uuidAdapterMock->expects($this->phpunit->once())
                                ->method('fromUuidsToBinaryStrings')
                                ->with($uuids)
                                ->will($this->phpunit->returnValue($returnedBinaryUuids));

    }

    public function expectsFromUuidsToBinaryStrings_throwsUuidException(array $uuids) {

        $this->uuidAdapterMock->expects($this->phpunit->once())
                                ->method('fromUuidsToBinaryStrings')
                                ->with($uuids)
                                ->will($this->phpunit->throwException(new UuidException('TEST')));

    }

    public function expectsFromUuidsToHumanReadableStrings_Success(array $returnedHumanReadableUuids, array $uuids) {

        $this->uuidAdapterMock->expects($this->phpunit->once())
                                ->method('fromUuidsToHumanReadableStrings')
                                ->with($uuids)
                                ->will($this->phpunit->returnValue($returnedHumanReadableUuids));

    }

    public function expectsFromUuidsToHumanReadableStrings_throwsUuidException(array $uuids) {

        $this->uuidAdapterMock->expects($this->phpunit->once())
                                ->method('fromUuidsToHumanReadableStrings')
                                ->with($uuids)
                                ->will($this->phpunit->throwException(new UuidException('TEST')));

    }

}
